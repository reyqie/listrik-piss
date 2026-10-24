<?php
	session_start();
	include "connection.php";

	$task		= $_GET['task'];
	//======================================= START INSERT DATA ===========================================
	if ($task == 'insert'){
		//Cek Apakah Pedagang Sudah Daftar/Blm
		$ada 	= executeScalar("	select 	count(merchant_id) 
									from 	electricity 
									where 	merchant_id = '".$_POST['mid']."' AND 
											id_lapak_dipasang = '".$_POST['lapak']."'");
		if($ada>0){
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Pedagang sudah terdaftar";
			echo "<script>
			window.location=('register.php')</script>";
			exit();
		}
		if($_POST['mid']==null||$_POST['tarif']==null||$_POST['lapak']==null){
			echo "<script>window.alert('Nama Pedagang / Lapak / Tarif Belum Dipilih');
			window.history.back()</script>";
			exit();
		}
		$insert = mysql_query("	insert into electricity(	electricity_id, 
															merchant_id,
															id_lapak_dipasang, 
															id_petugas,
															e_cost_id, 
															electricity_sts, 
															register_date, 
															electricity_detail) 
								VALUES ('', 
										'".$_POST['mid']."',
										'".$_POST['lapak']."',
										'".$_POST['petugas']."', 
										'".$_POST['tarif']."', 
										'Aktif', 
										'".$date_now."', 
										'')");
		
		if($insert){
			$update	= mysql_query("	update	merchant 
									set 	merchant_electricity = 'Yes' 
									where 	merchant_id = '".$_POST['mid']."'");
			
			// Alert Information
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Menambah Pengguna Listrik";
			echo "<script>window.location=('register.php')</script>";
			exit();
		}
		else{
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Menambah Pengguna Listrik";
			echo "<script>
			window.history.back()</script>";
			exit();
		}
		
	}

	//Update
	elseif ($task == 'update'){
		$id		= $_GET['id'];
		
		$update	= mysql_query("	update 	electricity 
								set 	e_cost_id			= '".$_POST['tarif']."',
										id_lapak_dipasang	= '".$_POST['lapak']."',
										id_petugas			= '".$_POST['petugas']."',
										electricity_sts 	= '".$_POST['status']."'
								where 	electricity_id 		= '".$id."'");
		if($update){
			// Alert Information
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Update Pengguna Listrik";
			echo "<script>window.location=('register.php?id=$id')</script>";
			exit;
		}
		else{
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Update Pengguna Listrik";
			echo "<script>
			window.history.back()</script>";
			exit;
		}
	}
	
	elseif($task == 'acc'){
		// ambil id pemohon
		$id		= $_GET['id'];
		//Jika DP > total
		$lapak 	= executeScalar("select lapak_id from request where req_id = '".$id."'");
		$total 	= executeScalar("select lapak_total from lapak where lapak_id = '".$lapak."'");
		//Jika DP lebih besar dari total bayar
		if($_POST['dp']>$total||$_POST['dp']==''||$_POST['dp']==0){
			echo "<script>window.alert('Uang Muka Salah Input, Coba Cek Lagi');
			window.history.back()</script>";
			exit();
		}
		//Cek status lapak yg diinginkan
		$lid 	= executeScalar("select lapak_id from request where req_id = '".$id."'");
		$sts 	= executeScalar("select lapak_status from lapak where lapak_id = '".$lid."'");
		if($sts!='Terisi'){
			$read	= mysql_query("select * from request where req_id = '".$id."'");
			while($r= mysql_fetch_array($read)){
				//Insert data ke table pedagang
				$insert1 = mysql_query("INSERT INTO `pios`.`merchant` (`merchant_id`, `merchant_name`, `merchant_nick`, 
				`phone1`, `phone2`, `address1`, `address2`, `nid_ktp`, `nid_sim`, `nid_lain`, `nid_type`, 
				`merchant_type`, `merchant_status`) 
				VALUES ('', '".$r['req_name']."', '".$r['req_nick']."', '".$r['phone1']."', '".$r['phone2']."', 
				'".$r['address1']."', '".$r['address2']."', '".$r['nid_ktp']."', '".$r['nid_sim']."', '".$r['nid_lain']."', 
				'".$r['nid_type']."', '".$r['merchant_type']."', 'Aktif')");
				
				//Ambil id merchant yg barusan masuk
				$mid 	= mysql_insert_id();
				if($insert1){
					//baca data lapak yg dipilih oleh pedagang
					$total 	= executeScalar("select lapak_total from lapak where lapak_id = '".$lid."'");
					
					//kekurangan biaya rent
					$leftover 	= 0;
					$instalment	= 0;
					$leftover 	= $total-$_POST['dp'];
					$instalment	= $leftover/24;
					//Insert data transaksi ke table rent
					$insert2 	= mysql_query("INSERT INTO `pios`.`rent` (`rent_id`, `req_id`, `merchant_id`, 
					`lapak_id`, `rent_total`, `rent_dp`, `leftover`, `rent_instalment`, `rent_date`, `rent_desc`) 
					VALUES ('', '".$id."', '".$mid."', '".$lid."', '".$total."', '".$_POST['dp']."', 
					'".$leftover."', '".$instalment."', '".$date_now."', '".$_POST['ket']."')");
					
					$rid 	= mysql_insert_id();
					if($insert2){
						//Ubah status lapak
						$update1	= mysql_query("update lapak set lapak_status = 'Terisi' where lapak_id = '".$lid."'");
						//hapus data pemohon yg sudah d acc
						//mysql_query("delete request where request_id = '".$id."'");
						
						if($update1){
							//Ubah status Pemohon
							$update2	= mysql_query("update request set req_status = 'Disetujui' where req_id = '".$id."'");
							
							if($update2){
								//pergi ke halaman cetak form perizinan
								//echo "<script>window.location=('htmltopdf/persetujuan_pedagang.php?id=$rid')</script>";
								echo "<script>window.location=('register_view')</script>";
								exit();
							}
							else{
								echo "<script>window.alert('Data Gagal Masuk 1');
								window.history.back()</script>";
								exit();
							}
						}
						else{
							echo "<script>window.alert('Data Gagal Masuk 1');
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
					echo "<script>window.alert('Data Gagal Masuk 3');
					window.history.back()</script>";
					exit();
				}
			}
		}
		else{
			echo "<script>window.alert('Lapak Sudah Terisi, Coba Cek Sekali Lagi');
			window.history.back()</script>";
			exit();
		}
	}
	
	elseif ($task == 'delete'){
		$id		= $_GET['id'];
		$dateNow = date('Y-m-d');

		$delete = mysql_query("delete from electricity where electricity_id = '".$id."'");
		if($delete){
			$updatePay = mysql_query("update e_pay set
										cancel_date = '".$date_now."',
										pay_sts = 'Batal'
										where electricity_id = '".$id."'
										and pay_date is NULL");

			// Alert Information
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Hapus pengguna listrik";
			echo "<script>
			window.location=('register.php')</script>";
		}
		else{
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Hapus pengguna listrik";
			echo "<script>
			window.location=('register.php')</script>";
		}
	}
?>