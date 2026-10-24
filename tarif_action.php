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
		$exist 	= executeScalar("select count(e_cost_id) from e_cost where e_cost_ampere = '".$_POST['ampere']."' ");
		if($exist>0){
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Tarif Sudah Ada, Mohon Dicek Lagi";
			echo "<script>window.location=('tarif.php')</script>";
			exit();
		}
		else{
			$insert = mysql_query("insert into e_cost (`e_cost_id`, `e_cost_ampere`, `e_cost_price`) 
			VALUES ('', '".$_POST['ampere']."', '".$_POST['price']."')");
			if($insert){
				// Alert Information
				$_SESSION['success'] = true;
				$_SESSION['title'] = 'Berhasil';
				$_SESSION['message'] = "Menambah biaya listrik";
				echo "<script>window.location=('tarif.php')</script>";
				exit();
			}
			else{
				// Alert Information
				$_SESSION['success'] = false;
				$_SESSION['title'] = 'Gagal';
				$_SESSION['message'] = "Menambah biaya listrik";
				echo "<script>window.history.back()</script>";
				exit();
			}
		}
	}

	// Update
	elseif($task=='update'){
		$id	= $_GET['id'];
		$update	= mysql_query("update e_cost set e_cost_price = '".$_POST['price']."' where e_cost_id = '".$id."'");
		if($update){
			// Alert Information
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Update biaya listrik";
			echo "<script>window.location=('tarif.php')</script>";
			exit();
		}
		else{
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Update biaya listrik";
			echo "<script>window.history.back()</script>";
			exit();
		}
	}
	
	elseif($task=='delete'){
		//$delete = mysql_query("delete tarif where lapak_id = '".$id."'");
		if($delete){
			echo "<script>window.location=('tarif.php')</script>";
			exit();
		}
		else{
			echo "<script>window.alert('Delete Failled');
			window.location=('tarif.php')</script>";
			exit();
		}
	}
?>