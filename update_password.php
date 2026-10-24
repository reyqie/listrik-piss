<?php
	session_start();
	include "connection.php";
	//Validasi role
	if($_SESSION['role']==''){
		header("Location:index.php");
	}
	
	$pass	= $_POST['pass'];
	$pass1	= $_POST['pass1'];
	$pass2	= $_POST['pass2'];
	$pass3	= executeScalar("select password from admin where username = '".$_SESSION['user']."'");
	
	if($pass==$pass3){
		if($pass1==$pass2){
		// Update pass
			$update = mysql_query("update admin set password = '".$pass2."' where username = '".$_SESSION['user']."'");
			if($update) {
				echo "<script>window.alert('Ganti Password Berhasil');
				window.location=('logout.php')</script>";
				exit();
			}
			else {
				echo "<script>window.alert('Ganti Password Gagal');
				window.history.back()</script>";
				exit();
			}
		}
		else{
			echo "<script>window.alert('Password Baru Anda Tidak Sama');
			window.history.back()</script>";
			exit();
		}
	}
	else{
		echo "<script>window.alert('Password Lama Anda Salah');
		window.history.back()</script>";
		exit();
	}
?>
