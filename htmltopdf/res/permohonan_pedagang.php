<?php
	include "../connection.php";
	$date_now 	= date("d-m-Y");
	$id			= $_GET['id'];
	$sql 		= mysql_query("select * from request where req_id = '".$id."'");
	while($r = mysql_fetch_array($sql)){
	$idq 	= sprintf("%04d", $id);
	$lapak	= executeScalar("select lapak_name from lapak where lapak_id = '".$r['lapak_id']."'");
?>
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <page_header>
        <table style="width:95%; border:0px; margin-top:30px; margin-left:10px; margin-right:10px;">
            <tr>
                <td style="text-align: left;    width: 33%">www.paskomnas.com</td>
                <td style="text-align: center;    width: 34%"></td>
                <td style="text-align: right;    width: 33%">No: <?php echo 'PL'.$idq; ?></td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table style="width: 95%; border: 0px black; margin-bottom:50px; margin-left:10px; margin-right:30px;">
            <tr>
                <td style="text-align: left;width: 65%"></td>
                <td style="text-align: right;width: 35%"></td>
            </tr>
        </table>
    </page_footer>
    <div style="font-size: 18px; font-weight: bold; text-align: center; margin-top:30px;">
		Permohonan Untuk Menempati Lapak PIOS
	</div>
	<br/><br/>
	Saya yang bertanda tangan dibawah ini:
	<table style="margin-bottom: 5px;font-size:10pt;" id="tableCheckout">
		<tr><td>Nama        </td><td> </td></tr>
		<tr><td>-KTP        </td><td> : <?php echo $r['req_name']; ?> </td></tr>
		<tr><td>-Alias      </td><td> : <?php echo $r['req_nick']; ?> </td></tr>
		<tr><td>Alamat      </td><td></td></tr>
		<tr><td>-KTP		</td><td> : <?php echo $r['address1']; ?></td></tr>
		<tr><td>-Surat 	 	</td><td> : <?php echo $r['address2']; ?></td></tr>
		<tr><td>No. Telp	</td><td> : <?php echo $r['phone1'];
		if ($r['phone1']!=$r['phone2']){echo ' / '.$r['phone2'];}?></td></tr>
		<tr><td>No. Identitas</td><td> </td></tr>
		<tr><td>-KTP		</td><td> : <?php echo $r['nid_ktp']; ?></td></tr>
		<tr><td>-SIM		</td><td> : <?php echo $r['nid_sim']; ?></td></tr>
		<tr><td>-Lainnya	</td><td> : <?php echo $r['nid_lain']; ?></td></tr>
		<tr><td>-Jenis Jualan</td><td> : <?php echo $r['merchant_type']; ?></td></tr>
		<tr><td>-Lapak		</td><td> : <?php echo $lapak; ?></td></tr>
	</table>
    <br /><br />
	Dengan ini memohon untuk menempati lapak di PIOS dan menyetujui melaksanakan ketentuan yang berlaku sebagai berikut:<br />
	1. Patuh pada aturan yang berlaku saat ini maupun yang akan ditetapkan dikemudian hari.<br />
	2. Membayar semua kewajiban keuangan sesuai ketentuan manajemen.<br />
	3. Segera melakukan aktivitas berjualan maksimun 7 (tujuh) hari kalender sejak disetujui surat permohonan ini.
	<br /><br /><br /><br /><br /><br />
	<table style="width: 95%; border: 0px black; margin-bottom:50px; margin-left:10px; margin-right:30px;">
		<tr>
			<td style="text-align: left;width: 65%"></td>
			<td style="text-align: right;width: 35%">Surabaya, <?php echo $date_now; ?><br /></td>
		</tr>
		<tr>
			<td style="text-align: left;width: 65%"></td>
			<td style="text-align: center;width: 35%">Pemohon.<br /><br /><br /></td>
		</tr>
		<tr>
			<td style="text-align: left;width: 65%"></td>
			<td style="text-align: center;width: 35%"><?php echo $r['req_name']; ?></td>
		</tr>
	</table>
</page>
<?php } ?>