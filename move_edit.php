<?php
	include "connection.php";
	//Validasi role
	session_start();
	function executeScalar($sql,$def=0){
		$rs = mysql_query($sql) or die(mysql_error().$sql);
		if (mysql_num_rows($rs)) {$r = mysql_fetch_row($rs);mysql_free_result($rs);return $r[0];}
		return $def;
	}
	if($_SESSION['role']==''){
		header("Location:index.php");
	}
	$id		= $_GET['id'];
	$edit	= mysql_query("select * from pedagang where id_pedagang = '".$id."'");
	while ($r = mysql_fetch_array($edit)){
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
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Admin CV. Rahmat Sentosa</a>
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
                        <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
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
						<li>
                            <a href="#"><i class="fa fa-users fa-fw"></i> Pedagang<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li><a href="register.php"><i class="fa fa-user-plus fa-fw"></i> Pendaftaran Pedagang</a></li>
								<li><a href="register_acc.php"><i class="fa fa-user-plus fa-fw"></i> Persetujuan Permohonan</a></li>
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
						<li class="active"><a href="move.php"><i class="fa fa-retweet fa-fw"></i> Perpindahan lapak</a></li>
						<li><a href="report.php"><i class="fa fa-book fa-fw"></i> Laporan</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-4" style="padding:10px;">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-plus fa-fw"></i> Pindah Lapak
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" id="formhome" name = "formhome" method="POST" action="home_action.php?task=update&id=<?php echo $r[0]; ?>" enctype="multipart/form-data">
								<fieldset>
									<div class="form-group" style="padding:10px;">
										<label>Nama Pedagang</label>
										<input type="text" class="form-control" id="name" name="name" value="<?php echo $r[1]; ?>">                  
									</div>
									<div class="form-group" style="padding:10px;">
										<label>Lapak Saat Ini</label>
										<input type="text" class="form-control" id="awal" name="awal" value="<?php $lapak 	= executeScalar("select lapak_nama from lapak where lapak_id='".$r[5]."' ");echo $lapak; ?>" disable/> 
									</div>
									<div class="form-group" style="padding:10px;">
										<label>Nama Lapak</label>
										<select class="form-control" name="akhir" id="akhir">
											<option value="">- Pilih Lapak -</option>
											<?php 
												$sql 		= mysql_query("select lapak_id, lapak_nama from lapak");
												while($r = mysql_fetch_array($sql))
											{?>
												<option value="<?php echo $r['lapak_id'];?>"><?php echo $r['lapak_nama'];?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group" style="align: center; padding:10px;">
										<button style="margin-left: 30px; margin-right: 5px;" class="btn btn-outline btn-success col-sm-3" type="button" onclick="history.go(-1);">Batal</button>
										<a href="home_action.php?task=delete&id=<?php echo $data[0]; }?>"><button style="margin-left: 5px; margin-right: 5px;" class="btn btn-outline btn-danger col-sm-3" type="button">Hapus</button></a>
										<button style="margin-left: 5px; margin-right: 5px;" type="submit" class="btn btn-outline btn-primary col-sm-3">Simpan</button>
									</div>
								</fieldset>
							</form> 
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

	<script>
		$(document).ready(function(){
			// Auto Refresh Page
			$("#notifArea").html(alertLoadProcess);
			$('#Area1').load("home_table.php",function(){clearNotif();});
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