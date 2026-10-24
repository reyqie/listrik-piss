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
		<title>Cetak Tagihan | PISS</title>

		<?php echo headScript(); ?>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script src="js/jquery.min.js"></script>
		<script>
			/* hide all elements & show preloader*/
			document.documentElement.className += 'js';

			/* display variabel */
			var alertLoadProcess = "<span class='alert alert-danger' onclick='clearNotif()'><i class='fa fa-spinner fa-spin'></i> Loading...</span>";
		</script>
	</head>
	<body>
		<div id="wrapper">
			<?php include "components/sidebar.php"; ?>

			<div id="page-wrapper">
				<div class="row"><br><br><br>
					<div class="col-lg-12">
						<br />
						<div class="panel panel-primary">
							<div class="panel-heading">
								<i class="fa fa-print fa-fw"></i> Cetak Tagihan Listrik
							</div>
							<div class="panel-body">
								<form action="htmltopdf/invoice.php" target="_blank" class="form-horizontal" id="formMerchant" name="formMerchant" method="POST">
									<div class="form-group" style="margin-left:5px; margin-right:5px;">
										<label>Periode Tagihan</label>
										<select class="form-control chzn-select" name="periode" id="periode" required>
											<!-- <option value="">- Pilih Periode Tagihan -</option> -->
											<?php 
												$sql 	= mysql_query("select * from e_periode order by periode_id desc");
												while($d= mysql_fetch_array($sql)){
											?>
												<option value="<?php echo $d['periode_id'];?>"><?php echo $d['periode_name']; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group" style="margin-left:5px; margin-right:5px; margin-bottom: -5px;">
										<button id="refresh" class="btn btn-block btn-primary"><i class="fa fa-print"></i>&nbsp;&nbsp;Buat Tagihan</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-12" style="margin-top:10px;">
                        <div class="panel panel-primary" style="overflow-x: auto">
                            <div class="panel-heading">
                                <i class="fa fa-user fa-fw"></i> Daftar Tagihan Listrik
                            </div>
                            <div class="panel-body">
								<div class="alert alert-warning d-flex align-items-center" role="alert" style="margin: 0 0;">
									<i class="fa fa-warning me-2" style="font-size: 18px;"></i>
									<span style="font-size: 14px;">
										Tagihan yang tidak terbayar wajib dioffkan, dan tagihan yang sudah dioffkan tidak akan muncul di daftar tagihan.
									</span>
								</div><br>
								<?php 
									$query = mysql_query("select * from e_pay p join electricity e on p.electricity_id = e.electricity_id where pay_sts = 'Belum Lunas' order by pay_id desc");

									if (mysql_num_rows($query) == 0) { ?>
										<div class="box-update">
											<img src="img/paid-off.png" alt="Update Illustration" width="250px">
											<h3 class="text-primary text-uppercase"><b>Tagihan saat ini sudah lunas seluruhnya.</b></h3>
										</div>
									<?php } else { ?>
										<div id="Area1">
											<div class="alert alert-info" onclick="clearNotif()">
												<center><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></center>
											</div>
										</div>
									<?php } 
								?>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>

		<!-- Modal Ganti Password -->
		<div class="modal fade" id="modalPassword" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src='../assets/image/Delete.png' width='25' height='25'/></button>
						<h4 id="header_password">Ganti Password</h4>
					</div>
					<div class="modal-body">
						<div id="data_password" style="margin-bottom: 0px;">
							<div class="alert alert-info" onclick="clearNotif()"><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></div>
						</div>
						<input type="hidden" id="value_id" />
					</div>
					<div class="modal-footer">
					</div>
				</div>
			</div>
		</div>

		<!-- Modal edit price -->
		<div class="modal fade" id="modalEditPrice" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<!-- AJAX akan mengisi konten modal di sini -->
				</div>
			</div>
		</div>

		<!-- Modal konfirmasi hapus -->
		<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header bg-primary" >
						<h5 class="modal-title" id="confirmationModalLabel"><b>KONFIRMASI TAGIHAN OFF</b></h5>
						<button type="button" style="margin-top: -20px;" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						Apakah anda yakin ingin membuat status tagihan menjadi off?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
						<button type="button" class="btn btn-primary" onclick="postAndReload()">Ya</button>
					</div>
				</div>
			</div>
		</div>

		<script>
			let actionUrl = "";

			// ketika tombol Batalkan Tagihan diklik
			$(document).on('click', '.open-confirm', function () {
				actionUrl = $(this).data('url');  
			});

			// ketika tombol "Simpan" di modal diklik
			function postAndReload() {
				window.location.href = actionUrl; // redirect
			}
		</script>

		
		<script>
		$(document).ready(function(){
				// Auto Refresh Page
				$("#notifArea").html(alertLoadProcess);
				$('#Area1').load("invoice_table.php",function(){clearNotif();});
				setTimeout('$("html").removeClass("js")',1000); 
				
				//Modal Ganti Password
				$('#modalPassword').on('shown.bs.modal', function (e) {
					$("#notifArea").html(alertLoadProcess);
					$("#data_password").load("password.php",function(){clearNotif();});
				})


				// Modal Edit Price
				$('body').on('click', '.modalEditPrice', function(e) {
					e.preventDefault()
					var priceID = $(this).data('id'); 

					$.ajax({
						url: 'price_modal2.php',
						type: 'GET',
						data: { id: priceID }, 
						success: function(response) {
							$('#modalEditPrice .modal-content').html(response);
							$('#modalEditPrice').modal('show');
						}
					});
				});
			});
			function clearNotif(){$("#notifArea").html("")};
		</script>
		<script>
			document.getElementById("refresh").onclick = function(event) {
				setTimeout(function() {
					location.reload();
				}, 100);
			};
		</script>

		<script>
			$(document).ready(function () {
				$('body').tooltip({
					selector: '[data-toggle="tooltip"]',
					html: true
				});
			});
		</script>

		<!-- jQuery -->
		<script src="js/jquery.js"></script>
		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.min.js"></script>
		<!-- Metis Menu Plugin JavaScript -->
		<script src="js/plugins/metisMenu/metisMenu.min.js"></script>
		<!-- Custom Theme JavaScript -->
		<script src="js/sb-admin-2.js"></script>
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