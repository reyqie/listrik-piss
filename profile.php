<?php
	session_start();
	include "connection.php";
	include "components/role_session.php";

	$username	= $_SESSION['username'];
	if ($role == 'spv' || $role == 'pp') {
		$role 		= executeScalar("select role from admin where username = '".$username."'");
		$password	= executeScalar("select password from admin where username = '".$username."'");
		$photoUrl	= executeScalar("select photo from admin where username = '".$username."'");
	} elseif ($role == 'Cashier') {
		$role 		= 'Cashier';
		$password	= executeScalar("select checker_pass from checker where checker_code = '".$username."'");
		$photoUrl	= executeScalar("select photo from checker where checker_code = '".$username."'");
	}

	function headScript(){
		$headScript=file_get_contents("headScript.html");
		return $headScript;
	}
?>

<style>
	.password-wrapper {
		position: relative;
		width: 100%;
	}
	.password-wrapper input {
		padding-right: 40px; /* kasih ruang buat ikon */
	}
	.password-wrapper .toggle-password {
		position: absolute;
		right: 10px;
		top: 50%;
		transform: translateY(-50%);
		background: none;
		border: none;
		color: #666;
		cursor: pointer;
	}
	.password-wrapper .toggle-password:hover {
		color: #000;
	}


	.upload-box:hover {
		background: #e7f1ff;
	}

	.upload-box i {
		font-size: 40px;
		color: #0d6efd;
	}
	#photo { display: none; }

	.upload-box {
		width: 100%;
		height: 180px; /* tinggi tetap */
		border: 2px dashed #007bff;
		border-radius: 10px;
		text-align: center;
		padding: 20px;
		cursor: pointer;
		position: relative;
		overflow: hidden; /* penting! gambar tidak boleh memperbesar box */
	}

	.upload-box img {
		width: 100%;
		height: 100%;
		object-fit: cover; /* gambar menyesuaikan box, bukan sebaliknya */
		display: none;
		border-radius: 10px;
	}

	.profile-card {
		width: 100%;
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
		border-radius: 10px;
		padding: 20px 15px;
		box-shadow: 0 3px 7px rgba(0,0,0,0.15);
		text-align: center;
		border: 1px solid #ddd;

		/* Default background */
		background-image: url('img/bg-profile.png');

		/* Smooth transition */
		transition: background-image 1s ease-in-out, opacity 1s ease-in-out;
	}

	.bg2 {
		background-image: url('img/bg-profile2.png') !important;
	}

	.profile-card {
		position: relative;
		overflow: hidden;
	}

	/* Overlay hitam */
	.profile-card::before {
		content: "";
		position: absolute;
		inset: 0;
		background: rgba(0,0,0,0.40); /* 0.35 = gelap halus */
		z-index: 0;
		border-radius: inherit;
	}

	/* Agar isi tetap muncul di atas */
	.profile-card * {
		position: relative;
		z-index: 1;
	}

	.profile-card .img-profile {
		position: relative;
		display: inline-block;
	}

	.profile-card img {
		width: 120px;
		height: 120px;
		border-radius: 50%;
		border: 5px solid #fff;
		object-fit: cover;
		margin-bottom: 15px;
		background: #f0f0f0;
		cursor: pointer;
	}

	.profile-card h3 {
		margin: 0;
		font-weight: bold;
		color: #fff;
	}

	.profile-card p {
		margin: 5px 0;
		color: #fff;
	}

	.profile-card .role-label {
		font-size: 15px;
		background: #3498db;
		color: white;
		padding: 5px 10px;
		border-radius: 20px;
		display: inline-block;
		margin-top: 10px;
	}

	#cropModal .modal-dialog {
		width: 500px;
	}

	.crop-container {
		width: 100%;
		height: 400px; 
		display: flex;
		justify-content: center;
		align-items: center;
		background: #f3f3f3;
		border-radius: 8px;
		overflow: hidden;
		padding: 0;
	}

	#cropImage {
		width: 100%;           /* Bikin gambar memenuhi container */
		height: auto;
		max-width: none; 
	}

	/* BADGE STYLE */
	.achievement-badge-head {
		position: absolute;
		top: -5px;
		right: -70px;
		z-index: 5;
	}

	.level-badge {
		display: inline-flex;
		align-items: center;
		padding: 10px 18px;
		border-radius: 30px;
		font-weight: 600;
		font-size: 12px;
		gap: 8px;
		color: white;
		/* box-shadow: 0 4px 8px rgba(0,0,0,0.25); */
		animation: popIn .4s ease;
	}

	/* ANIMASI */
	@keyframes popIn {
		from { transform: scale(.7); opacity: 0; }
		to   { transform: scale(1); opacity: 1; }
	}

	/* Color Badge */
	.level-badge.color-developer {
		background: linear-gradient(45deg, #524949ff, #000000);
		color: #fff;
		box-shadow: 0 0 15px #f7c40eff;
	}
	
	.level-badge.color-manager {
		background: linear-gradient(45deg, #ef4646ff, #9a0404ff);
		color: #fff;
		box-shadow: 0 0 15px #f7c40eff;
	}
</style>

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
		<title>Profile | PISS</title>

		<?php echo headScript(); ?>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script src="../js/jquery.min.js"></script>
		<!-- input number -->
		<link href="../js/touchpin/jquery.bootstrap-touchspin.css" rel="stylesheet" type="text/css" media="all">
		<script src="../js/touchpin/jquery.bootstrap-touchspin.js"></script>
		<script>
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
		<link rel="stylesheet" href="https://unpkg.com/viewerjs/dist/viewer.css">
		<script src="https://unpkg.com/viewerjs/dist/viewer.js"></script>
	</head>
	<body>
		<div id="wrapper">
		<?php include "components/sidebar.php" ?>

			<div id="page-wrapper">
				<br><br><br><br>	
				<div class="row">
					<div class="col-md-12">
						<div class="profile-preview">
							<div class="profile-card">
								<div class="img-profile" id="photoContainer">
									<div class="achievement-badge-head">
										<?php 
											if ($role == 'spv') {
												$privileges = executeScalar("SELECT privileges FROM admin WHERE username = '$username'");
												if ($privileges == 'manager') { ?>
													<div class="level-badge color-manager">
														<i class="fa fa-diamond fa-lg"></i>MANAGER
													</div>
												<?php } elseif ($privileges == 'developer') { ?>
													<div class="level-badge color-developer">
														<i class="fa fa-code fa-lg"></i>DEVELOPER
													</div>
												<?php }
											}
										?>
									</div>
									<img id="previewPhoto"
									src="<?php echo $photoUrl ? '../uploads/' . $photoUrl : '../uploads/profile-default.png'; ?>"
									style="width:120px; height:120px; border-radius:50%;">
								</div>
								
								<h3 id="previewName"><?php echo $name; ?></h3>
								<p id="previewUsername">@<?php echo $username; ?></p>
								<span class="role-label" id="previewRole" style="text-transform: uppercase;"><?php echo $role; ?></span>
							</div>
						</div>
					</div>
				</div>

				<div class="row" style="margin-top: 20px;">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h4 class="panel-title">
									<i class="fa fa-user"></i>&nbsp; Setting Profil
								</h4>
							</div>
							<div class="panel-body">
								<div class="panel-group" id="accordionChangelog" style="padding: 5px 15px 0px;;">
									<form action="profile_action.php" class="form-horizontal" id="profile" name = "profile" method="POST" enctype="multipart/form-data">
										<fieldset>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group" style="margin-right: 5px;">
														<label for="name">
															Nama Lengkap
														</label>
														<input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap" value="<?php echo $name; ?>" required>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group" style="margin-left: 5px;">
														<label for="role">
															Role
														</label>
														<input type="text" class="form-control" id="role" name="role" placeholder="Role" value="<?php echo $role; ?>" disabled>
													</div>
												</div>
											</div>

											<div class="row" style="margin-top: 10px;">
												<!-- Username Lama -->
												<input type="hidden" name="old_username" value="<?php echo $username; ?>">

												<!-- Username Baru -->
												<div class="col-md-6">
													<div class="form-group" style="margin-right: 5px;">
														<label for="username">Username</label>
														<input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $username; ?>" required>
													</div>
												</div>

												<!-- Password Lama -->
												<input type="hidden" name="old_password" value="<?php echo $password; ?>">

												<!-- Password Baru -->
												<div class="col-md-6">
													<div class="form-group" style="margin-left: 5px;">
														<label for="password">
															Password
														</label>
														<div class="password-wrapper" style="margin-top:5px;">
															<input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo $password; ?>" />
															<button type="button" class="toggle-password" onclick="togglePassword('password', this)">
																<i class="fa fa-eye-slash text-primary"></i>
															</button>
														</div>
													</div>
												</div>
											</div>

											<div class="row" style="margin-top: 10px;">
												<div class="col-md-12">
													<label for="photo">
														<div class="upload-box">
															<img id="photoPreview"><br>
															<i class="fa fa-cloud-upload"></i>
															<h5>Upload Foto</h5>
															<small>Klik untuk memilih file</small>
														</div>
													</label>

													<input type="file" id="photo" name="photo" style="display:none;">
												</div>
											</div>

											<div class="row" style="margin-top: 20px;">
												<div class="col-md-12 text-right">
													<button type="submit" class="btn btn-primary btn-md">
														<i class="fa fa-save"></i> Simpan Profil
													</button>
												</div>
											</div>
										</fieldset>
									</form>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
			<!-- End Main Content -->
		</div>


		<!-- Modal Cropper -->
		<div id="cropModal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header bg-primary">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Crop Foto</h4>
					</div>
					<div class="modal-body">
						<div class="crop-container">
							<img id="cropImage" style="max-width:100%; height:auto;">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
						<button type="button" id="cropBtn" class="btn btn-primary">
							<i class="fa fa-check"></i> Upload Foto
						</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Viewer JS untuk zoom foto profil -->
		<script>
			document.addEventListener("DOMContentLoaded", function () {

				const container = document.getElementById('photoContainer');

				const viewer = new Viewer(container, {
					navbar: false,
					toolbar: true,
					title: false,
					zoomRatio: 0.5,
				});

			});
		</script>


		<!-- Script Background -->
		<script>
			setInterval(() => {
				const card = document.querySelector('.profile-card');
				card.classList.toggle('bg2');  // toggle ke bg2 atau kembali ke bg1
			}, 5000); // 5000ms = 5 detik
		</script>

		<!-- Script Cropper -->
		<script>
			var cropper;
			var cropImage = document.getElementById('cropImage');
			var inputPhoto = document.getElementById('photo');
			var preview = document.getElementById('photoPreview');

			inputPhoto.addEventListener('change', function (e) {

				var file = e.target.files[0];
				if (!file) return;

				var reader = new FileReader();
				reader.onload = function (event) {

					cropImage.src = event.target.result;

					$('#cropModal').modal('show');

					if (cropper) {
						cropper.destroy();
					}

					cropper = new Cropper(cropImage, {
						aspectRatio: 1,
						viewMode: 1,
						autoCropArea: 1,
						minContainerWidth: 350,
						minContainerHeight: 350,
					});
				};

				reader.readAsDataURL(file);
			});

			document.getElementById('cropBtn').addEventListener('click', function () {

				var canvas = cropper.getCroppedCanvas({
					width: 400,
					height: 400
				});

				canvas.toBlob(function (blob) {
					var croppedFile = new File([blob], "cropped.png", { type: "image/png" });

					var dataTransfer = new DataTransfer();
					dataTransfer.items.add(croppedFile);

					inputPhoto.files = dataTransfer.files;

					// 🔥 Preview hasil crop
					var previewUrl = URL.createObjectURL(blob);
					preview.src = previewUrl;
					preview.style.display = "block";

					// 🔥 Sembunyikan ikon + teks upload
					document.querySelector(".upload-box i").style.display = "none";
					document.querySelector(".upload-box h5").style.display = "none";
					document.querySelector(".upload-box small").style.display = "none";

					$('#cropModal').modal('hide');
				});
			});
		</script>


		<!-- Cropper JS -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
		<!-- jQuery -->
		<script src="js/jquery.js"></script>
		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.min.js"></script>
		<!-- Metis Menu Plugin JavaScript -->
		<script src="js/plugins/metisMenu/metisMenu.min.js"></script>
		<!-- Custom Theme JavaScript -->
		<script src="js/sb-admin-2.js"></script>
		<script>
			function togglePassword(id, btn) {
				const input = document.getElementById(id);
				const icon = btn.querySelector('i');

				if (input.type === "password") {
					input.type = "text";
					icon.classList.remove("fa-eye-slash");
					icon.classList.add("fa-eye");
				} else {
					input.type = "password";
					icon.classList.remove("fa-eye");
					icon.classList.add("fa-eye-slash");
				}
			}

			document.getElementById('photo').addEventListener('change', function () {
				var fileName = this.files[0].name;
				document.getElementById('fileName').innerText = "File dipilih: " + fileName;
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