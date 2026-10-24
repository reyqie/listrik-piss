<?php
	session_start();
	include "connection.php";
	include "fungsi_thumb.php";
	
	$task	= $_GET['task'];
	//$id		= $_POST['id'];
	
	// Input 
	if ($task == 'insert'){
		$exist 	= executeScalar("select count(block_id) from block where block_id = '".$_POST['block']."' ");
		
		if($exist>0||$_POST['block']==''){
			echo "<script>window.alert('Nama Block Sudah Ada, Mohon Dicek Lagi');
			window.history.back()</script>";
			exit();
		}
		else{
			$insert = mysql_query("INSERT INTO `pios`.`block` (`block_id`, `block_max`, `block_type`) 
			VALUES ('".$_POST['block']."', '".$_POST['max']."', '".$_POST['type']."')");
			
			if($insert){
				echo "<script>window.location=('block.php')</script>";
				exit();
			}
			else{
				echo "<script>window.alert('Data Gagal Masuk');
				window.history.back()</script>";
				exit();
			}
		}
	}

	// Update
	elseif ($task == 'update'){
		$id		= $_GET['id'];
		$update	= mysql_query("update block set block_max	= '".$_POST['max']."',
											block_type 		= '".$_POST['type']."'
											where block_id 	= '".$id."'");
		if($update){
			echo "<script>window.location=('block.php')</script>";
			exit();
		}
		else{
			echo "<script>window.alert('Update Data Gagal');
			window.history.back()</script>";
			exit();
		}
	}
	
	elseif ($task == 'delete'){
		//$delete = mysql_query("delete block where block_id = '".$id."'");
		if($delete){
			echo "<script>window.location=('block.php')</script>";
			exit();
		}
		else{
			echo "<script>window.alert('Delete Failled');
			window.location=('block.php')</script>";
			exit();
		}
	}
?>