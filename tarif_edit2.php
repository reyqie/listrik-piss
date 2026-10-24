<?php
	session_start();
	include "connection.php";
	//Validasi role
	if($_SESSION['role']==''){
		header("Location:index.php");
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
		<link rel="icon" href="../images/icon.png">
		<link rel="shortcut icon" href="../images/icon.png" />
		<title>Ubah Data Perlengakapan Listrik | PISS</title>

		<!-- Bootstrap Core CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!-- MetisMenu CSS -->
		<link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
		<!-- Timeline CSS -->
		<link href="css/plugins/timeline.css" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="css/sb-admin-2.css" rel="stylesheet">
		<!-- Custom Fonts -->
		<link href="font-awesome-4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script src="js/jquery.min.js"></script>
		<!-- input number -->
		<link href="js/touchpin/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" media="all">
		<script src="js/touchpin/jquery.bootstrap-touchspin.js"></script>
		
		<script>
			/* hide all elements & show preloader*/
			document.documentElement.className += 'js';
			
			/* display variabel */
			var alertLoadProcess = "<span class='alert alert-info' onclick='clearNotif()'><i class='fa fa-spinner fa-spin'></i> Loading...</span>";
		</script>
	</head>
	<body>
		<div id="wrapper">
			<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php">Admin PISS</a>
				</div>

				<ul class="nav navbar-top-links navbar-right">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<?php echo $_SESSION['user']; ?><i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
						<li><a data-toggle="modal" data-target="#modalPassword" href="#"><i class="fa fa-lock fa-fw"></i> Ganti Password</a></li>
							<li><a href="#"><i class="fa fa-question-circle fa-fw"></i> Bantuan</a></li>
							<li class="divider"></li>
							<li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
			
				<div class="navbar-default sidebar" role="navigation">
					<div class="sidebar-nav navbar-collapse">
						<ul class="nav" id="side-menu">
							<li><a href="dashboard.php"><i class="fa fa-bar-chart fa-fw"></i> Dashboard</a></li>
							<li class="active">
								<a href="#"><i class="fa fa-flash fa-fw"></i> Biaya Listrik<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li><a href="tarif.php"><i class="fa fa-flash fa-fw"></i> Biaya Listrik</a></li>
									<li><a class="active" href="tarif2.php"><i class="fa fa-flash fa-fw"></i> Biaya Perlengkapan Listrik</a></li>
								</ul>
							</li><li>
								<a href="#"><i class="fa fa-users fa-fw"></i> Pengguna Listrik<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li><a href="register.php"><i class="fa fa-user-plus fa-fw"></i> Input Pengguna</a></li>
									<li><a href="merchant.php"><i class="fa fa-users fa-fw"></i> Data Pengguna</a></li>
								</ul>
							</li>
							<li>
								<a href="#"><i class="fa fa-clipboard fa-fw"></i> Tagihan<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li><a href="periode.php"><i class="fa fa-clock-o fa-fw"></i> Periode Tagihan</a></li>
									<li><a href="invoice.php"><i class="fa fa-print fa-fw"></i> Cetak Tagihan</a></li>
									<li><a href="invoice_cancel.php"><i class="fa fa-close fa-fw"></i> Pembatalan Tagihan</a></li>
								</ul>
							</li>
							<li>
								<a href="#"><i class="fa fa-money fa-fw"></i> Pembayaran<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li><a href="pay.php"><i class="fa fa-money fa-fw"></i> Pembayaran Tagihan</a></li>
									<li><a href="pay_cancel.php"><i class="fa fa-close fa-fw"></i> Pembatalan Pembayaran</a></li>
								</ul>
							</li>
							<li><a href="note.php"><i class="fa fa-sticky-note-o fa-fw"></i> Catatan</a></li>
							<li><a href="report.php"><i class="fa fa-book fa-fw"></i> Laporan</a></li>
						</ul>
					</div>
				</div>
			</nav>

			<div id="page-wrapper">
				<div class="row">
					<div class="col-lg-4" style="padding:10px;">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<i class="fa fa-pencil fa-fw"></i> <strong>Update Tarif Listrik</strong>
							</div>
							<div class="panel-body">
								<?php 
									$id		= $_GET['id'];
									$edit	= mysql_query("select * from e_tools where e_tools_id = '".$id."'");
									while($r = mysql_fetch_array($edit)){
								?>
								<form action="tarif_action2.php?task=update&id=<?php echo $r['e_tools_id']; ?>" class="form-horizontal" id="formTarif" name="formTarif" method="POST">
									<div class="form-group" style="padding:10px; margin-top: -10px;">
										<label>Nama Perlengkapan Listrik</label>
										<input class="form-control" id="tools" name="tools" type="text" value="<?php echo $r['e_tools_name']; ?>" />
									</div>
									<div class="form-group" style="padding:10px; margin-top: -10px;">
										<label>Tarif Perhari (Rupiah)</label>
										<input class="form-control" id="price" name="price" type="text" value="<?php echo $r['e_tools_price']; ?>" />
										<script>
											$("input[name='price']").TouchSpin({
											verticalbuttons: true,
											verticalupclass: 'glyphicon glyphicon-plus',
											verticaldownclass: 'glyphicon glyphicon-minus'
											});
										</script>
									</div>
									<div class="form-group" style="padding:10px; margin-top: -10px; margin-bottom: -10px;">
										<center><button type="submit" class="btn btn-outline btn-block btn-primary">Simpan</button></center>
									</div>
								</form>
								<?php }?>
							</div>
						</div>
					</div>
					<div class="col-lg-8" style="margin-top:20px;">
						<div id="Area1">
							<div class="alert alert-info" onclick="clearNotif()">
								<center><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></center>
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
		
		<script>
			$(document).ready(function(){
				// Auto Refresh Page
				$("#notifArea").html(alertLoadProcess);
				$('#Area1').load("tarif_table2.php",function(){clearNotif();});
				setTimeout('$("html").removeClass("js")',1000); 
				
				//Modal Ganti Password
				$('#modalPassword').on('shown.bs.modal', function (e) {
					$("#notifArea").html(alertLoadProcess);
					$("#data_password").load("password.php",function(){clearNotif();});
				})
			});
			function clearNotif(){$("#notifArea").html("");}
		</script>

		<!-- jQuery -->
		<script src="js/jquery.js"></script>
		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.min.js"></script>
		<!-- Metis Menu Plugin JavaScript -->
		<script src="js/plugins/metisMenu/metisMenu.min.js"></script>
		<!-- Custom Theme JavaScript -->
		<script src="js/sb-admin-2.js"></script>
	</body>
</html>