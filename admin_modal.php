<?php
	session_start();
	include "connection.php";
	include "components/role_session.php";
	
	$adminID = $_GET['id'];
	$username = executeScalar("select username from admin where id_admin = '".$adminID."'");
	$name = executeScalar("select name from admin where id_admin = '".$adminID."'");
	$pass = executeScalar("select password from admin where id_admin = '".$adminID."'");
	$position = executeScalar("select role from admin where id_admin = '".$adminID."'");
?>

<div class="modal-header bg-primary text-white" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
	<h4 style="margin-left: 20px;"><i class="fa fa-edit fa-fw"></i>&nbsp;Edit Data SPV / PP </h4>
	<button style="margin-top: -35px; margin-right: 20px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
	<form class="form-horizontal" id="formAdmin" name = "formAdmin" method="POST" action="admin_action.php?task=update&id=<?php echo $adminID; ?>">
		<div class="form-group" style="padding:10px; margin-left:10px; margin-right: 10px; margin-top:-10px;">
			<label>Username SPV / PP </label>
			<input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" placeholder="Username SPV / PP " autofocus="autofocus" required/>                  
		</div>
		<div class="form-group" style="padding:10px; margin-left:10px; margin-right: 10px; margin-top:-10px;">
			<label>Nama SPV / PP </label>
			<input class="form-control" id="name" name="name" type="text" value="<?php echo $name; ?>" placeholder="Masukkan nama SPV / PP " required/>
		</div>
		<div class="form-group" style="padding:10px; margin-left:10px; margin-right: 10px; margin-top:-10px;">
			<label>Password</label>
			<input class="form-control" id="pass" name="pass" type="text" value="<?php echo $pass; ?>" placeholder="Masukkan password" required/>
		</div>
		<div class="form-group" style="padding:10px; margin-left:10px; margin-right: 10px; margin-top:-10px;">
			<label>Posisi</label>
			<select class="form-control" name="position" id="position" required>
				<option value="spv" <?php echo $position == 'spv' ? 'selected' : '';?>>SPV</option>
				<option value="pp" <?php echo $position == 'pp' ? 'selected' : '';?>>PP</option>
				<option value="keuangan" <?php echo $position == 'keuangan' ? 'selected' : '';?>>Keuangan</option>
			</select>
		</div>
		<div class="form-group" style="padding:10px; margin-top:-10px; margin-left:10px; margin-right: 10px;">
			<button type="submit" class="btn btn-outline btn-primary btn-block btn-sm" style="font-size: 14px;"><i class="fa fa-floppy-o fa-fw" style="font-size: 16px;"></i>&nbsp;Simpan</button>                   
		</div>
	</form>
	<input type="hidden" id="value_id" />
</div>