<?php
	session_start();
	include "connection.php";
	include "components/role_session.php";
?>
<form action="update_password.php?user=<?php echo $_SESSION['username']; ?>" class="form-horizontal" method="post">
	<table class="table table-hover">
		<tbody>
			<tr>
				<td style="border: none;">
					<b>Username</b><br>
					<input style="margin-top: 5px;" type="text" class="form-control" id="nopol" name="nopol" value="<?php echo $_SESSION['username']; ?>" readonly> 
				</td width="70%">
			</tr>
			<tr>
				<td style="border: none;">
					<b>Password Lama</b><br>
					<input style="margin-top: 5px;" type="password" class="col-lg-10 form-control" id="pass" name="pass" placeholder="Password Lama"/>
				</td>
			</tr>
			<tr>
				<td style="border: none;">
					<b>Password Baru</b><br>
					<p><input style="margin-top: 5px;" type="password" class="col-lg-10 form-control" id="pass1" name="pass1" placeholder="Password Baru"/></p><br />
					<p><input style="margin-top: 5px;" type="password" class="col-lg-10 form-control" id="pass2" name="pass2" placeholder="Ulangi Password Baru"/></p>
				</td>
			</tr>
			<tr>
				<td style="border: none;">
					<button type="submit" class="btn btn-block btn-primary">Simpan</button>
				</td>
			</tr>
		</tbody>
	</table>
</form>