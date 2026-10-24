<?php

	// Cek apakah user sudah login
	if (
		!isset($_SESSION['username']) ||
		!isset($_SESSION['role']) ||
		empty($_SESSION['username']) ||
		empty($_SESSION['role'])
	) {
		header("Location: login.php");
		exit;
	}


	// Validasi role
	if (
		$_SESSION['role'] == 'spv' ||
		$_SESSION['role'] == 'pp' ||
		$_SESSION['role'] == 'keuangan'
	) {

		$role = $_SESSION['role'];

		$name = executescalar(
			"SELECT name FROM admin WHERE username = '" . $_SESSION['username'] . "'"
		);

	} elseif ($_SESSION['role'] == 'Cashier') {

		$role = $_SESSION['role'];

		$name = executescalar(
			"SELECT checker_name FROM checker WHERE checker_code = '" . $_SESSION['username'] . "'"
		);

	} else {

		// Role tidak valid
		session_unset();
		session_destroy();

		header("Location: login.php");
		exit;
	}

?>