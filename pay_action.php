<?php
	session_start();
	include "connection.php";
	
	$task	= $_GET['task'];
	//$id	= $_POST['id'];
	
	//Input Pembayaran
	if ($task=='insert'){
		$id		= $_GET['id'];
		$insert = mysql_query("update e_pay set `pay_date`	= '".$_POST['pay_date']."', 
												`pay_sts`	= 'Lunas'
											where pay_id 	= '".$id."'");
		if($insert){
			// Alert Information
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Melakukan Pembayaran tagihan";
			echo "<script>
			window.location=('pay.php')</script>";
			exit();
		}
		else{
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Melakukan pembayaran tagihan";
			echo "<script>
			window.history.back()</script>";
			exit();
		}
	}
	
	//Pembatalan Pembayaran
	if ($task=='batal'){
		$id		= $_GET['id'];
		$update = mysql_query("update e_pay set `pay_date` 	= null,
												`pay_sts` 	= 'Belum Lunas' 
											where pay_id 	= '".$id."'");
		if($update){
			// Alert Information
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Melakukan pembatalan pembayaran";
			echo "<script>
			window.location=('pay_cancel.php')</script>";
			exit();
		}
		else{
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'gagal';
			$_SESSION['message'] = "Melakukan pembatalan pembayaran";
			echo "<script>
			window.history.back()</script>";
			exit();
		}
	}
	
	//Pembatalan Tagihan
	if ($task=='absen'){
		$id		= $_GET['id'];
		$insert = mysql_query("update e_pay set `pay_date` 	= null, 
											`cancel_date` 	= '".$date_now."',
												`pay_sts` 	= 'Batal' 
											where pay_id 	= '".$id."'");
		if($insert){
			// Alert Information
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Membuat Tagihan Menjadi Off";
			echo "<script>
			window.location=('invoice.php')</script>";
			exit();
		}
		else{
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Membuat Tagihan Menjadi Off";
			echo "<script>
			window.location=('invoice.php')</script>";
			exit();
		}
	}
	
	//Aktifkan Pembayaran
	if ($task=='active'){
		$id		= $_GET['id'];
		$insert = mysql_query("update e_pay set `pay_date` 	= null, 
											`cancel_date` 	= '".$date_now."',
												`pay_sts` 	= 'Belum Lunas' 
											where pay_id 	= '".$id."'");
		if($insert){
			// Alert Information
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Aktifkan tagihan";
			echo "<script>
			window.location=('invoice_cancel.php')</script>";
			exit();
		}
		else{
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Aktifkan tagihan";
			echo "<script>
			window.location=('invoice_cancel.php')</script>";
			exit();
		}
	}
?>