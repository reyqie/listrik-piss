<?php
    session_start();
    include "connection.php";

    $semantic = $_POST['semantic'];
    $version  = $_POST['version'];
    $title    = $_POST['title'];
    $date     = $_POST['date'];
    $lots     = $_POST['lots']; // jumlah deskripsi

    // 1. Insert ke tabel update_listrik
    $query1 = mysql_query("
        INSERT INTO update_listrik (semantic, version, title, date)
        VALUES ('$semantic', '$version', '$title', '$date')
    ");

    if (!$query1) {
        die("Gagal insert update_listrik: " . mysql_error());
    }

    // 2. Ambil ID terakhir
    $update_id = mysql_insert_id();

    // 3. Loop semua deskripsi
    for ($i = 1; $i <= $lots; $i++) {
        $field = "descriptions_" . $i;

        if (!isset($_POST[$field])) continue;

        $desc = trim($_POST[$field]);
        if ($desc == "") continue;

        // Escape petik & karakter berbahaya
        $desc = mysql_real_escape_string($desc);

        $query2 = mysql_query("
            INSERT INTO update_desc_listrik (update_listrik_id, description)
            VALUES ('$update_id', '$desc')
        ");

        if (!$query2) {
            die("Gagal insert deskripsi $i: " . mysql_error());
        }
    }

    if($query1 && $query2){
		// Alert Information
		$_SESSION['success'] = true;
		$_SESSION['title'] = 'Berhasil';
		$_SESSION['message'] = "Menambahkan Update Log";
		echo "<script>window.location=('changelog.php')</script>";
	}
	else{
		// Alert Information
		$_SESSION['success'] = false;
		$_SESSION['title'] = 'Gagal';
		$_SESSION['message'] = "Menambahkan Update Log";
		echo "<script>window.location=('changelog.php')</script>";
	}
?>
