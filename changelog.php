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
		<title>Update Log | PISS</title>

		<?php echo headScript(); ?>
	</head>
	<body>
		<div id="wrapper">
		<?php include "components/sidebar.php" ?>

			<div id="page-wrapper">
				<?php 
					$username	= $_SESSION['username'];
					$privileges = executeScalar("SELECT privileges FROM admin WHERE username = '$username'");
					if ($privileges == 'developer' && $_SESSION['role']=='spv') { ?>

					<div class="row">
						<div class="col-lg-12">
							<br><br><br><br>
							<div class="panel panel-primary">
								<div class="panel-heading">
									<i class="fa fa-plus fa-fw"></i> Buat Update Log / Changelog
								</div>
								<div class="panel-body">
									<form class="form-horizontal" id="formUpdateLog" name = "formUpdateLog" method="POST" action="changelog_action.php">
										<fieldset>
											<div class="form-group" style="padding:10px; margin-top:-10px; margin-bottom:0px;">
												<label for="semantic">Semantic Versioning</label>
												<select  name="semantic" id="semantic" class="form-control" required>
													<option value="" selected>Pilih Semantic Versioning</option>
													<option value="major">Major (Format Perubahan 1.x.x)</option>
													<option value="minor">Minor (Format Perubahan x.1.x)</option>
													<option value="patch">Patch (Format Perubahan x.x.1)</option>
												</select>                  
											</div>
											<div class="form-group" style="padding:10px; margin-top: -5px; margin-bottom:0px;">
												<label for="version">Version</label>
												<input type="text" class="form-control" id="version" name="version" placeholder="Contoh: 1.0.0" required>                  
											</div>
											<div class="form-group" style="padding:10px; margin-top: -5px; margin-bottom:0px;">
												<label for="title">Title Update</label>
												<input type="text" class="form-control" id="title" name="title" placeholder="Masukkan Title Update" required>                  
											</div>
											<div class="form-group" style="padding:10px; margin-top: -5px; margin-bottom:0px;">
												<label for="date">Tanggal Update</label>
												<input type="date" class="form-control" id="date" name="date" placeholder="Tanggal Update" required>                  
											</div>
											<div class="form-group" style="padding:10px; margin-top: -5px; margin-bottom:0px;">
												<label for="lots">Banyak Deskripsi Update</label>
												<input type="number" class="form-control" id="lots" name="lots" placeholder="Banyak Deskripsi Update" required>
											</div>

											<!-- Tempat untuk input deskripsi otomatis -->
											<div id="desc-wrapper"></div>

											<div class="form-group" style="padding:10px; margin-bottom:0px;">
												<center><button type="submit" class="btn btn-block btn-primary"><i class="fa fa-floppy-o fa-fw"></i>&nbsp;Simpan</button></center>
											</div>
										</fieldset>
									</form> 
								</div>
							</div>
						</div>
					</div>
				<?php } elseif ($privileges == 'manager') { ?>
					<br><br><br><br>
				<?php } elseif ($_SESSION['role'] == 'pp') { ?>
					<br><br><br><br>
				<?php } ?>

				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h4 class="panel-title">
									<i class="fa fa-history"></i> Update Log / Changelog
								</h4>
							</div>
							<div class="panel-body">
								<div class="panel-group" id="accordionChangelog">

								<?php
								    $first = true;
									$query = mysql_query("SELECT * FROM update_listrik ORDER BY id DESC");

									while($data = mysql_fetch_array($query)){
										$update_id = $data['id'];
										$semantic = $data['semantic'];
										$version = $data['version'];
										$title = $data['title'];
										$date = date("d F Y", strtotime($data['date']));
										$panelClass = $semantic == 'major' ? 'panel-success' :
														($semantic == 'minor' ? 'panel-info' : 'panel-default');
									?>

								<div class="panel <?php echo $panelClass; ?>">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a data-toggle="collapse" data-parent="#accordionChangelog" href="#ver<?= $update_id ?>">
												<i class="fa fa-plus"></i> <?= "Version $version - $date" ?>
											</a>
										</h4>
									</div>

									<div id="ver<?= $update_id ?>" class="panel-collapse collapse <?= $first ? 'in' : '' ?>"">
										<div class="panel-body">
											<h5># <?= $title; ?></h5>
											<ul>
												<?php
													$desc_query = mysql_query("SELECT * FROM update_desc_listrik WHERE update_listrik_id = '$update_id'");
													$emoji = [
																// Objects
																'💡','📌','📍','📎','✏','✒','🖊','🖋','📝','📖','📚','📦','📁','📂','🗂',
																'💼','👜','🎒','💻','🖥','🖨','⌨','🖱','💾','📱','📲','☎','📞',

																// Weather
																'☀','🌤','⛅','🌥','🌦','🌧','⛈','🌩','🌨','❄','🌬','💨','🌪','🌈',

																// Hearts / Symbols
																'❤️','🧡','💛','💚','💙','💜','🖤','🤍','🤎',
																'💔','❣','💕','💞','💓','💗','💖','💘','💝','💟',
																'✨','⭐','🌟','💫','🔥','💥','⚡','🌟','🎇','🎆',

																// Food
																'🍏','🍎','🍐','🍊','🍋','🍌','🍉','🍇','🍓','🫐','🍈','🍒','🍑','🥭','🍍',
																'🥥','🥝','🍅','🍆','🥑','🥦','🥬','🥒','🌶','🫑','🌽','🥕','🧄','🧅','🥔',

																// Misc fun
																'🎲','🎯','🎮','🎰','🎵','🎶','🎤','🎧',
																'🧩','🎎','🎏','🎐','🎀','🎁','🎉','🎊','🎈','🏆','🥇','🥈','🥉',
																'🚀','✈','🚁','🚗','🚌','🚜','🚲','🏍','🛵','🚂'
															];

													while($desc_data = mysql_fetch_array($desc_query)){

														$descriptions = $desc_data['description'];

														// ambil emoji acak
														$random_emoji = $emoji[array_rand($emoji)];

														echo "<li>$random_emoji $descriptions</li>";
													}
												?>
											</ul>
										</div>
									</div>
								</div>

								<?php 
									$first = false;
								} ?>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Main Content -->
		</div>

		<!-- Input Show By Input Lots Of Description -->
		<script>
			$(document).ready(function(){
				$("#lots").on("input", function(){
					var lots = $(this).val();
					var descWrapper = $("#desc-wrapper");
					descWrapper.empty(); // Clear previous inputs

					for(var i=1; i<=lots; i++){
						var descInput = `
							<div class="form-group" style="padding:10px; margin-top: -5px; margin-bottom:0px;">
								<label for="descriptions_`+i+`">Deskripsi Update `+i+`</label>
								<input type="text" class="form-control" id="descriptions_`+i+`" name="descriptions_`+i+`" placeholder="Masukkan Deskripsi Update `+i+`" required>                  
							</div>
						`;
						descWrapper.append(descInput);
					}
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
		<script>
			$(document).ready(function(){
				//Modal Password
				$('#modalPassword').on('shown.bs.modal', function (e) {
					$("#notifArea").html(alertLoadProcess);
					$("#data_password").load("password.php",function(){clearNotif();});
				})
			});
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