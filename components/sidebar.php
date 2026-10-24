<?php
	function isActive($pages) {
		// return basename($_SERVER['PHP_SELF']) == $pages ? 'active' : '';
		return in_array(basename($_SERVER['PHP_SELF']), $pages) ? 'active' : '';
	}

	function isParentActive($pages) {
		return in_array(basename($_SERVER['PHP_SELF']), $pages) ? 'active' : '';
	}

	function greeting() {
		$hour = date('H');
	
		if ($hour >= 5 && $hour < 12) {
			return "Selamat pagi, ";
		} elseif ($hour >= 12 && $hour < 18) {
			return "Selamat siang, ";
		} elseif ($hour >= 18 && $hour < 21) {
			return "Selamat sore, ";
		} else {
			return "Selamat malam, ";
		}
	}

	$greetingMessage = greeting();
	if ($role == 'spv' || $role == 'pp' || $role == 'keuangan') {
		$photoUrl	= executeScalar("select photo from admin where username = '".$_SESSION['username']."'");
	} elseif ($role == 'Cashier') {
		$photoUrl	= executeScalar("select photo from checker where checker_code = '".$_SESSION['username']."'");
	}
	$privileges = executeScalar("SELECT privileges FROM admin WHERE username = '".$_SESSION['username']."'");
?>

<style>
    .silhouette {
        font-weight: bold;
        font-size: 20px;
        background: linear-gradient(120deg, #ffffff 30%, #ec9841 50%, #ffffff 70%);
        background-size: 200% auto;
        background-clip: text;
        -webkit-background-clip: text;
        color: transparent;
        animation: silhouetteMove 5s linear infinite;
    }

    @keyframes silhouetteMove {
        0% { background-position: 200% center; }
        100% { background-position: -200% center; }
    }

	/* Image Profile */
	.nav-profile-img {
		width: 20px;
		height: 20px;
		border-radius: 50%;
		object-fit: cover;
		object-position: center;
		border: 2px solid #fff;
		box-shadow: 0 0 5px rgba(255,255,255,0.7);
		transition: transform .2s ease-in-out;
		vertical-align: middle;
	}

	/* BADGE STYLE */
	.achievement-badge-head {
		position: absolute;
		top: -5px;
		right: -70px;
		z-index: 5;
	}

	.level-badge-nav {
		display: inline-flex;
		align-items: center;
		width: fit-content; 
		padding: 5px 10px;
		border-radius: 30px;
		font-weight: 600;
		font-size: 9px;
		gap: 6px;
		white-space: nowrap; 
		flex: 0 0 auto;
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
	.level-badge-nav.color-developer-nav {
		background: linear-gradient(45deg, #524949ff, #000000);
		color: #fff;
		box-shadow: 0 0 15px #f7c40eff;
	}
	
	.level-badge-nav.color-manager-nav {
		background: linear-gradient(45deg, #ef4646ff, #9a0404ff);
		color: #fff;
		box-shadow: 0 0 15px #f7c40eff;
	}

	/* Collapse Sidebar */
	/* Sidebar tetap bisa scroll */
	.sidebar-nav {
		overflow-y: auto;
		scrollbar-width: none;        /* Firefox */
		-ms-overflow-style: none;     /* IE & Edge lama */
	}

	/* Chrome, Safari, Edge */
	.sidebar-nav::-webkit-scrollbar {
		width: 0;
		height: 0;
	}
	.sidebar {
		width: 230px;
		transition: all 0.3s ease;
	}

	/* Content ikut geser */
	#page-wrapper {
		margin-left: 240px;
		transition: all 0.3s ease;
	}

	/* Mode sidebar kecil */
	body.sidebar-collapse .sidebar {
		width: 60px;
	}

	/* Content ikut mengecil */
	body.sidebar-collapse #page-wrapper {
		margin-left: 60px;
	}

	/* Sembunyikan teks menu */
	body.sidebar-collapse .sidebar .nav > li > a span,
	body.sidebar-collapse .sidebar .nav-second-level {
		display: none;
	}

	/* Tengah ikon */
	body.sidebar-collapse .sidebar .nav > li > a {
		text-align: center;
		padding-left: 0;
		padding-right: 0;
	}

	/* === PROFILE SAAT COLLAPSE === */
	body.sidebar-collapse .profile-sidebar {
		justify-content: center;   /* center horizontal */
		padding: 15px 0;
	}

	/* Sembunyikan text */
	body.sidebar-collapse .profile-sidebar .text-profile {
		display: none;
	}

	/* Foto tetap center & proporsional */
	body.sidebar-collapse .profile-sidebar img {
		margin: 0;
		width: 40px;
		height: 40px;
		cursor: pointer;
	}

	body.sidebar-collapse .profile-sidebar:hover img {
		transform: scale(1.05);
		transition: 0.2s;
	}

	.sidebar-toggle-btn {
		background: transparent;
		border: none;
		color: #fff;
		font-size: 18px;
		width: 40px;
		height: 40px;
		margin-left: 5px;
		margin-top: 5px;
		cursor: pointer;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.sidebar-toggle-btn:hover {
		background: rgba(255,255,255,0.2);
		border-radius: 4px;
	}

	/* ===== SIDEBAR DARK MODE ===== */
	.sidebar {
		width: 240px;
		background-color: #1f2937;
		border-right: 1px solid #2d3748;
		transition: all 0.3s ease;
	}

	/* Menu utama */
	.sidebar .nav > li > a {
		color: #e5e7eb;
		padding: 12px 18px;
		font-size: 14px;
		transition: all 0.2s ease;
	}

	/* Icon */
	.sidebar .nav > li > a i {
		color: #e5e7eb;
		width: 20px;
		text-align: center;
		margin-right: 8px;
	}

	/* Hover */
	.sidebar .nav > li > a:hover {
		background-color: #374151;
		color: #ffffff;
	}

	/* Active menu */
	.sidebar .nav > li.active > a,
	.sidebar .nav > li > a.active {
		background-color: #111827;
		color: #ffffff;
	}

	/* Submenu */
	.sidebar .nav-second-level {
		background-color: #111827;
	}

	.sidebar .nav-second-level li a {
		color: #cbd5f5;
		padding-left: 40px;
	}

	.sidebar .nav-second-level li a:hover {
		background-color: #1f2937;
		color: #ffffff;
	}

	.sidebar .nav > li {
    	border-bottom: 1px solid rgba(255,255,255,0.06);
	}

	/* ==============================
	PROFILE CARD (NORMAL)
	================================ */
	.profile-card-sidebar {
		display: flex;
		align-items: center;
		gap: 12px;
		padding: 12px;
		margin: 15px;
		background:
			linear-gradient(135deg, #334155, #020617),
			radial-gradient(circle at top left, rgba(59,130,246,.18), transparent 55%);
		border-radius: 14px;
		box-shadow: 0 6px 12px rgba(0,0,0,.35);
		transition: all .3s ease;
		position: relative;
		overflow: hidden;
		z-index: 1;
	}

	/* Ring cahaya */
	.profile-card-sidebar::before {
		content: "";
		position: absolute;
		inset: -2px;
		background: conic-gradient(
			from 0deg,
			transparent 0deg,
			#facc15 60deg,
			#fde68a 120deg,
			#f59e0b 180deg,
			#fde68a 240deg,
			#facc15 300deg,
			transparent 360deg
		);
		animation: rotateGlow 6s linear infinite;
		filter: blur(6px);
		opacity: .9;
		z-index: -1;
	}

	/* Mask agar glow hanya di pinggir */
	.profile-card-sidebar::after {
		content: "";
		position: absolute;
		inset: 2px;
		background:
			linear-gradient(135deg, #334155, #020617),
			radial-gradient(circle at top left, rgba(59,130,246,.18), transparent 55%);
		border-radius: 14px;
		z-index: -1;
	}

	/* Animasi putar */
	@keyframes rotateGlow {
		from {
			transform: rotate(0deg);
		}
		to {
			transform: rotate(360deg);
		}
	}

	.profile-card-sidebar:hover {
		transform: translateY(-2px);
		box-shadow: 0 10px 18px rgba(0,0,0,.45);
	}

	/* ==============================
	AVATAR
	================================ */
	.profile-avatar {
		position: relative;
		flex-shrink: 0;
	}

	.profile-avatar img {
		width: 48px;
		height: 48px;
		border-radius: 50%;
		object-fit: cover;
		border: 2px solid #3b82f6;
		cursor: pointer;
	}

	/* STATUS ONLINE */
	.status-online {
		position: absolute;
		bottom: 2px;
		right: 2px;
		width: 10px;
		height: 10px;
		background: #22c55e;
		border: 2px solid #0f172a;
		border-radius: 50%;
	}

	/* ==============================
	PROFILE INFO
	================================ */
	.profile-info b {
		display: block;
		font-size: 14px;
		color: #ffffff;
	}

	.profile-info span {
		font-size: 11px;
		color: #94a3b8;
	}

	/* ROLE BADGE */
	.profile-card-sidebar .role-badge {
		display: inline-block;
		margin-top: 2px;
		padding: 3px 8px;
		font-size: 10px;
		border-radius: 20px;
		background: #2563eb;
		color: #ffffff !important;
		line-height: 1.3;
	}


	/* ==============================
	PROFILE CARD SAAT COLLAPSE
	================================ */
	body.sidebar-collapse .profile-card-sidebar {
		justify-content: center;
		align-items: center;
		padding: 12px 0;
		margin: 15px auto;
		width: 60px;
		height: 60px;
		border-radius: 50%;
		background:
			linear-gradient(135deg, #334155, #020617),
			radial-gradient(circle at top, rgba(59,130,246,.25), transparent 60%);
	}

	/* SEMBUNYIKAN TEKS */
	body.sidebar-collapse .text-profile {
		display: none;
	}

	/* SEMBUNYIKAN TEKS */
	body.sidebar-collapse .profile-info {
		display: none;
	}

	/* AVATAR SAAT COLLAPSE */
	body.sidebar-collapse .profile-avatar img {
		width: 42px;
		height: 42px;
		border-width: 2px;
	}

	/* STATUS ONLINE SAAT COLLAPSE */
	body.sidebar-collapse .status-online {
		bottom: 3px;
		right: 3px;
	}

	/* HOVER SAAT COLLAPSE */
	body.sidebar-collapse .profile-card-sidebar:hover {
		transform: scale(1.05);
		box-shadow: 0 10px 22px rgba(0,0,0,.6);
	}

	/* Text */
	.text-profile {
		display: flex;
		flex-direction: column;
		line-height: 1.2;
	}

	.text-profile b {
		color: #ffffff;
		font-size: 14px;
		margin-bottom: 5px;
	}

	.text-profile span {
		color: #9ca3af;     /* abu lembut */
		font-size: 14px;
	}

	/* ======================================================
	BASE SIDEBAR CARD (ALL LEVEL)
	====================================================== */
	.sidebar-nav .nav li > a {
		display: flex;
		align-items: center;
		gap: 12px;
		position: relative;

		padding: 12px 14px;
		margin: 6px 10px;
		border-radius: 14px;

		background: rgba(255,255,255,0.04);
		backdrop-filter: blur(4px);

		color: #cbd5e1;
		transition: all .3s ease;
	}

	/* Text fleksibel agar arrow ke kanan */
	.sidebar-nav .nav li > a span {
		flex: 1;
	}

	/* Hover card */
	.sidebar-nav .nav li > a:hover {
		background: rgba(250, 204, 21, 0.10);
		transform: translateX(4px);
		color: #fff;
	}

	/* ======================================================
	ICON MINI CARD
	====================================================== */
	.sidebar-nav .nav li > a i:not(.arrow) {
		width: 34px;
		height: 34px;
		min-width: 34px;

		display: flex;
		align-items: center;
		justify-content: center;

		border-radius: 10px;
		background: rgba(255,255,255,0.08);

		color: #facc15;
		font-size: 14px;

		transition: all .3s ease;
	}

	/* Hover icon */
	.sidebar-nav .nav li > a:hover i:not(.arrow) {
		background: rgba(250, 204, 21, 0.25);
		color: #fff;
	}

	/* ======================================================
	ARROW (SELALU DI KANAN)
	====================================================== */
	.sidebar-nav .nav li > a .arrow {
		margin-left: auto;
		font-size: 13px;
		opacity: 0.7;
		transition: transform .3s ease;
	}

	/* Arrow rotate saat submenu open */
	.sidebar-nav .nav li.open > a .arrow {
		transform: rotate(180deg);
	}

	/* ======================================================
	ACTIVE STATE (ALL LEVEL)
	====================================================== */
	.sidebar-nav .nav li > a.active {
		background: linear-gradient(135deg, #facc15, #f59e0b);
		color: #1f2937;
		font-weight: 600;

		box-shadow:
			0 0 12px rgba(250, 204, 21, 0.9),
			0 0 28px rgba(250, 204, 21, 0.6);

		animation: glowPulse 1.8s infinite alternate;
	}

	/* Icon aktif */
	.sidebar-nav .nav li > a.active i:not(.arrow) {
		background: rgba(31, 41, 55, 0.25);
		color: #1f2937;
		box-shadow: inset 0 0 8px rgba(0,0,0,0.25);
	}

	/* Garis samping emas */
	.sidebar-nav .nav li > a.active::before {
		content: '';
		position: absolute;
		left: -6px;
		top: 15%;
		width: 4px;
		height: 70%;
		background: linear-gradient(to bottom, #fde68a, #f59e0b);
		border-radius: 5px;
	}

	/* ======================================================
	INDENT LEVEL (HIRARKI MENU)
	====================================================== */

	/* SECOND LEVEL */
	.sidebar-nav .nav-second-level > li > a {
		margin-left: 24px;
		padding-left: 16px;
		background: rgba(255,255,255,0.03);
	}

	/* THIRD LEVEL */
	.sidebar-nav .nav-third-level > li > a {
		margin-left: 44px;
		padding-left: 16px;
		background: rgba(255,255,255,0.02);
	}

	/* Active second & third tetap glow */
	.sidebar-nav .nav-second-level li > a.active,
	.sidebar-nav .nav-third-level li > a.active {
		background: linear-gradient(135deg, #facc15, #f59e0b);
		color: #1f2937;
	}

	/* ======================================================
	GLOW ANIMATION
	====================================================== */
	@keyframes glowPulse {
		from {
			box-shadow:
				0 0 8px rgba(250, 204, 21, 0.6),
				0 0 20px rgba(250, 204, 21, 0.4);
		}
		to {
			box-shadow:
				0 0 16px rgba(250, 204, 21, 1),
				0 0 36px rgba(250, 204, 21, 0.8);
		}
	}
</style>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0; background-color: #428bca;">
	<div class="navbar-header bg-primary">
    	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="dashboard.php" style="color: #ffffff; background-color: #111827; width: 240px;"><i class="fa fa-balance-scale fa-fw silhouette"></i> <b class="silhouette">LISTRIK PISS</b></a>
		<button type="button" class="sidebar-toggle-btn"
			onclick="toggleSidebar()">
			<i class="fa fa-bars"></i>
		</button>
    </div>
			
	<ul class="nav navbar-top-links navbar-right">
		<?php include 'components/clock.php'; ?>&nbsp;&nbsp;
		<?php include 'components/offcanvas_note.php'; ?>
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#" 
			style="color: #ffffff !important; background-color: transparent !important;"
			onmouseover="this.style.backgroundColor='rgb(103, 165, 218)'" 
			onmouseout="this.style.backgroundColor='transparent'">
				
				<i class="fa fa-cog" style="color: #ffffff;"></i>&nbsp;
				<b style="text-transform: capitalize; color: #ffffff;">Pengaturan</b>&nbsp;
				<i id="dropdownIcon" class="fa fa-angle-down" style="color: #ffffff;"></i>
			</a>
			<ul class="dropdown-menu dropdown-user" style="width: 200px; margin-right: 10px; margin-top: 10px; border: 3px solid #ffffff; background-color: #428bca; border-radius: 10px;">
				<li>
					<a href="profile.php" 
					style="color: #ffffff; font-size: 15px; display: block; padding: 10px; text-decoration: none;"
					onmouseover="this.style.backgroundColor='rgb(103, 165, 218)'; this.style.color='#ffffff';"
					onmouseout="this.style.backgroundColor='transparent'; this.style.color='#ffffff';">
						<div class="name" style="display: inline-block; padding-right: 100px; padding-left: 10px;">
							Profil
						</div>
						<div class="icon" style="display: inline-block;">
							<i class="fa fa-user fa-fw" style="color: #ffffff; font-size: 15px;"></i>
						</div>
					</a>
				</li>
			<!-- <li>
					<a data-toggle="modal" data-target="#modalPassword" href="#" 
					style="color: #ffffff; font-size: 15px; display: block; padding: 10px; text-decoration: none;"
					onmouseover="this.style.backgroundColor='rgb(103, 165, 218)'; this.style.color='#ffffff';"
					onmouseout="this.style.backgroundColor='transparent'; this.style.color='#ffffff';">
						<div class="name" style="display: inline-block; padding-right: 30px; padding-left: 10px;">
							Ganti Password 
						</div>
						<div class="icon" style="display: inline-block;">
							<i class="fa fa-lock fa-fw" style="color: #ffffff; font-size: 15px;"></i>
						</div>
					</a>
				</li> -->
				<li class="divider"></li>
				<li>
					<a data-toggle="modal" data-target="#modalLogout" href="#" 
					style="color: #ffffff; font-size: 15px; display: block; padding: 10px; text-decoration: none;"
					onmouseover="this.style.backgroundColor='rgb(103, 165, 218)'; this.style.color='#ffffff';"
					onmouseout="this.style.backgroundColor='transparent'; this.style.color='#ffffff';">
						<div class="name" style="display: inline-block; padding-right: 95px; padding-left: 10px;">
							Keluar
						</div>
						<div class="icon" style="display: inline-block;">
							<i class="fa fa-sign-out fa-fw" style="color: #ffffff; font-size: 15px;"></i>
						</div>
					</a>
				</li>
			</ul>
		</li>
	</ul>

			<!-- Modal Password -->
			<div class="modal fade" id="modalPassword" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
				<div class="modal-dialog" >
					<div class="modal-content">
						<div class="modal-header bg-primary text-white" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
							<h4 id="header_password"><i class="fa fa-lock fa-fw"></i>&nbsp;Ganti Password</h4>
							<button style="margin-top: -35px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div id="data_password" style="margin-bottom: 0px;">
								<div class="alert alert-info" onclick="clearNotif()"><h3><i class="fa fa-spinner fa-spin"></i> Loading...</h3></div>
							</div>
							<input type="hidden" id="value_id" />
						</div>
					</div>
				</div>
			</div>

			<!-- Modal Logout -->
			<div class="modal fade" id="modalLogout" tabindex="-1" role="dialog" aria-labelledby="modalLogoutLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header bg-primary text-white" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
							<h5 class="modal-title" id="modalLogoutLabel"><b>KONFIRMASI KELUAR</b></h5>
							<button style="margin-top: -20px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<p>Apakah Anda yakin ingin keluar?</p>
						</div>
						<div class="modal-footer d-flex justify-content-between">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
							<a href="logout.php" class="btn btn-primary">Keluar</a>
						</div>
					</div>
				</div>
			</div>
            
            <div class="navbar-default sidebar" role="navigation">
				<div class="sidebar-nav navbar-collapse" style="min-height: 100vh;  background-color: #1f2937;">
					<ul class="nav" id="side-menu" style="margin-bottom: 70px;">
						<!-- Profile -->
						<div class="profile-card-sidebar" id="photoContainerProfile">
							<div class="profile-avatar">
								<img id="previewPhoto"
								src="<?php echo $photoUrl ? '../uploads/' . $photoUrl : '../uploads/profile-default.png'; ?>">
								<span class="status-online"></span>
							</div>

							<div class="<?= $role == 'spv' ? 'text-profile' : 'profile-info' ?>">
								<b style="text-transform: capitalize; color: #ffffff;">
									<?php 
										if ($role == 'Cashier') {
											echo $name;
										} elseif ($role == 'pp' || $role == 'spv' || $role == 'keuangan') {
											echo $name;
										} 
									?>
								</b>
								<span>
									<?php 
										if ($role == 'Cashier') {
											echo '<span class="role-badge">Kasir</span>';
										} elseif ($role == 'pp') {
											echo '<span class="role-badge">PP</span>';
										}
										elseif ($role == 'keuangan') {
											echo '<span class="role-badge">Keuangan</span>';
										} elseif ($role == 'spv') {
											if ($privileges == 'manager') { ?>
												<div class="level-badge-nav color-manager-nav">
													<i class="fa fa-diamond fa-lg"></i>MANAGER
												</div>
											<?php } elseif ($privileges == 'developer') { ?>
												<div class="level-badge-nav color-developer-nav">
													<i class="fa fa-code fa-lg"></i>DEVELOPER
												</div>
											<?php }
										}
									?>
								</span>
							</div>
						</div>

						<!-- Navigation -->
                        <li><a class="<?= isActive(['dashboard.php']); ?>" href="dashboard.php"><i class="fa fa-dashboard fa-fw"></i> <span>Dashboard</span></a></li>
                        <li><a class="<?= isActive(['register.php', 'merchant_edit.php']); ?>" href="register.php"><i class="fa fa-user fa-fw"></i> <span>Pengguna Listrik</span></a></li>
						<!-- <li class="<?= isParentActive(['register.php', 'merchant.php', 'merchant_edit.php']); ?>">
                            <a href="#"><i class="fa fa-user fa-fw"></i> Pengguna Listrik<span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li><a class="<?= isActive(['register.php', 'merchant_edit.php']); ?>" href="register.php"><i class="fa fa-user-plus fa-fw"></i> Tambah Pengguna</a></li>
								<li><a class="<?= isActive(['merchant.php', 'merchant_edit.php']); ?>" href="merchant.php"><i class="fa fa-users fa-fw"></i> Data Pengguna Listrik</a></li>
							</ul>
						</li> -->

						<?php if ($_SESSION['role'] == 'Cashier') { ?>
							<li><a class="<?= isActive(['invoice.php']); ?>" href="invoice.php">
									<i class="fa fa-print fa-fw"></i> <span>Cetak Tagihan</span>
							</a></li>
						<?php } else { ?>
							<li class="<?= isParentActive(['periode.php', 'invoice.php', 'invoice_cancel.php']); ?>">
								<a href="#">
									<i class="fa fa-clipboard fa-fw"></i> <span>Tagihan Listrik</span>
									<span class="fa arrow"></span>
								</a>
								<ul class="nav nav-second-level">
									<li>
										<a class="<?= isActive(['periode.php']); ?>" href="periode.php">
											<i class="fa fa-clock-o fa-fw"></i> Periode Tagihan
										</a>
									</li>
									<li>
										<a class="<?= isActive(['invoice.php']); ?>" href="invoice.php">
											<i class="fa fa-print fa-fw"></i> Cetak Tagihan
										</a>
									</li>
									<!--
									<li>
										<a class="<?= isActive(['invoice_cancel.php']); ?>" href="invoice_cancel.php">
											<i class="fa fa-close fa-fw"></i> Pembatalan Tagihan
										</a>
									</li>
									-->
								</ul>
							</li>
						<?php } ?>

						<li class="<?= isParentActive(['pay.php', 'pay_cancel.php']); ?>">
                            <a href="#"><i class="fa fa-money fa-fw"></i> <span>Pembayaran</span><span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<li><a class="<?= isActive(['pay.php']); ?>" href="pay.php"><i class="fa fa-money fa-fw"></i> Pembayaran Tagihan</a></li>
								<li><a class="<?= isActive(['pay_cancel.php']); ?>" href="pay_cancel.php" style="display:flex; align-items:center;"><i class="fa fa-close fa-fw"></i> Pembatalan Pembayaran</a></li>
							</ul>
						</li>

						<?php if($_SESSION['role']=='Cashier'){
							
						}
						else{ ?>
						<li class="<?= isParentActive(['admin.php', 'tarif.php', 'tarif2.php', 'note.php']); ?>">
                            <a href="#"><i class="fa fa-database fa-fw"></i> <span>Master</span><span class="fa arrow"></span></a>
							<ul class="nav nav-second-level">
								<?php if($_SESSION['role'] == 'spv'){ ?>
									<li><a class="<?= isActive(['admin.php']); ?>" href="admin.php"><i class="fa fa-group fa-fw"></i> SPV / PP / Keuangan</a></li>
								<?php } ?>
								<li><a class="<?= isActive(['tarif.php']); ?>" href="tarif.php"><i class="fa fa-flash fa-fw"></i> Daya Listrik</a></li>
								<li><a class="<?= isActive(['tarif2.php']); ?>" href="tarif2.php"><i class="fa fa-suitcase fa-fw"></i> Perlengkapan Listrik</a></li>
								<li><a class="<?= isActive(['note.php']); ?>" href="note.php"><i class="fa fa-file-text fa-fw"></i> Catatan Pelanggan</a></li>
							</ul>
						</li>
						<?php } ?>

						<li><a class="<?= isActive(['report.php']); ?>" href="report.php"><i class="fa fa-clipboard fa-fw"></i> <span>Laporan</span></a></li>
						<li><a class="<?= isActive(['changelog.php']); ?>" href="changelog.php"><i class="fa fa-history fa-fw"></i> <span>Update Log</span></a></li>
                    </ul>
                </div>
            </div>
            </nav>

<!-- <script>
    function formatTime(seconds) {
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        const remainingSeconds = seconds % 60;
        return `${hours}j ${minutes}m ${remainingSeconds}d`;
    }

    function startWorkTime() {
        let loginTime = localStorage.getItem('loginTime');

        if (!loginTime) {
            loginTime = new Date().getTime();
            localStorage.setItem('loginTime', loginTime);
        }

        setInterval(function() {
            const currentTime = new Date().getTime();
            const timeElapsed = Math.floor((currentTime - loginTime) / 1000);
            const formattedTime = formatTime(timeElapsed);
            document.getElementById('workHoursLink').innerHTML = `<i class="fa fa-clock-o fa-fw"></i> Jam Kerja : ${formattedTime}`;
        }, 1000);
    }

    function logout() {
        localStorage.removeItem('loginTime');
		localStorage.removeItem('notificationHidden');
    }

    startWorkTime();

    document.getElementById("logoutButton").addEventListener("click", function() {
        logout();
    });
</script> -->

<script>
	$(document).ready(function() {
		$(".dropdown").on("shown.bs.dropdown", function() {
			$("#dropdownIcon").removeClass("fa-angle-down").addClass("fa-angle-up");
		});

		$(".dropdown").on("hidden.bs.dropdown", function() {
			$("#dropdownIcon").removeClass("fa-angle-up").addClass("fa-angle-down");
		});
	});
</script>

<!-- Viewer JS untuk zoom foto profil -->
<script>
	document.addEventListener("DOMContentLoaded", function () {

		const container = document.getElementById('photoContainerProfile');

		const viewer = new Viewer(container, {
			navbar: false,
			toolbar: true,
			title: false,
			zoomRatio: 0.5,
		});

	});
</script>

