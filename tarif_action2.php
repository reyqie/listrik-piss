<?php
	session_start();
	include "connection.php";
	
	$task	= $_GET['task'];
	
	// Input 
	if($task=='insert'){
		if($_POST['price']==0){
			echo "<script>window.alert('Mohon Isikan Harga Perbulan');
			window.history.back()</script>";
			exit();
		}
		//Jika Tarif Ampere sudah ada
		$exist 	= executeScalar("select count(e_tools_id) from e_tools where e_tools_name = '".$_POST['tools']."' ");
		if($exist>0){
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Perlengkapan Sudah Ada, Mohon Dicek Lagi";
			echo "<script>window.location=('tarif2.php')</script>";
			exit();
		}
		else{
			$insert = mysql_query("insert into e_tools (`e_tools_id`, `e_tools_name`, `e_tools_price`) 
			VALUES ('', '".$_POST['tools']."', '".$_POST['price']."')");
			if($insert){
				// Alert Information
				$_SESSION['success'] = true;
				$_SESSION['title'] = 'Berhasil';
				$_SESSION['message'] = "Menambah Perlengkapan Listrik";
				echo "<script>window.location=('tarif2.php')</script>";
				exit();
			}
			else{
				// Alert Information
				$_SESSION['success'] = false;
				$_SESSION['title'] = 'Gagal';
				$_SESSION['message'] = "Menambah Perlengkapan Listrik";
				echo "<script>window.history.back()</script>";
				exit();
			}
		}
	}

	// Update
	elseif($task=='update'){
		$id	= $_GET['id'];
		$update	= mysql_query("update e_tools set e_tools_name = '".$_POST['tools']."', e_tools_price = '".$_POST['price']."' where e_tools_id = '".$id."'");
		if($update){
			// Alert Information
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Update Perlengkapan Listrik";
			echo "<script>window.location=('tarif2.php')</script>";
			exit();
		}
		else{
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Update Perlengkapan Listrik";
			echo "<script>window.history.back()</script>";
			exit();
		}
	}
	
	elseif($task=='delete'){
		$id	= $_GET['id'];
		$delete = mysql_query("delete from e_tools where e_tools_id = '".$id."'");
		if($delete){
			// Alert Information
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Hapus Perlengkapan Listrik";
			echo "<script>window.location=('tarif2.php')</script>";
			exit();
		}
		else{
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Hapus Perlengkapan Listrik";
			echo "<script>window.location=('tarif.php')</script>";
			exit();
		}
	}
?>