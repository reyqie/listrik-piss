<?php
	session_start();
	session_destroy();
	unset($_SESSION['uid']);
	unset($_SESSION['name']); 
	unset($_SESSION['role']); 
	session_regenerate_id();
	echo '<script>
	localStorage.removeItem("notificationHidden");
	window.location.href = "login.php";
	</script>';
	exit();
?>