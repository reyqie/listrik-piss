<?php
    session_start();
    include "connection.php";

    $task   = $_GET['task'];
    $id     = $_GET['id'];
    $merchant_id = $_GET['merchant'];
    $electricity_id = $_GET['eid'];
    $date_now = date("Y-m-d");

    // Update 1 pada menu merchant edit
    if($task=='update'){
        $keterangan = trim($_POST['keterangan']);

        if($keterangan === '') {
            $update = mysql_query("
                UPDATE e_pay 
                SET pay_total = '".$_POST['price']."', 
                    keterangan = NULL 
                WHERE pay_id = '".$id."'
            ");
        } else {
            $update = mysql_query("
                UPDATE e_pay 
                SET pay_total = '".$_POST['price']."', 
                    keterangan = '".$keterangan."' 
                WHERE pay_id = '".$id."'
            ");
        }

        if($update){
            // Alert Information
            $_SESSION['success'] = true;
            $_SESSION['title'] = 'Berhasil';
            $_SESSION['message'] = "Update Biaya Tagihan";
            echo "<script>window.location=('merchant_edit.php?id=".$electricity_id."&kode=".$merchant_id."')</script>";
            exit();
        }
        else{
            // Alert Information
            $_SESSION['success'] = false;
            $_SESSION['title'] = 'Gagal';
            $_SESSION['message'] = "Update biaya tagihan";
            echo "<script>window.history.back()</script>";
            exit();
        }
    }

    // Update 2 pada menu invoice
    if($task=='update2'){
        $keterangan = trim($_POST['keterangan']);

        if($keterangan === '') {
            $update = mysql_query("
                UPDATE e_pay 
                SET pay_total = '".$_POST['price']."', 
                    keterangan = NULL 
                WHERE pay_id = '".$id."'
            ");
        } else {
            $update = mysql_query("
                UPDATE e_pay 
                SET pay_total = '".$_POST['price']."', 
                    keterangan = '".$keterangan."' 
                WHERE pay_id = '".$id."'
            ");
        }
        if($update){
            // Alert Information
            $_SESSION['success'] = true;
            $_SESSION['title'] = 'Berhasil';
            $_SESSION['message'] = "Update Biaya Tagihan";
            echo "<script>window.location=('invoice.php')</script>";
            exit();
        }
        else{
            // Alert Information
            $_SESSION['success'] = false;
            $_SESSION['title'] = 'Gagal';
            $_SESSION['message'] = "Update biaya tagihan";
            echo "<script>window.history.back()</script>";
            exit();
        }
    }

    //Pembatalan Tagihan
	if ($task=='cancelBill'){
		$insert = mysql_query("update e_pay set `pay_date` 	= null, 
											`cancel_date` 	= '".$date_now."',
												`pay_sts` 	= 'Batal' 
											where pay_id 	= '".$id."'");
		if($insert){
			// Alert Information
			$_SESSION['success'] = true;
			$_SESSION['title'] = 'Berhasil';
			$_SESSION['message'] = "Membatalkan tagihan";
            echo "<script>window.location=('merchant_edit.php?id=".$electricity_id."&kode=".$merchant_id."')</script>";
			exit();
		}
		else{
			// Alert Information
			$_SESSION['success'] = false;
			$_SESSION['title'] = 'Gagal';
			$_SESSION['message'] = "Membatalkan tagihan";
            echo "<script>window.location=('merchant_edit.php?id=".$electricity_id."&kode=".$merchant_id."')</script>";
			exit();
		}
	}

?>