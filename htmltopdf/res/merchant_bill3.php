<?php
	include "../connection.php";
	$year 		= date("y");
	$date 		= date("d/m/y");
	$id			= $_GET['id'];
	$tlid		= 0;
	$mid		= executeScalar("select merchant_id from e_pay where pay_id = '".$id."'");
	$name		= executeScalar("select merchant_name from merchant where merchant_id = '".$mid."'");
	$nick		= executeScalar("select merchant_nick from merchant where merchant_id = '".$mid."'");
	$periodeid	= executeScalar("select periode_id from e_pay where pay_id = '".$id."'");
	$periode 	= executeScalar("select periode_name from e_periode where periode_id = '".$periodeid."'");
	$tarif		= executeScalar("select e_cost_id from electricity where merchant_id = '".$mid."'");
	$payStatus  = executeScalar("select pay_sts from e_pay where pay_id = '".$id."'");
	$payDate  	= executeScalar("select pay_date from e_pay where pay_id = '".$id."'");
	$price 		= executeScalar("select pay_total from e_pay where pay_id = '".$id."'");
	$ampere 	= executeScalar("select e_cost_ampere from e_cost where e_cost_id = '".$tarif."'");
	$lid		= executeScalar("select lapak_id from rent where merchant_id = '".$mid."'");
	// $lapak		= executeScalar("select lapak_name from lapak where lapak_id = '".$lid."'");
	$lapak		= executeScalar("	select lapak_name 
									from lapak l
									JOIN e_pay e ON e.id_lapak_dipasang = l.lapak_id 
									where pay_id = '".$id."'");
	$note		= executeScalar("select note_text from note where note_id = '1'");
	
	//jika lebih dr 2 ampere, biaya dibagi 2
	/*if($tarif!=1){
		$price	= $price/2;
	}*/
	//untuk mencegah error periode = 0 || tahun = 0
	/*if($periode==0||$pname==0){
		echo "<script>window.history.back()</script>";
		exit();
	}
	
	//Check jika id sudah ada
	
	$ada = executeScalar("select count(pay_id) from e_pay where merchant_id = '".$id."' and periode_id = '".$periode."'");
	//Jika Belum Ada
	if($ada==0){
		$insert = mysql_query("insert into e_pay (`pay_id`, `merchant_id`, `periode_id`, `pay_total`, `pay_sts`) 
		VALUES ('', '".$id."', '".$periode."', '".$price."', 'Belum Lunas')");
		$tlid 	= mysql_insert_id();
	}else{
		$tlid 	= executeScalar("select pay_id from e_pay where merchant_id = '".$id."' and periode_id = '".$periode."'");
		$update = mysql_query("update e_pay set pay_total = '".$price."' where pay_id = '".$tlid."'");
		
	}
	$tlid 		= sprintf("%07d", $tlid);*/
?>
<page backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
	<page_header>
    </page_header>
	<table style="width:95%; border:0px; margin-top:0px; margin-left:5px; margin-right:5px; font-size:8pt;">
		<tr>
			<td style="text-align: left; width: 50%"><?php echo 'TL'.$id; ?></td>
			<td style="text-align: center; width: 5%"></td>
			<td style="text-align: right; width: 45%"><?php echo date('d M Y', strtotime($date_now)); ?></td>
			<!-- <td style="text-align: right; width: 45%">2024-06-01</td> -->
		</tr>
	</table>
	<br />
    <div style="font-size: 14px; font-weight: bold; text-align: center; margin-top:0px;">
		BUKTI PEMBAYARAN LISTRIK
	</div>
		<p style="font-size: 10px; font-weight: bold; text-align: center; margin-top:0px;">(PASAR INDUK SURABAYA SIDOTOPO)</p>
	<br />
	<table style="margin-bottom: 5px;font-size:11pt;" id="tableCheckout">
		<tr><td style="padding-bottom: 10px;">Nama 				</td><td style="padding-bottom: 10px;"> : <?php echo $name; ?> </td></tr>
		<tr><td style="padding-bottom: 10px;">Nama Alias			</td><td style="padding-bottom: 10px;"> : <?php echo $nick != NULL ? $nick : '-'; ?> </td></tr>
		<tr><td style="padding-bottom: 10px;">Lapak				</td><td style="padding-bottom: 10px;"> : <?php echo $lapak; ?> </td></tr>
		<tr><td style="padding-bottom: 10px;">Daya Yg Digunakan	</td><td style="padding-bottom: 10px;"> : <?php echo $ampere; ?> Ampere</td></tr>
		<tr><td style="padding-bottom: 10px;">Periode Tagihan		</td><td style="padding-bottom: 10px;"> : <?php echo $periode; ?></td></tr>
		<tr><td style="padding-bottom: 10px;">Status Tagihan		</td><td style="padding-bottom: 10px;"> : <?php echo $payStatus; ?></td></tr>
		<tr><td style="padding-bottom: 10px;">Tanggal Bayar		</td><td style="padding-bottom: 10px;"> : <?php echo date('d M Y', strtotime($payDate)); ?></td></tr>
		<tr><td>Jumlah Tagihan		</td><td> : <b><?php echo format_rupiah($price); ?></b></td></tr>
	</table>
    <br/><br/>
    <br/>
	
    <page_footer>
		<table style="width: 100%; border: 0px black; margin-top:10px; margin-bottom:30px; margin-right:5px; font-size:8pt;">
			<tr>
				<td style="text-align: center;width: 50%">( Petugas )</td>
				<td style="text-align: center;width: 50%">( Pelanggan )</td>
			</tr>
		</table>
    </page_footer>
</page>