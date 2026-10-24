<?php
	session_start();
	include "connection.php";
	//Validasi role
	if($_SESSION['role']==''){
		header("Location:index.php");
	}
	$task	= $_GET['task'];
	
	
	// Input 
	if ($task == 'insert'){
		$month	= substr($_POST['periode'], 0, 2);
		$year	= substr($_POST['periode'], 2, 4);
		$ada	= executeScalar("select count(periode_id) from e_periode 
		where periode_month = '".$month."' and periode_year = '".$year."'");
		//Jika periode sudah Ada d database
		if($month=='01'){
			$bulan = 'Januari';
		}if($month=='02'){
			$bulan = 'Februari';
		}if($month=='03'){
			$bulan = 'Maret';
		}if($month=='04'){
			$bulan = 'April';
		}if($month=='05'){
			$bulan = 'Mei';
		}if($month=='06'){
			$bulan = 'Juni';
		}if($month=='07'){
			$bulan = 'Juli';
		}if($month=='08'){
			$bulan = 'Agustus';
		}if($month=='09'){
			$bulan = 'September';
		}if($month=='10'){
			$bulan = 'Oktober';
		}if($month=='11'){
			$bulan = 'November';
		}if($month=='12'){
			$bulan = 'Desember';
		}
		
		$name	= $bulan.' '.$year;
		
		if($ada==0){
			$insert = mysql_query("insert into e_periode (`periode_id`, `periode_name`, `periode_month`, `periode_year`) 
			VALUES ('', '".$name."', '".$month."', '".$year."')");
			
			if($insert){
				// Alert Information
				$_SESSION['success'] = true;
				$_SESSION['title'] = 'Berhasil';
				$_SESSION['message'] = "Menambahkan periode tagihan";
				echo "<script>window.location=('periode.php')</script>";
				exit();
			}else{
				// Alert Information
				$_SESSION['success'] = false;
				$_SESSION['title'] = 'Gagal';
				$_SESSION['message'] = "Menambahkan pengguna listrik";
				echo "<script>
				window.location=('periode.php')</script>";
				exit();
			}
		}
		else{
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Periode sudah ada";
			echo "<script>
			window.location=('periode.php')</script>";
			exit();
		}
	}

	// Update
	// elseif ($task == 'update'){
	// 	$id	= $_GET['id'];
	// 	if($_POST['adrs2']==''){
	// 		$adrs2 = $_POST['adrs1'];
	// 	}
	// 	else{
	// 		$adrs2 = $_POST['adrs2'];
	// 	}
		
	// 	$update	= mysql_query("update request set lapak_id	= '".$_POST['lapak']."',
	// 											req_name 	= '".$_POST['name1']."',
	// 											req_nick 	= '".$_POST['name2']."',
	// 											phone1 		= '".$_POST['tlp1']."',
	// 											phone2 		= '".$_POST['tlp2']."',
	// 											address1 	= '".$_POST['adrs1']."',
	// 											address2 	= '".$_POST['adrs2']."',
	// 											nid_ktp 	= '".$_POST['ktp']."',
	// 											nid_sim 	= '".$_POST['sim']."',
	// 											nid_lain 	= '".$_POST['lain']."',
	// 											nid_type 	= '".$_POST['nid']."',
	// 										merchant_type 	= '".$_POST['type']."'
	// 										where req_id 	= '".$id."'");
	// 	if($update){
	// 		echo "<script>window.location=('register_edit.php?id=$id')</script>";
	// 		exit;
	// 	}
	// 	else{
	// 		echo "<script>window.alert('Update Failled');
	// 		window.history.back()</script>";
	// 		exit;
	// 	}
	// }
	
	// elseif($task == 'ok'){
	// 	$id 	= $_GET['id'];
	// 	//Ubah status pemohon
	// 	//$update	= mysql_query("update request set req_status = 'Direview' where req_id = '$id'");
		
	// 	if($update){
	// 		//pergi ke halaman persetujuan Permohonan
	// 		echo "<script>window.location=('register_acc.php?id=$id')</script>";
	// 		exit();
	// 	}
	// 	else{
	// 		echo "<script>window.alert('Data Gagal Masuk');
	// 		window.history.back()</script>";
	// 		exit();
	// 	}
	// }
	
	// elseif($task == 'acc'){
	// 	// ambil id pemohon
	// 	$id		= $_GET['id'];
	// 	//Jika DP > total
	// 	$lapak 	= executeScalar("select lapak_id from request where req_id = '".$id."'");
	// 	$total 	= executeScalar("select lapak_total from lapak where lapak_id = '".$lapak."'");
	// 	//Jika DP lebih besar dari total bayar
	// 	if($_POST['dp']>$total||$_POST['dp']==''||$_POST['dp']==0){
	// 		echo "<script>window.alert('Uang Muka Salah Input, Coba Cek Lagi');
	// 		window.history.back()</script>";
	// 		exit();
	// 	}
	// 	//Cek status lapak yg diinginkan
	// 	$lid 	= executeScalar("select lapak_id from request where req_id = '".$id."'");
	// 	$sts 	= executeScalar("select lapak_status from lapak where lapak_id = '".$lid."'");
	// 	if($sts!='Terisi'){
	// 		$read	= mysql_query("select * from request where req_id = '".$id."'");
	// 		while($r= mysql_fetch_array($read)){
	// 			//Insert data ke table pedagang
	// 			$insert1 = mysql_query("INSERT INTO `pios`.`merchant` (`merchant_id`, `merchant_name`, `merchant_nick`, 
	// 			`phone1`, `phone2`, `address1`, `address2`, `nid_ktp`, `nid_sim`, `nid_lain`, `nid_type`, 
	// 			`merchant_type`, `merchant_status`) 
	// 			VALUES ('', '".$r['req_name']."', '".$r['req_nick']."', '".$r['phone1']."', '".$r['phone2']."', 
	// 			'".$r['address1']."', '".$r['address2']."', '".$r['nid_ktp']."', '".$r['nid_sim']."', '".$r['nid_lain']."', 
	// 			'".$r['nid_type']."', '".$r['merchant_type']."', 'Aktif')");
				
	// 			//Ambil id merchant yg barusan masuk
	// 			$mid 	= mysql_insert_id();
	// 			if($insert1){
	// 				//baca data lapak yg dipilih oleh pedagang
	// 				$total 	= executeScalar("select lapak_total from lapak where lapak_id = '".$lid."'");
					
	// 				//kekurangan biaya rent
	// 				$leftover 	= 0;
	// 				$instalment	= 0;
	// 				$leftover 	= $total-$_POST['dp'];
	// 				$instalment	= $leftover/24;
	// 				//Insert data transaksi ke table rent
	// 				$insert2 	= mysql_query("INSERT INTO `pios`.`rent` (`rent_id`, `req_id`, `merchant_id`, 
	// 				`lapak_id`, `rent_total`, `rent_dp`, `leftover`, `rent_instalment`, `rent_date`, `rent_desc`) 
	// 				VALUES ('', '".$id."', '".$mid."', '".$lid."', '".$total."', '".$_POST['dp']."', 
	// 				'".$leftover."', '".$instalment."', '".$date_now."', '".$_POST['ket']."')");
					
	// 				$rid 	= mysql_insert_id();
	// 				if($insert2){
	// 					//Ubah status lapak
	// 					$update1	= mysql_query("update lapak set lapak_status = 'Terisi' where lapak_id = '".$lid."'");
	// 					//hapus data pemohon yg sudah d acc
	// 					//mysql_query("delete request where request_id = '".$id."'");
						
	// 					if($update1){
	// 						//Ubah status Pemohon
	// 						$update2	= mysql_query("update request set req_status = 'Disetujui' where req_id = '".$id."'");
							
	// 						if($update2){
	// 							//pergi ke halaman cetak form perizinan
	// 							//echo "<script>window.location=('htmltopdf/persetujuan_pedagang.php?id=$rid')</script>";
	// 							echo "<script>window.location=('register_view')</script>";
	// 							exit();
	// 						}
	// 						else{
	// 							echo "<script>window.alert('Data Gagal Masuk 1');
	// 							window.history.back()</script>";
	// 							exit();
	// 						}
	// 					}
	// 					else{
	// 						echo "<script>window.alert('Data Gagal Masuk 1');
	// 						window.history.back()</script>";
	// 						exit();
	// 					}
	// 				}
	// 				else{
	// 					echo "<script>window.alert('Data Gagal Masuk 2');
	// 					window.history.back()</script>";
	// 					exit();
	// 				}
	// 			}
	// 			else{
	// 				echo "<script>window.alert('Data Gagal Masuk 3');
	// 				window.history.back()</script>";
	// 				exit();
	// 			}
	// 		}
	// 	}
	// 	else{
	// 		echo "<script>window.alert('Lapak Sudah Terisi, Coba Cek Sekali Lagi');
	// 		window.history.back()</script>";
	// 		exit();
	// 	}
	// }
	
	// elseif ($task == 'delete'){
	// 	$delete = mysql_query("delete request where request_id = '".$id."'");
	// 	if($delete){
	// 		//Writes the photo to the server 
	// 		echo "<script>window.alert('Delete Success');
	// 		window.location=('request.php')</script>";
	// 	}
	// 	else{
	// 		echo "<script>window.alert('Delete Failled');
	// 		window.location=('request.php')</script>";
	// 	}
	// }
?>