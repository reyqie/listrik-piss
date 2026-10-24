<?php
	session_start();
	include "connection.php";
	include "components/role_session.php";

	$name          = $_POST['name'];
	$username      = $_POST['username'];        // username baru
	$old_username  = $_POST['old_username'];    // username lama
	$password      = $_POST['password'];		// password baru
	$old_password  = $_POST['old_password'];    // password lama
	if ($role == 'spv' || $role == 'pp') {
		$id  = executeScalar("SELECT id_admin FROM admin WHERE username = '".$old_username."'");
		// Ambil foto lama
		$oldPhoto = executeScalar("SELECT photo FROM admin WHERE id_admin = '".$id."'");
	} elseif ($role == 'Cashier') {
		$id  = executeScalar("SELECT checker_id FROM checker WHERE checker_code = '".$old_username."'");
		// Ambil foto lama
		$oldPhoto = executeScalar("SELECT photo FROM checker WHERE checker_id = '".$id."'");
	}

	// Foto
	$photoName = $oldPhoto;

	if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
		$targetDir = "../uploads/";

		if (!file_exists($targetDir)) {
			mkdir($targetDir, 0777, true);
		}

		if (!empty($oldPhoto) && file_exists($targetDir . $oldPhoto)) {
			unlink($targetDir . $oldPhoto);
		}

		$photoName = uniqid() . "_" . basename($_FILES['photo']['name']);
		move_uploaded_file($_FILES['photo']['tmp_name'], $targetDir . $photoName);
	}

	$shouldLogout = false;

	if ($username != $old_username) {
		$shouldLogout = true;
	}

	if ($password != $old_password) {
		$shouldLogout = true;
	}

	if ($shouldLogout) {
		// UPDATE
		if ($role == 'spv' || $role == 'pp') {
			$update = mysql_query("UPDATE admin SET
				name = '$name',
				username = '$username',
				password = '$password',
				photo = '$photoName'
			WHERE id_admin = '$id'") or die(mysql_error());
		} elseif ($role == 'Cashier') {
			$update = mysql_query("UPDATE checker SET
				checker_name = '$name',
				checker_code = '$username',
				checker_pass = '$password',
				photo = '$photoName'
			WHERE checker_id = '$id'") or die(mysql_error());
		}

		// LOGOUT
		echo '<script>alert("Login kembali untuk masuk sistem")</script>';
		session_destroy();
		echo '<script>
		localStorage.removeItem("notificationHidden");
		window.location.href = "login.php";
		</script>';
	} else {
		// UPDATE
		if ($role == 'spv' || $role == 'pp') {
			$update = mysql_query("UPDATE admin SET
				name = '$name',
				username = '$username',
				password = '$password',
				photo = '$photoName'
			WHERE id_admin = '$id'") or die(mysql_error());
		} elseif ($role == 'Cashier') {
			$update = mysql_query("UPDATE checker SET
				checker_name = '$name',
				checker_code = '$username',
				checker_pass = '$password',
				photo = '$photoName'
			WHERE checker_id = '$id'") or die(mysql_error());
		}

		// Feedback
		if($update){
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Update Profile";
			echo "<script>window.location=('profile.php')</script>";
		}
	}
?>
