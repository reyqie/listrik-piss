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
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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

		function toRp(angka){
		var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
		var rev2    = '';
		for(var i = 0; i < rev.length; i++){
			rev2  += rev[i];
			if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
				rev2 += '.';
			}
		}
		return 'Rp. ' + rev2.split('').reverse().join('');
		//return 'Rp. ' + rev2.split('').reverse().join('') + ',00';
		}
	
		function updateTotal(){
			var x 		= document.getElementById('lapak').value;
			var price 	= document.getElementById('price').value;
			
			var rp 	= toRp(x);
			//Update Price
			$('#totalprice').html(rp);
		}
		function showBook(getID){
			$("#room_id").val(getID);
			$("#Area1").load("book.php?room="+$("#room_id").val());
		}
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
                        <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
           
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li><a href="dashboard.php"><i class="fa fa-dashboard fa-fw"></i> Home</a></li>
						<li><a href="merchant.php"><i class="fa fa-group fa-fw"></i> Pedagang</a></li>
						<li><a href="lapak.php"><i class="fa fa-building fa-fw"></i> Lapak</a></li>
						<li><a class="active" href="rent.php"><i class="fa fa-money fa-fw"></i> Sewa Lapak</a></li>
						<li><a href="instalment.php"><i class="fa fa-fax fa-fw"></i> Cicilan Lapak</a></li>
						<li><a href="move.php"><i class="fa fa-retweet fa-fw"></i> Perpindahan Lapak</a></li>
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
                            <i class="fa fa-pencil fa-fw"></i> Penyewaan Lapak
                        </div>
                        <div class="panel-body">
							<?php
								$id		= $_GET['id'];
								$edit	= mysql_query("select * from rent, merchant where rent.rent_id = '".$id."' and
								rent.merchant_id = merchant.merchant_id");
								while($r = mysql_fetch_array($edit)){
							?>
                            <form class="form-horizontal" id="formMerchant" name = "formMerchant" method="POST" action="merchant_action.php?task=insert" enctype="multipart/form-data">
								<fieldset>
								<div class="col-lg-4" style="padding:10px; margin-top:-10px;">
									<label>Nama</label>
									<input id="name1" name="name1" value="<?php echo $r['merchant_name']; ?>" type="text" class="form-control" autofocus="autofocus" required> 
									<input id="name2" name="name2" value="<?php echo $r['merchant_nick']; ?>" type="text" class="form-control" >                
								
									<label>Alamat</label>
									<input id="adrs1" name="adrs1" value="<?php echo $r['address1']; ?>" type="text" class="form-control" required/>
									<input id="adrs2" name="adrs2" value="<?php echo $r['address2']; ?>" type="text" class="form-control" />
									
									<label>Telepon</label>
									<input id="tlp" name="tlp1" value="<?php echo $r['merchant_phone1']; ?>" maxlength="13" onkeydown="return isNumber(event);" type="text" class="form-control" />
									<input id="tlp2" name="tlp2" value="<?php echo $r['merchant_phone2']; ?>" maxlength="13" onkeydown="return isNumber(event);" type="text" class="form-control" />
								
									<label>No Identitas</label>
									<input id="ktp" name="ktp" value="<?php echo $r['nid_ktp']; ?>" maxlength="16" onkeydown="return isNumber(event);" type="text" class="form-control" />
									<input id="sim" name="sim" value="<?php echo $r['nid_sim']; ?>" maxlength="12" onkeydown="return isNumber(event);" type="text"  class="form-control" />
									<input id="lain" name="lain" value="<?php echo $r['nid_lain']; ?>"  maxlength="20" onkeydown="return isNumber(event);" type="text" class="form-control"/>
									<select class="form-control" name="nid" id="nid">
										<option value="<?php echo $r['nid_type']; ?>"><?php echo $r['nid_type']; ?></option>
										<option value="KTP">KTP</option>
										<option value="SIM">SIM</option>
										<option value="PASPOR">PASPOR</option>
										<option value="Pelajar">Kartu Pelajar/Mahasiswa</option>
										<option value="Lainnya">Lainnya</option>
									</select>
								</div>
								<div class="col-lg-4" style="padding:10px; margin-top:-20px;">
									<div class="form-group" style="padding:10px; margin-right:10px;">
										<label>Lapak</label>
										<select class="form-control" name="lapak" id="lapak">
											<option value="<?php echo $r['lapak_id']; ?>">
											<?php 
												$lapak = executeScalar("select lapak_name from lapak where lapak_id = '".$r['lapak_id']."'");
												echo $lapak;
											?>
											</option>
											<?php 
												$sql 		= mysql_query("select lapak_id, lapak_name from lapak where lapak_status = 'Kosong'");
												while($data = mysql_fetch_array($sql))
											{?>
												<option value="<?php echo $data['lapak_id'];?>"><?php echo $data['lapak_name'];?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group" style="padding:10px; margin-right:10px;">
										<label>Jenis Jualan</label>
										<select class="form-control" name="type" id="type">
											<option value="<?php echo $r['merchant_type']; ?>"><?php echo $r['merchant_type']; ?></option>
											<option value="Sayur">Sayur</option>
											<option value="Buah">Buah</option>
											<option value="Sembako">Sembako</option>
											<option value="Lainnya">Lainnya</option>
										</select>
									</div>
									<div class="form-group" style="padding:10px; margin-right:10px;">
										<label>Pembayaran</label>
										<input id="dp" name="dp" value="<?php echo $r['rent_dp']; ?>" type="number" class="form-control" />
										<script>
											$("input[name='dp']").TouchSpin({
											  verticalbuttons: true,
											  verticalupclass: 'glyphicon glyphicon-plus',
											  verticaldownclass: 'glyphicon glyphicon-minus'
											});
										</script>
									</div>
									<div class="form-group" style="padding:10px;">
										<label>Kajian</label>
										<textarea cols="40" rows="6" id="ket" name="ket"><?php echo $r['rent_desc']; ?></textarea>
									</div>
								</div>
								<div class="col-lg-4" style="padding:10px; margin-top:-20px;">
									<div class="form-group" style="padding:10px;">
										<label>Ukuran Lapak</label>
										<div id="size"><?php 
											$size = executeScalar("select lapak_size from lapak where lapak_id = '".$r['lapak_id']."'");
											echo $size;?> M<sup>2</sup>
										</div>
									</div>
									<div class="form-group" style="padding:10px;">
										<label>Harga /M<sup>2</sup></label>
										<div id="price"><?php 
											$price = executeScalar("select lapak_price from lapak where lapak_id = '".$r['lapak_id']."'");
											echo format_rupiah($price);?>
										</div>
									</div>
									<div class="form-group" style="padding:10px;">
										<label>Total Harga</label>
										<div id="totalprice"><?php echo format_rupiah($r['rent_total']); ?></div>
									</div>
									<div class="form-group" style="padding:10px;">
										<label>Angsuran</label>
										<div id="instalment"><?php echo format_rupiah($r['rent_dp']); ?></div>
									</div>
									<button type="button" class="btn btn-outline btn-block btn-info">Print Permohonan Lapak</button>
									<button type="button" class="btn btn-outline btn-block btn-info">Print Persetujuan Permohonan Lapak</button>
								</div>
								<div class="form-group" style="padding:10px;">
										<center><button type="submit" class="btn btn-outline btn-block btn-primary">Simpan</button></center>
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
			$('#Area1').load("rent_table.php",function(){clearNotif();});
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
