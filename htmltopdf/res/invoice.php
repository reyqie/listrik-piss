<?php
	include "../connection.php";
	//$year 		= date("y");
	$date 		= date("d/m/y");
	$tlid		= 0;
	$id			= 0;
	$sql		= '';
	$note		= executeScalar("select note_text from note where note_id = '1'");
	$sql 		= mysql_query("	select 	e.electricity_id,
										e.merchant_id, 
										e.e_cost_id,
										e.id_lapak_dipasang, 
										l.lapak_name, 
										m.merchant_name, 
										m.merchant_nick 
								from 	electricity e, 
										merchant m, 
										rent r, 
										lapak l 
								where 	e.merchant_id = m.merchant_id and
										m.merchant_id = r.merchant_id and
										r.lapak_id = l.lapak_id and 
										e.electricity_sts = 'Aktif' and
										(r.rent_sts != 'Batal' and r.rent_sts2 not in ('Batal', 'Pindah'))
								group by e.electricity_id 
								order by l.block_id, l.lapak_no");
	while($r=mysql_fetch_array($sql)){
		$ampere 	= executeScalar("select e_cost_ampere from e_cost where e_cost_id = '".$r['e_cost_id']."'");
		$priceByAmpere = executeScalar("SELECT e_cost_price FROM e_cost where e_cost_id = '".$r['e_cost_id']."'");
		$payStatus	= executeScalar("select pay_sts from e_pay where merchant_id = '".$r['merchant_id']."' and periode_id = '".$_POST['periode']."'");
		$payDate	= executeScalar("select pay_date from e_pay where merchant_id = '".$r['merchant_id']."' and periode_id = '".$_POST['periode']."'");
		$periode 	= executeScalar("select periode_name from e_periode where periode_id = '".$_POST['periode']."'");
		$year	 	= executeScalar("select periode_year from e_periode where periode_id = '".$_POST['periode']."'");
		$month	 	= executeScalar("select periode_month from e_periode where periode_id = '".$_POST['periode']."'");
		$lapak 		= executeScalar("select lapak_name from lapak where lapak_id = '".$r['id_lapak_dipasang']."'");
		$year1		= substr($year, -2);
		//check jika tagihan sudah ada / blm
		$ada = executeScalar("	select 	count(pay_id) 
								from 	e_pay 
								where 	merchant_id = '".$r['merchant_id']."' and
										electricity_id = '".$r['electricity_id']."' and
										periode_id = '".$_POST['periode']."'");

		// $totalPrice = ($r['merchant_id'] == "L0039") ? 0 : $price;
		$totalPrice = ($r['merchant_id'] == "L0039") ? 0 : $priceByAmpere;
									
		if($ada==0){ //jika tidak ada / blm dicetak
			$count 	= executeScalar("select count(periode_id) from e_pay where periode_id = '".$_POST['periode']."'");
			//Generate ID
			$count	= $count+1;
			$count 	= sprintf("%03d", $count);
			$id		= $year1.$month.$count;
			$insert = mysql_query("	insert into e_pay (	`pay_id`, 
														`electricity_id`,
														`merchant_id`,
														`id_lapak_dipasang`, 
														`periode_id`, 
														`pay_total`, 
														`pay_sts`) 
									VALUES ('".$id."', 
											'".$r['electricity_id']."',
											'".$r['merchant_id']."',
											'".$r['id_lapak_dipasang']."', 
											'".$_POST['periode']."', 
											'".$totalPrice."', 
											'Belum Lunas')");
			//$tlid = mysql_insert_id();
			$payStatus = "Belum Lunas";
			$payDate = null;
		}else{//jika sdh ada
			$id 	= executeScalar("	select 	pay_id 
										from 	e_pay 
										where 	merchant_id = '".$r['merchant_id']."' and
												electricity_id = '".$r['electricity_id']."' and 
												periode_id = '".$_POST['periode']."'");
		}
		//$tlid 		= sprintf("%07d", $id);

		$price 		= executeScalar("SELECT pay_total FROM e_pay WHERE merchant_id = '".$r['merchant_id']."' AND periode_id = '".$_POST['periode']."' and id_lapak_dipasang = '".$r['id_lapak_dipasang']."'");
?>
<page backtop="5mm" backbottom="15mm" backleft="5mm" backright="5mm">
	<page_header>
    </page_header>
	<table style="width:95%; border:0px; margin-top:0px; margin-left:5px; margin-right:5px; font-size:8pt;">
		<tr>
			<td style="text-align: left; width: 50%"><?php echo 'TL'.$id; ?></td>
			<td style="text-align: center; width: 5%"></td>
			<td style="text-align: right; width: 45%"><?php echo date("d M Y", strtotime($date_now)); ?></td>
			<!-- <td style="text-align: right; width: 45%">01-09-2024</td> -->
		</tr>
	</table>
	<br />
    <div style="font-size: 14px; font-weight: bold; text-align: center; margin-top:0px;">
		TAGIHAN LISTRIK PISS
	</div>
	<p style="font-size: 10px; font-weight: bold; text-align: center; margin-top:0px;">(PASAR INDUK SURABAYA SIDOTOPO)</p>
	<br />
	<table style="margin-bottom: 5px;font-size:11pt; width: 100%;" id="tableCheckout">
		<tr>
			<td style="width: 40%; padding-bottom: 10px;">Nama 				</td>
			<td style="width: 3%; padding-bottom: 10px;"> : </td>
			<td style="width: 57%; padding-bottom: 10px;"><?php echo $r['merchant_name']; ?> </td>
		</tr>
		<tr>
			<td style="padding-bottom: 10px;">Nama Alias			</td>
			<td style="padding-bottom: 10px;"> : </td>
			<td style="padding-bottom: 10px;"><?php echo $r['merchant_nick'] != NULL ? $r['merchant_nick'] : '-'; ?> </td>
		</tr>
		<tr>
			<td style="padding-bottom: 10px;">Lapak				</td>
			<td style="padding-bottom: 10px;"> : </td>
			<td style="padding-bottom: 10px;"><?php echo $lapak; ?> </td>
		</tr>
		<tr>
			<td style="padding-bottom: 10px;">Daya Digunakan	</td>
			<td style="padding-bottom: 10px;"> : </td>
			<td style="padding-bottom: 10px;"><?php echo $ampere; ?> Ampere</td>
		</tr>
		<tr>
			<td style="padding-bottom: 10px;">Periode Tagihan		</td>
			<td style="padding-bottom: 10px;"> : </td>
			<td style="padding-bottom: 10px;"><?php echo $periode; ?></td>
		</tr>
		<tr>
			<td style="padding-bottom: 10px;">Status Tagihan		</td>
			<td style="padding-bottom: 10px;"> : </td>
			<td style="padding-bottom: 10px;"><?php echo $payStatus; ?></td>
		</tr>
		<tr>
			<td style="padding-bottom: 10px;">Tanggal Bayar		</td>
			<td style="padding-bottom: 10px;"> : </td>
			<td style="padding-bottom: 10px;"><?php echo $payDate != NULL ? date('d M Y', strtotime($payDate)) : '-'; ?></td>
		</tr>
		<tr>
			<td style="padding-bottom: 10px;">Jumlah Tagihan		</td>
			<td style="padding-bottom: 10px;"> : </td>
			<td style="padding-bottom: 10px;"><b><?php echo format_rupiah($price); ?></b></td>
		</tr>
	</table>
    <br/><br/>
	<table style="width: 100%">
		<tr>
			<td><b>NB</b></td>
			<td> : </td>
			<td style="font-size: 12px; width: 90%;">
				<?php 
					if($note!=''){
						echo $note;
					}
				?>
			</td>
		</tr>
	</table>
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
<?php } ?>