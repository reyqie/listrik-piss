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
        <title>Periode Tagihan | PISS</title>

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
            var alertLoadProcess = "<span class='alert alert-info' onclick='clearNotif()'><i class='fa fa-spinner fa-spin'></i> Loading...</span>";
        </script>
    </head>
    <body>
        <div id="wrapper">
            <?php include "components/sidebar.php"; ?>

            <div id="page-wrapper">
                <div class="row"><br><br><br><br>
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <i class="fa fa-pencil fa-fw"></i> Tambah Periode Tagihan Listrik
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" id="form" name="form" method="POST" action="periode_action.php?task=insert">
                                    <div class="form-group" style="padding: 0 10px; margin-bottom: 20px;">
                                        <label>Periode Tagihan Listrik</label>
                                        <!-- old -->
                                        <!-- <select class="form-control" name="periode" id="periode" required>
                                            <?php 
                                                $month     = date('M Y');
                                                $month2    = date("M Y", strtotime("first day of next month"));
                                                $vmonth    = date('mY');
                                                $vmonth2   = date("mY", strtotime("first day of next month"));                
                                                ?>
                                            <option value="">- Pilih Periode Tagihan -</option>
                                            <option value="<?php echo $vmonth;?>"><?php echo $month; ?></option>
                                            <option value="<?php echo $vmonth2;?>"><?php echo $month2;?></option>
                                        </select> -->

                                        <!-- new -->
                                        <?php 
                                            $month     = date('mY');           
                                            $displayMonth     = date('F Y');

                                            $checkPeriod = executeScalar("select count(periode_id) from e_periode 
                                                where periode_month = '".substr($month,0,2)."' and periode_year = '".substr($month,2,4)."'");
                                        ?>
                                        <input type="hidden" name="periode" value="<?php echo $month; ?>" />
                                        <input type="text" class="form-control" id="periode_display" value="<?php echo $displayMonth ?>" readonly>
                                    </div>
                                    <?php if($checkPeriod > 0){ ?>
                                        <div class="form-group" style="padding: 0 10px; margin-bottom: -15px;">
                                            <div class="alert alert-warning">
                                                <center><i class="fa fa-exclamation-triangle"></i> Periode tagihan untuk bulan <?php echo $displayMonth; ?> sudah terbuat.</center>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if($checkPeriod == 0){ ?>
                                        <div class="form-group" style="padding: 0 10px; margin-bottom: 0px;">
                                            <center><button type="submit" class="btn btn-block btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Buat Periode</button></center>
                                        </div>
                                    <?php } ?>
                                </form> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top:10px;">
                        <div class="panel panel-primary" style="overflow-x: auto">
                            <div class="panel-heading">
                                <i class="fa fa-clock-o fa-fw"></i> Data Periode Tagihan Listrik
                            </div>
                            <div class="panel-body">
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
                $('#Area1').load("periode_table.php",function(){clearNotif();});
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