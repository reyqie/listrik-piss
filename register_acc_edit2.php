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
    <title>Admin</title>

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
	<script language="javascript">
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
                <a class="navbar-brand" href="index.php">Admin PIOS</a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Akun <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
           
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li><a href="dashboard.php"><i class="fa fa-bar-chart fa-fw"></i> Dashboard</a></li>
						<li> 
							<a href="#"><i class="fa fa-building fa-fw"></i> Master Lapak<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li><a href="lapak.php"><i class="fa fa-building fa-fw"></i> Lapak</a></li>
								<li><a href="block.php"><i class="fa fa-building fa-fw"></i> Block</a></li>
							</ul>
						</li>
						<li class="active">
                            <a href="#"><i class="fa fa-users fa-fw"></i> Pedagang<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li><a href="register.php"><i class="fa fa-user-plus fa-fw"></i> Pendaftaran Pedagang</a></li>
								<li><a class="active" href="register_view.php"><i class="fa fa-user-plus fa-fw"></i> Permohonan Yg Disetujui</a></li>
								<li><a href="merchant.php"><i class="fa fa-users fa-fw"></i> Data Pedagang</a></li>
							</ul>
						</li>
						<li>
                            <a href="#"><i class="fa fa-money fa-fw"></i> Pembayaran<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li><a href="rent.php"><i class="fa fa-money fa-fw"></i> Uang Muka Lapak</a></li>
								<li><a href="instalment.php"><i class="fa fa-fax fa-fw"></i> Cicilan Lapak</a></li>
							</ul>
						</li>
						<li><a href="move.php"><i class="fa fa-retweet fa-fw"></i> Perpindahan lapak</a></li>
						<li><a href="report.php"><i class="fa fa-book fa-fw"></i> Laporan</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12" style="padding:10px;">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-pencil fa-fw"></i> Permohonan Menempati Lapak PIOS
                        </div>
                        <div class="panel-body">
							<?php 
								$id		= $_GET['id'];
								$edit	= mysql_query("select * from rent where rent_id = '".$id."'");
								while($r = mysql_fetch_array($edit)){
								$name 		= executeScalar("select req_name from request where req_id = '".$r['req_id']."'");
								$adrs 		= executeScalar("select address1 from request where req_id = '".$r['req_id']."'");
								$type		= executeScalar("select merchant_type from request where req_id = '".$r['req_id']."'");
								$lapak 		= executeScalar("select lapak_name from lapak where lapak_id = '".$r['lapak_id']."'");
								$price	 	= executeScalar("select lapak_price from lapak where lapak_id = '".$r['lapak_id']."'");
								$duration 	= executeScalar("select duration from lapak where lapak_id = '".$r['lapak_id']."'");
							?>
                            <form action="register_action.php?task=acc&id=<?php echo $id; ?>"  id="formRegisterAcc" name = "formRegisterAcc" method="POST" class="form-horizontal">
								<fieldset>
								<div class="col-lg-4" style="padding:10px; margin-top:-20px; margin-bottom:-10px;">
									<div class="form-group" style="padding:10px; margin-right:10px;">
										<label>No. PL</label>
										<input id="pl" name="pl" value="<?php 
											$idq = sprintf("%03d", $id);echo 'PL'.$idq; ?>" type="text" class="form-control" disabled /> 
										<br />
										<label>Nama</label>
										<input id="name1" name="name1" value="<?php echo $name; ?>" type="text" class="form-control" disabled /> 
										<br />
										<label>Alamat</label>
										<input id="adrs1" name="adrs1" value="<?php echo $adrs; ?>" type="text" class="form-control" disabled />
										<br />
										<label>Jenis Jualan</label>
										<select class="form-control" name="type" id="type" disabled>
											<option value="<?php echo $type; ?>"><?php echo $type; ?></option>
										</select>
									</div>
								</div>
								<div class="col-lg-4" style="padding:10px; margin-top:-20px; margin-bottom:-10px;">
									<div class="form-group" style="padding:10px; margin-right:10px;">
										<label>Lapak</label>
										<select class="form-control" name="lapak" id="lapak" disabled>
											<option value="<?php echo $r['lapak_id']; ?>"><?php echo $lapak; ?></option>
										</select>
										<br />
										<label>Harga Per (M<sup>2</sup>)</label>
										<input id="price" name="price" value="<?php echo format_rupiah($price); ?>" type="text" class="form-control" disabled />
										<br />
										<label>Masa Pakai</label>
										<input class="form-control" id="dur" name="dur" type="text" value="<?php echo $duration; ?> Tahun" disabled />
										<br />
										<label> Harga Total</label>
										<input id="total" name="total" value="<?php echo format_rupiah($r['rent_total']); ?>" type="text" class="form-control" disabled />
									</div>
								</div>
								<div class="col-lg-4" style="padding:10px; margin-top:-20px; margin-bottom:-10px;">
									<div class="form-group" style="padding:10px; margin-right:10px;">
										<label> Uang Muka</label>
										<input id="dp" name="dp" value="<?php echo $r['rent_dp']; ?>" type="number" class="form-control" disabled />
									<br />
										<label>Kajian</label>
										<textarea cols="40" rows="6" id="ket" name="ket"  disabled><?php echo $r['rent_desc']; ?></textarea>
										<br /><br />
										<center>
											<a href="htmltopdf/persetujuan_pedagang.php?id=<?php echo $id;?>" target="_blank">
												<button style="margin-top:10px;" class="btn btn-outline btn-block btn-info" type="button">
													Cetak Form Persetujuan
												</button>
											</a>
										</center>
									</div>
								</div>
								</fieldset>
							</form>
							<?php }?>
                        </div>
                    </div>
                </div>
			</div>
        </div>
    </div>

	<script>
    $(document).ready(function(){
			// Auto Refresh Page
			$("#notifArea").html(alertLoadProcess);
			$('#Area1').load("register_table2.php",function(){clearNotif();});
			setTimeout('$("html").removeClass("js")',1000); 
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
