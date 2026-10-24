<?php
	session_start();
	include "connection.php";

	$update	= mysql_query("update note set note_text = '".$_POST['note']."' where note_id = '".$_GET['id']."'");
	if($update){
		// Alert Information
		$_SESSION['success'] = true;
		$_SESSION['title'] = 'Berhasil';
		$_SESSION['message'] = "Membuat catatan pelanggan";
		echo "<script>window.location=('note.php')</script>";
		exit();
	}
	else{
		// Alert Information
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Membatalkan tagihan";
		echo "<script>window.alert('Data Gagal Masuk');
		window.history.back()</script>";
		exit();
	}
?>