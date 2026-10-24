<?php
	include "../connection.php";
	$year 		= date("y");
	$date 		= date("d/m/y");
	$id			= $_GET['id'];
	$periode	= $_POST['periode'];
	$tlid		= 0;
	$name		= executeScalar("select merchant_name from merchant where merchant_id = '".$id."'");
	$tarif 		= executeScalar("select e_cost_id from electricity where merchant_id = '".$id."'");
	$ampere 	= executeScalar("select e_cost_ampere from e_cost where e_cost_id = '".$tarif."'");
	$price 		= executeScalar("select e_cost_price from e_cost where e_cost_id = '".$tarif."'");
	$nick		= executeScalar("select merchant_nick from merchant where merchant_id = '".$id."'");
	$lid		= executeScalar("select lapak_id from rent where merchant_id = '".$id."'");
	$lapak		= executeScalar("select lapak_name from lapak where lapak_id = '".$lid."'");
	$pname	 	= executeScalar("select periode_name from e_periode where periode_id = '".$periode."'");
	$note		= executeScalar("select note_text from note where note_id = '1'");
	
	//jika lebih dr 2 ampere, biaya dibagi 2
	/*if($tarif!=1){
		$price	= $price/2;
	}*/
	//untuk mencegah error periode = 0 || tahun = 0
	// if($periode==0||$pname==0){
	// 	echo "<script>window.history.back()</script>";
	// 	exit();
	// }
	
	//Check jika id sudah ada
	$ada = executeScalar("select count(pay_id) from e_pay where merchant_id = '".$id."' and periode_id = '".$periode."'");
	//Jika Belum Ada
	if($ada==0){
		$insert = mysql_query("insert into pay_e (`pay_id`, `merchant_id`, `periode_id`, `pay_total`, `pay_sts`) 
		VALUES ('', '".$id."', '".$periode."', '".$price."', 'Belum Lunas')");
		$tlid 	= mysql_insert_id();
	}else{//Jika sdh ada 
		$tlid 	= executeScalar("select pay_id from e_pay where merchant_id = '".$id."' and periode_id = '".$periode."'");
		$update = mysql_query("update e_pay set pay_total = '".$price."' where pay_id = '".$tlid."'");
		
	}
	//$tlid 		= sprintf("%07d", $tlid);
?>
<page backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
	<page_header>
    </page_header>
	<table style="width:95%; border:0px; margin-top:0px; margin-left:5px; margin-right:5px; font-size:8pt;">
		<tr>
			<td style="text-align: left; width: 50%"><?php echo 'TL'.$id; ?></td>
			<td style="text-align: center; width: 5%"></td>
			<td style="text-align: right; width: 45%"><?php echo $date_now; ?></td>
			<!-- <td style="text-align: right; width: 45%">2024-06-01</td> -->
		</tr>
	</table>
	<br />
    <div style="font-size: 14px; font-weight: bold; text-align: center; margin-top:5px; margin-bottom:15px;">
		Tagihan Listrik PISS
	</div>
	<table style="margin-bottom: 5px;font-size:11pt;" id="tableCheckout">
		<tr><td>Nama 				</td><td> : <?php echo $name; ?> </td></tr>
		<tr><td>Nama Alias			</td><td> : <?php echo $nick; ?> </td></tr>
		<tr><td>Lapak				</td><td> : <?php echo $lapak; ?> </td></tr>
		<tr><td>Daya Yg Digunakan	</td><td> : <?php echo $ampere; ?> Ampere</td></tr>
		<tr><td>Periode Tagihan		</td><td> : <?php echo date("d-m-Y", strtotime($pname)); ?></td></tr>
		<tr><td>Jumlah Tagihan		</td><td> : <b><?php echo format_rupiah($price); ?></b></td></tr>
	</table>
	<br/><br/>
	<?php 
		if($note!=''){
			echo $note;
		}
	?>
    <br/>
	
    <page_footer>
		<table style="width: 95%; border: 0px black; margin-top:10px; margin-bottom:30px; margin-right:5px; font-size:8pt;">
			<tr>
				<td style="text-align: center;width: 45%">(TTD & Nama Petugas)</td>
				<td style="text-align: center;width: 65%">(TTD Pelanggan)</td>
			</tr>
		</table>
    </page_footer>
</page>