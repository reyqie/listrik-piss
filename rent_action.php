<?php
	session_start();
	include "connection.php";
	//include "fungsi_thumb.php";
	
	$date_now	= date("Y-m-d");
	$task		= $_GET['task'];
	//$id		= $_POST['id'];
	
	// Input 
	if ($task == 'insert'){
		$ktp 	= executeScalar("select nid_ktp from merchant where nid_ktp = '".$_POST['ktp']."'");
		$sim 	= executeScalar("select nid_sim from merchant where nid_sim = '".$_POST['ktp']."'");
		$lain 	= executeScalar("select nid_lain from merchant where nid_lain = '".$_POST['lain']."'");
		//Jika ktp tidak ada yg sama
		if($ktp>0||$sim>0||$lain>0){
			echo "<script>window.alert('No ID Pedagang sudah ada, mohon dicek lagi');
			window.history.back()</script>";
			exit();
		}
		else{
			//jika adrs2 kosong
			if($_POST['adrs2']==''){
				$adrs2 = $_POST['adrs1'];
			}
			else{
				$adrs2 = $_POST['adrs2'];
			}
			$insert = mysql_query("INSERT INTO `pios`.`merchant` (`merchant_id`, `merchant_name`, `merchant_nick`, 
			`merchant_phone1`, `merchant_phone2`, `address1`, `address2`, `nid_ktp`, `nid_sim`, `nid_lain`, 
			`nid_type`, `merchant_type`, `merchant_status`) 
			VALUES ('', '".$_POST['name1']."', '".$_POST['name2']."', '".$_POST['tlp1']."', '".$_POST['tlp2']."',
			'".$_POST['adrs1']."', '".$adrs2."', '".$_POST['ktp']."', '".$_POST['sim']."', '".$_POST['lain']."', 
			'".$_POST['nid']."', '".$_POST['type']."', 'Baru')");
			//$merchant = mysql_insert_id();
			if($insert){
				// mendapatkan nomor orders Sebelumnya (yg diinsert barusan)
				$merchant 	= mysql_insert_id();
				$total 		= executeScalar("select lapak_total from lapak where lapak_id = '".$_POST['lapak']."'");
				$leftover 	= 0;
				$instament 	= 0;
				$leftover 	= $total-$_POST['dp'];
				$instalment = $leftover/24;
				$insert2 	= mysql_query("INSERT INTO `pios`.`rent` (`rent_id`, `merchant_id`, `lapak_id`, 
				`rent_total`, `rent_dp`, `leftover`, `rent_instalment`, `rent_date`, `rent_desc`) 
				VALUES ('', '".$merchant."', '".$_POST['lapak']."', '".$total."', '".$_POST['dp']."',
				'".$leftover."', '".$instalment."', '".$date_now."', '".$_POST['ket']."')");
				if($insert2){
					$update	= mysql_query("update lapak set lapak_status = 'Terisi' where lapak_id = '".$_POST['lapak']."'");
					if($update){
						echo "<script>window.location=('merchant.php')</script>";
						exit();
					}
					else{
						echo "<script>window.alert('Update Data Gagal');
						window.history.back()</script>";
						exit();
					}
				}
				else{
					echo "<script>window.alert('Data Gagal Masuk 2');
					window.history.back()</script>";
					exit();
				}
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
		$id			= $_GET['id'];
			$check		= mysql_query("select photo from employee where employee_id = ".$id." ");                
		
			if (!empty($lokasi_file)){
				$delete	= $data['photo'];
				unlink("employee/".$delete."");
				unlink("employee/small_".$delete."");
				employeeImage($nama_file_unik);
				$update	= mysql_query("update employee set employee_name= '".$_POST['name']."',
														job_title 		= '".$_POST['job']."',
														education 		= '".$_POST['edu']."',
														photo			= '".$nama_file_unik."'
													where employee_id 	= '".$id."'");
				if($update){
					echo "<script>window.alert('".$task." Pict Success');
					window.location=('employee.php')</script>";
					exit;
				}
				else{
					echo "<script>window.alert('".$task." pict ".$id." Fail');
					window.location=('employee.php')</script>";
					exit;
				}
			}
			else{
				$update2 = mysql_query("update employee set employee_name= '".$_POST['name']."',
														job_title 		= '".$_POST['job']."',
														education 		= '".$_POST['edu']."',
													where employee_id 	= '".$id."'");
				if($update2){
					//Writes the photo to the server 
					echo "<script>window.alert('".$task." Success Without pict');
					window.location=('employee.php')</script>";
				}
				else{
					echo "<script>window.alert('".$task." Failled Without pict');
					window.location=('employee.php')</script>";
				}
			}
	}
	
	elseif ($task == 'delete'){
		$delete = mysql_query("delete employee where employee_id = '".$id."'");
		if($delete){
			//Writes the photo to the server 
			echo "<script>window.alert('Delete Success');
			window.location=('employee.php')</script>";
		}
		else{
			echo "<script>window.alert('Delete Failled');
			window.location=('employee.php')</script>";
		}
	}
?>