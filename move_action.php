<?php
	session_start();
	include "connection.php";
	include "fungsi_thumb.php";
	function executeScalar($sql,$def=0){
		$rs = mysql_query($sql) or die(mysql_error().$sql);
		if (mysql_num_rows($rs)) {$r = mysql_fetch_row($rs);mysql_free_result($rs);return $r[0];}
		return $def;
	}
	$task	= $_GET['task'];
	//$id		= $_POST['id'];
	
	// Input 
	if ($task == 'insert'){
		if($_FILES['fupload']['name']!=''){
			$lokasi_file    = $_FILES['fupload']['tmp_name'];
			$tipe_file      = $_FILES['fupload']['type'];
			$nama_file      = $_FILES['fupload']['name'];
			$acak           = rand(1,99);
			$nama_file_unik = $acak.$nama_file;
			
			if (!empty($lokasi_file)){
				homeImage($nama_file_unik);
				$insert = mysql_query("insert into home(home_id, home_img, home_name)
				values('', '".$nama_file_unik."', '".$_POST['name']."')");
				
				if($insert){
					echo "<script>window.alert('Insert Success');
					window.location=('home.php')</script>";
				}
				else{
					echo "<script>window.alert('Insert Failled');
					window.location=('home.php')</script>";
				}
			}
			else{
				echo "<script>window.alert('Insert Failled');
				window.location=('home.php')</script>";
			}
		}
		else{
			$insert2 = mysql_query("insert into home(home_id, home_name)
			values('', '".$_POST['name']."')");
			
			if($insert2){
				echo "<script>window.alert('Insert Success');
				window.location=('home.php')</script>";
			}
			else{
				echo "<script>window.alert('Insert Failled');
				window.location=('home.php')</script>";
			}
		}
	}

	// Update
	elseif ($task == 'update'){
		$id			= $_GET['id'];
		$date_now 	= date("Y-m-d");
		$lapak 	= executeScalar("select lapak_id from pedagang where id_pedagang='".$id."' ");
		
		$update	= mysql_query("update pedagang set lapak_id	= '".$_POST['akhir']."'
											where id_pedagang = '".$id."'");
		if($update){
			
			$insert = mysql_query("insert into log_lapak(id_log_lapak, id_pedagang, lapak_awal, lapak_akhir, tanggal)
				values('', '".$id."',  '".$lapak."', '".$_POST['akhir']."', '".$date_now."')");
			if($insert){
				echo "<script>window.alert('Pindah Lapak Success');
				window.location=('home.php')</script>";
				exit;
			}
			else{
				echo "<script>window.alert('Pindah Lapak Failled');
				window.location=('home.php')</script>";
				exit;
			}
		}
		else{
			echo "<script>window.alert('Pindah Lapak Failled');
			window.location=('home.php')</script>";
			exit;
		}
	}
	
	elseif ($task == 'delete'){
		$delete = mysql_query("delete home where home_id = '".$id."'");
		if($delete){
			//Writes the photo to the server 
			echo "<script>window.alert('Delete Success');
			window.location=('home.php')</script>";
		}
		else{
			echo "<script>window.alert('Delete Failled');
			window.location=('home.php')</script>";
		}
	}
?>