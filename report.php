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
    <title>Laporan | PISS</title>

	<?php echo headScript(); ?>
	
	<script src="js/jquery.min.js"></script>
	<script language="javascript">
		/* hide all elements & show preloader*/
		document.documentElement.className += 'js';
		
		/* display variabel */
		var alertLoadProcess = "<span class='alert alert-info' onclick='clearNotif()'><i class='fa fa-spinner fa-spin'></i> Loading...</span>";
	</script>
	<script src="dataTables/dataTables.tableTools.css"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
</head>
<body>
    <div id="wrapper">
		<?php include "components/sidebar.php"; ?>

        <div id="page-wrapper">
			<br /><br><br><br>
            <div class="row">
                <div class="col-lg-6">
                    <div id="Area1">
						<div class="alert alert-info" onclick="clearNotif()">
							<center><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></center>
						</div>
					</div>
					<input type="hidden" id="value_day1" />
					<div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-file-text fa-fw"></i> Laporan Pendapatan Listrik
                        </div>
                        <div class="panel-body">
							<form class="form-horizontal" id="reportOmzet" name = "reportOmzet" method="POST">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group" style="padding: 0 15px; margin-top:0px;">
											<label>Tanggal Awal</label>
											<input name="date1" type="date" class="form-control" required
											data-fv-notempty-message="Tanggal Belum Diisi"/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group" style="padding: 0 15px; margin-top:0px;">
											<label>Tanggal Akhir</label>
											<input name="date2"  type="date" class="form-control" required
											data-fv-notempty-message="Tanggal Belum Diisi"/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group" style="margin-top:5px; margin-right:0px; margin-left:0px">
												<button type="submit" class="btn btn-primary btn-block"  onclick="setAction('pdf')"><i class="fa fa-file-pdf-o fa-lg" style="font-size: 16px;"></i>&nbsp;&nbsp;Print PDF</button>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group" style="margin-top:5px; margin-left:0px; margin-right: 0px">
											<button type="submit" class="btn btn-success btn-block" style="background-color: #008000;" onclick="setAction('excel')"><i class="fa fa-file-excel-o fa-lg" style="font-size: 16px;"></i>&nbsp;&nbsp;Export Excel</button>
										</div>
									</div>
								</div>
							</form>
                        </div>
                    </div>

					<div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-file-text fa-fw"></i> Laporan Tagihan Listrik Off
                        </div>
                        <div class="panel-body">
							<form class="form-horizontal" id="reportCancel" name="reportCancel" method="POST">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group" style="padding: 0 15px; margin-top:0px;">
											<label>Tanggal Awal</label>
											<input name="date1" type="date" class="form-control" required
											data-fv-notempty-message="Tanggal Belum Diisi"/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group" style="padding: 0 15px; margin-top:0px;">
											<label>Tanggal Akhir</label>
											<input name="date2" type="date" class="form-control" required
											data-fv-notempty-message="Tanggal Belum Diisi"/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group" style="margin-top:5px; margin-right:0px; margin-left:0px">
												<button type="submit" class="btn btn-primary btn-block"  onclick="setAction('pdf')"><i class="fa fa-file-pdf-o fa-lg" style="font-size: 16px;"></i>&nbsp;&nbsp;Print PDF</button>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group" style="margin-top:5px; margin-left:0px; margin-right: 0px">
											<button type="submit" class="btn btn-success btn-block" style="background-color: #008000;" onclick="setAction('excel')"><i class="fa fa-file-excel-o fa-lg" style="font-size: 16px;"></i>&nbsp;&nbsp;Export Excel</button>
										</div>
									</div>
								</div>
							</form>
                        </div>
                    </div>
				</div>

				<div class="col-lg-6">
					<div id="Area2">
						<div class="alert alert-info" onclick="clearNotif()">
							<center><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></center>
						</div>
					</div>
					<input type="hidden" id="value_day2" />
					<div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-file-text fa-fw"></i> Laporan Outstanding Listrik
                        </div>
                        <div class="panel-body">
							<form class="form-horizontal" id="reportOutstanding" name="reportOutstanding" method="POST">
								<div class="col-md-6">
									<div class="form-group" style="margin-top:5px; margin-right:0px; margin-left:0px">
											<button type="submit" class="btn btn-primary btn-block"  onclick="setAction('pdf')"><i class="fa fa-file-pdf-o fa-lg" style="font-size: 16px;"></i>&nbsp;&nbsp;Print PDF</button>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group" style="margin-top:5px; margin-left:0px; margin-right: 0px">
										<button type="submit" class="btn btn-success btn-block" style="background-color: #008000;" onclick="setAction('excel')"><i class="fa fa-file-excel-o fa-lg" style="font-size: 16px;"></i>&nbsp;&nbsp;Export Excel</button>
									</div>
								</div>
							</form>
                        </div>
                    </div>
				</div>
            </div> 

        </div>
    </div>
	<!-- Modal Tonase -->
	<div class="modal fade bs-example-modal-lg" id="modalTonase" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src='img/Delete.png' width='25' height='25'/></button>
					<h4 id="header_tonase">Tonase Timbangan </h4>
				</div>
				<div class="modal-body">
					<div id="body_tonase" style="margin-bottom: 0px;">
						<div class="alert alert-info" onclick="clearNotif()"><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></div>
					</div>
				</div>
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>
	<!-- Modal Outstanding -->
	<div class="modal fade bs-example-modal-lg" id="modalOutstanding" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src='img/Delete.png' width='25' height='25'/></button>
					<h4 id="header_outstanding">Tonase Outstanding PIOS </h4>
				</div>
				<div class="modal-body">
					<div id="body_outstanding" style="margin-bottom: 0px;">
						<div class="alert alert-info" onclick="clearNotif()"><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></div>
					</div>
				</div>
				<div class="modal-footer">
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
    
	<!-- jQuery -->
    <script src="js/jquery.js"></script>
	<script src="dataTables/jquery.dataTables.js"></script>
	<script src="dataTables/dataTables.tableTools.js"></script>
	<script src="dataTables/dataTables.bootstrap.js"></script>
	<!-- highcharts -->
	<script src="highcharts/js/highcharts.js"></script>
	<script src="highcharts/js/highcharts-more.js"></script>
	
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
	<script>
		$(document).ready(function(){
			$("#notifArea").html(alertLoadProcess);
			$('#Area1').load("line_revenue.php",function(){clearNotif();});
			$('#Area2').load("line_outstanding.php",function(){clearNotif();});
			setTimeout('$("html").removeClass("js")',1000); 
			
			//Modal Ganti Password
			$('#modalPassword').on('shown.bs.modal', function (e) {
				$("#notifArea").html(alertLoadProcess);
				$("#data_password").load("password.php",function(){clearNotif();});
			})
		});
		//Memanggil Modal Outstanding
		function callOutstanding(getDay){
			$("#value_day1").val(getDay);
			$("#body_outstanding").load("detail_outstanding.php?day="+$("#value_day1").val(),function(){clearNotif();});
			$('#modalOutstanding').modal('show');
		}
		//Memanggil Modal Tonase
		function callTonase(getDay){
			$("#value_day2").val(getDay);
			$("#body_tonase").load("detail_tonase.php?day="+$("#value_day2").val(),function(){clearNotif();});
			$('#modalTonase').modal('show');
		}
		
		function clearNotif(){$("#notifArea").html("");}
    </script>
	<script>
		function setAction(type) {
			let form1 = document.getElementById("reportOmzet");
			let form2 = document.getElementById("reportCancel");
			let form3 = document.getElementById("reportOutstanding");

			if (type === 'pdf') {
				if (form1) { form1.action = "htmltopdf/report_omzet.php"; form1.target = "_blank"; }
				if (form2) { form2.action = "htmltopdf/report_cancel.php"; form2.target = "_blank"; }
				if (form3) { form3.action = "htmltopdf/report_outstanding.php"; form3.target = "_blank"; }
			} 
			else if (type === 'excel') {
				if (form1) { form1.action = "exportExcel/exportReportOmzet.php"; form1.target = "_self"; }
				if (form2) { form2.action = "exportExcel/exportReportCancel.php"; form2.target = "_self"; }
				if (form3) { form3.action = "exportExcel/exportReportOutstanding.php"; form3.target = "_self"; }
			}
		}
	</script>
</body>
</html>