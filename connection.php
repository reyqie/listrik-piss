<?php
	$server = "localhost";
	$username = "root";
	$password = "";
	$database = "db_piss";

	// Koneksi dan memilih database di server
	mysql_connect($server,$username,$password) or die("Koneksi gagal");
	mysql_select_db($database) or die("Database tidak bisa dibuka");

	function format_rupiah($angka){
		$rupiah = 'Rp '.number_format($angka,0,',','.');
		return $rupiah;
	}

	function format_number($angka){
		$rupiah = number_format($angka,0,',',',');
		return $rupiah;
	}
	
	function executeScalar($sql,$def=0){
		$rs = mysql_query($sql) or die(mysql_error().$sql);
		if (mysql_num_rows($rs)) {
			$r = mysql_fetch_row($rs);
			mysql_free_result($rs);
			return $r[0];
		}
		return $def;
	}
	date_default_timezone_set('Asia/Jakarta');
	$date_now = date("Y-m-d");
	
	if (!function_exists('cal_days_in_month')) { 
		function cal_days_in_month($calendar, $month, $year) { 
			return date('t', mktime(0, 0, 0, $month, 1, $year)); 
		} 
	} 
	if (!defined('CAL_GREGORIAN')) define('CAL_GREGORIAN', 1); 
	function getMonth($bln){
		switch ($bln){
			case "January": 
				return 1;
				break;
			case "February":
				return 2;
				break;
			case 'March':
				return 3;
				break;
			case "April":
				return 4;
				break;
			case 'May':
				return 5;
				break;
			case "June":
				return 6;
				break;
			case "July":
				return 7;
				break;
			case "Agust":
				return 8;
				break;
			case "September":
				return 9;
				break;
			case "October":
				return 10;
				break;
			case "November":
				return 11;
				break;
			case "Desember":
				return 12;
				break;
		}
	}
	function getBulan($bln){
		switch ($bln){
			case 01: 
				return "Januari";
				break;
			case 02:
				return "Februari";
				break;
			case 03:
				return "Maret";
				break;
			case 04:
				return "April";
				break;
			case 05:
				return "Mei";
				break;
			case 06:
				return "Juni";
				break;
			case 07:
				return "Juli";
				break;
			case 08:
				return "Agustus";
				break;
			case 09:
				return "September";
				break;
			case 10:
				return "Oktober";
				break;
			case 11:
				return "November";
				break;
			case 12:
				return "Desember";
				break;
		}
	}
?>
