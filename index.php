<?php

    session_start();

    if (
        !isset($_SESSION['username']) ||
        !isset($_SESSION['role']) ||
        empty($_SESSION['username']) ||
        empty($_SESSION['role'])
    ) {
        header("Location: login.php");
        exit;
    }

    // Kalau sudah login, lanjut ke dashboard
    header("Location: dashboard.php");
    exit;

?>