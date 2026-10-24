<?php
	session_start();
	include "connection.php";
	include "components/role_session.php";
	
	function headScript(){
		$headScript=file_get_contents("headScript.html");
		return $headScript;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="icon" href="img/logo.png">
	<link rel="shortcut icon" href="img/logo.png" />
    <title> Pengguna Listrik | PISS</title>

	<?php echo headScript(); ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script src="js/jquery.min.js"></script>
	<script language="javascript">
		/* hide all elements & show preloader*/
		document.documentElement.className += 'js';
		/* display variabel */
		var alertLoadProcess = "<span class='alert alert-info' onclick='clearNotif()'><i class='fa fa-spinner fa-spin'></i> Loading...</span>";
		
		//fungsi input hanya angka
		function isNumber(event) {
		  if (event) {
			var charCode = (event.which) ? event.which : event.keyCode;
			if (charCode != 190 && charCode > 31 && 
			   (charCode < 48 || charCode > 57) && 
			   (charCode < 96 || charCode > 105) && 
			   (charCode < 37 || charCode > 40) && 
				charCode != 110 && charCode != 8 && charCode != 46 )
			   return false;
		  }
		  return true;
		}
	</script>
</head>
<body>
    <div id="wrapper">
		<?php include "components/sidebar.php"; ?>

        <div id="page-wrapper">
            <div class="row"><br><br><br><br>
				<?php 
					if($_SESSION['role'] == 'Cashier') { ?>

				<?php } else { ?> 
                <div class="col-lg-12" style="margin-bottom: 10px;">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-pencil fa-fw"></i> Tambah Pengguna Listrik
                        </div>
                        <div class="panel-body">
                            <form action="register_action.php?task=insert"  id="formRegister" name = "formRegister" method="POST" class="form-horizontal">
								<div class="form-group" style="padding: 0 10px;">
									<label>Nama Pengguna Listrik</label>
									<select class="form-control chzn-select" name="mid" id="mid" autofocus="autofocus" required>
										<option value="" selected>-- Pilih Pedagang --</option>
										<?php 
											$sql = mysql_query("select 		merchant_id, 
																			merchant_name, 
																			merchant_nick 
																from 		merchant 
																where 		merchant_status = 'Aktif' 
																order by 	merchant_id, 
																			merchant_nick, 
																			merchant_name");
											while($d = mysql_fetch_array($sql)){
												$lid 	= executeScalar("select lapak_id from rent where merchant_id = '".$d['merchant_id']."' AND rent_sts != 'Batal'");
												$lpk 	= executeScalar("select lapak_name from lapak where lapak_id = '".$lid."'");
												$nick	= executeScalar("select merchant_nick from merchant where merchant_id = '".$d['merchant_id']."'");
												if($nick!=''){
													echo '<option value='.$d['merchant_id'].'>'.$d['merchant_id'].' / '.$d['merchant_nick'].' / '.$d['merchant_name'].' / '.$lpk.'</option>';
												}
												else{
													echo '<option value='.$d['merchant_id'].'>'.$d['merchant_id'].' / '.$d['merchant_name'].' / '.$lpk.'</option>';
												}
											} 
										?>
									</select>
								</div>
								<div class="form-group" style="padding: 0 10px;">
									<label for="sel1">Lapak Listrik Dipasang :</label>
									<select class="form-control" name="lapak" id="lapak">
										<!-- Lapak akan diload menggunakan ajax, dan ditampilkan disini -->
										<option value="" selected disabled>-- Pilih Pedagang Dahulu --</option>
									</select>
								</div>
								<div class="form-group" style="padding: 0 10px;">
									<label>Daya Yang Digunakan</label>
									<select class="form-control" name="tarif" id="tarif" required>
									<option value="" selected disabled>-- Pilih Ampere --</option>
									<?php 
										$sql 	= mysql_query("select * from e_cost order by e_cost_ampere");
										while($d= mysql_fetch_array($sql)){
									?>
										<option value="<?php echo $d['e_cost_id'];?>"><?php echo $d['e_cost_ampere']; ?> Ampere</option>
									<?php } ?>
									</select>
								</div>
								<div class="form-group" style="padding: 0 10px;">
									<label>Petugas Lapangan</label>
									<select class="form-control" name="petugas" id="petugas" required>
									<option value="" selected disabled>-- Pilih Petugas --</option>
									<?php 
										$sql 	= mysql_query("select * from checker where checker_role = 'Kepala Teknisi' OR checker_role = 'Teknisi'");
										while($d= mysql_fetch_array($sql)){
									?>
										<option value="<?php echo $d['checker_id'];?>"><?php echo $d['checker_name']; ?></option>
									<?php } ?>
									</select>
								</div>
								<div class="form-group" style="padding:10px; margin-bottom: 0px;">
									<center><button type="submit" class="btn btn-block btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Simpan</button></center>
								</div>
							</form> 
                        </div>
                    </div>
                </div>
				<?php } ?>
                <div class="col-md-12">
					<div class="panel panel-primary" style="overflow-x: auto">
						<div class="panel-heading">
							<i class="fa fa-group fa-fw"></i> Data Pengguna Listrik
						</div>
						<div class="panel-body">
							<div class="alert alert-warning d-flex align-items-center" role="alert" style="margin: 0 0;">
								<i class="fa fa-warning me-2" style="font-size: 18px;"></i>
								<span style="font-size: 14px;">
									Pedagang yang sudah tidak aktif wajib dihapus dari berlangganan listrik.
								</span>
							</div><br>
							<div id="Area1">
								<div class="alert alert-info" onclick="clearNotif()">
									<center><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></center>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>

	<!-- Modal Edit -->
	<div id="modalEditRegister" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Meload modal "register_modal.php" file -->
			</div>
		</div>
	</div>

	<!-- Modal Delete -->
	<div id="modalDeleteRegister" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Meload modal "register_delete_modal.php" file -->
			</div>
		</div>
	</div>
	
	<script>
    	$(document).ready(function(){
			// Auto Refresh Page
			$("#notifArea").html(alertLoadProcess);
			$('#Area1').load("register_table.php",function(){clearNotif();});
			setTimeout('$("html").removeClass("js")',1000); 
			
			//Modal Nonkomoditi
			$('#modalPerlengkapan').on('shown.bs.modal', function (e) {
				$("#notifArea").html(alertLoadProcess);
				$("#data_perlengkapan").load("modal_perlengkapan.php?",function(){clearNotif();});
			})
			//Modal Ganti Password
			$('#modalPassword').on('shown.bs.modal', function (e) {
				$("#notifArea").html(alertLoadProcess);
				$("#data_password").load("password.php",function(){clearNotif();});
			})

			$("#mid").change(function(){
				// variabel dari nilai combo box pedagang
				var merchant_id = $("#mid").val();
				// alert(merchant_id);
				// Menggunakan ajax untuk mengirim dan dan menerima data dari server
				$.ajax({
					type: "POST",
					dataType: "html",
					url: "ambil-data-lapak.php",
					data: "merchant="+merchant_id,
					success: function(data){
						// alert(data);
						$("#lapak").html(data);
					}
				});
        	});
		});
		function clearNotif(){$("#notifArea").html("");}
		
		//Memanggil modal Perlengkapan
		function perlengkapan(){
			$('#modalPerlengkapan').modal('show');
		}

    </script>
	
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
	<script src="js/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
	<!-- Search Dropdown -->
	<script src="js/plugins/chosen/chosen.jquery.js"></script>
	<script type="text/javascript">
    	$(".chzn-select").chosen({"search_contains": true,"width":"100%", "no_results_text":"Hasil tidak ditemukan !"});
    </script>
	<!-- Sweet Alert -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
		<?php
			// Menampilkan SweetAlert jika session success ada dan bernilai true
			if (isset($_SESSION['success'])) {
				$title = $_SESSION['title'];
				$message = $_SESSION['message'];
				$icon = $_SESSION['success'] ? 'success' : 'error';
				echo "<script>
					Swal.fire({
						title: '$title',
						text: '$message',
						icon: '$icon'
					});
				</script>";
				unset($_SESSION['success']);
				unset($_SESSION['message']);
			}
		?>
</body>
</html>