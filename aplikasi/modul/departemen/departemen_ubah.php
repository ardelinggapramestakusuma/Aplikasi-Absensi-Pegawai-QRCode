<?php
if (!defined('nsi')) { exit(); }

$id = $_GET['id'];

$query = "SELECT * FROM `m_departemen` WHERE `id` = '".$id."' ";
$row = $db->select_one($query);
if(!$row) {
	set_notif('data_tidak_ada', 1);
	redirect('?m=departemen');
}

$form_error = array();
if(isset($_POST['submit'])) {
	$data_arr = array();
	if(trim($_POST['nama_departemen']) == '') {
		$form_error[] = 'Nama Departemen harus diisi';
	}
	if(trim($_POST['keterangan']) == '') {
		$form_error[] = 'Keteranagan harus diisi';
	}
	if(empty($form_error)) {
		// ubah db
		$data = array(
				'nama_departemen' 	=> $_POST['nama_departemen'],
				'keterangan'		=> $_POST['keterangan'],
				'aktif' 			=> $_POST['aktif']
			);
		$where = array('id' => $id);
		$update = $db->ubah('m_departemen', $data, $where);
		if($update) {
			set_notif('ubah_ok', 1);
			redirect('?m=departemen');
		} else {
			$form_error[] = 'Tidak dapat disimpan dalam database';
		}
	}
}

$web['judul'] = 'Ubah Data Departemen';
load_script('select2');
view_layout('v_atas.php');

?>

<div class="row">
	<div class="col-md-12">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title">Ubah Data Departemen</h3>
				<div class="box-tools pull-right">
					<button data-widget ="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
				</div><!-- /.box-tools -->
			</div><!-- /.box-header -->

			<form method="POST">
				<div class="box-body">
					<?php if($form_error) { ?>
						<div id="alert-simpan" class="alert alert-danger alert-dismissable fade in">
							<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
							<h4><i class="fa fa-warning"></i> Error, Data tidak dapat disimpan.</h4>
							<?php 
								foreach ($form_error as $val) {
									echo '<p>'.$val.'</p>';
								} 
							?>
						</div>					
					<?php } ?>

					<div class="form-group">
						<label for="nama_departemen">Nama Departemen</label>
						<input type="text" placeholder="Masukkan Nama Departemen" id="nama_departemen" name="nama_departemen" value="<?php echo $row->nama_departemen;?>" class="form-control">
					</div>

					<div class="form-group">
						<label for="keterangan">Keterangan</label>
						<input type="text" placeholder="Masukkan Keterangan" id="keterangan" name="keterangan" value="<?php echo $row->keterangan;?>"class="form-control">
					</div>


					<div class="form-group">
						<label>Aktif</label>
						<br />
						<select id="aktif" name="aktif" class="form-control select2" style="width: 70px;">
							<option value="Y" <?php echo $row->aktif == 'Y' ? 'selected="selected"' : ''; ?>>Ya</option>
							<option value="T" <?php echo $row->aktif == 'T' ? 'selected="selected"' : ''; ?>>Tidak</option>
						</select>
					</div>


				</div><!-- /.box-body -->
				<div class="box-footer">
					<input type="submit" name="submit" class="btn btn-primary" value="Ubah" />
					<a href="<?php echo site_url('?m=departemen');?>" class="btn btn-default pull-right">Batal</a>
				</div>
			</form>

		</div><!-- /.box -->
	</div>
</div>



<?php view_layout('v_bawah1.php'); ?>

<script type="text/javascript">
	$(function() {
		$('#nama').focus();
		$('.select2').select2();
	});
</script>
<?php
view_layout('v_bawah2.php');