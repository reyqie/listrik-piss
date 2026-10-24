<?php
	include "../connection.php";
	$id			= $_GET['id'];
	$total		= 0;
	$pname	 	= executeScalar("select periode_name from e_periode where periode_id = '".$id."'");
?>
<page backtop="10mm" backbottom="10mm" backleft="5mm" backright="5mm">
    <!-- <page_header>
        <table style="width:95%; border:0px; margin-top:20px; margin-left:10px; margin-right:10px;">
            <tr>
                <td style="text-align:left; width:33%"></td>
                <td style="text-align:center; width:34%"></td>
                <td style="text-align:right; width:33%">Dicetak : <?php echo date('d/m/Y'); ?></td>
            </tr>
        </table>
    </page_header> -->
    <page_footer>
        <table style="width: 100%; border: 0px; margin-top:30px; margin-left:10px; margin-right:10px;">
            <tr>
                <td style="text-align:left; width:33%">Dicetak : <?php echo date('d M Y'); ?></td>
				<td style="text-align:left; width:33%"></td>
                <td style="text-align: right;width: 34%">Halaman [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>
    <div style=" font-weight: bold; text-align: center; margin-top:10px;">
		REKAP TAGIHAN LISTRIK BULAN <?php echo strtoupper($pname); ?>
		<br>
		PASAR INDUK SURABAYA SIDOTOPO (PISS)
	</div>
	<br/><br><br>
	<table style="border: solid 1px black; border-collapse: collapse; margin-bottom: 5px; width:680px; margin-right:0px;" id="tableNonkomoditi">
		<tr>
			<th style="text-align: center;font-size:10pt;width: 5%;height: 3%; border: solid 1px black;">NO</th>
			<th style="text-align: center;font-size:10pt;width: 30%; border: solid 1px black;">PENGGUNA LISTRIK</th>
			<th style="text-align: center;font-size:10pt;width: 10%; border: solid 1px black;">LAPAK PASANG</th>
			<th style="text-align: center;font-size:10pt;width: 12%; border: solid 1px black;">DAYA</th>
			<th style="text-align: center;font-size:10pt;width: 15%;border: solid 1px black;">TGL BAYAR</th>
			<th style="text-align: center;font-size:10pt;width: 15%;border: solid 1px black;">STATUS</th>
			<th style="text-align: center;font-size:10pt;width: 15%; border: solid 1px black;">TARIF</th>
		</tr>
		 <?php
			$no		= 1;
			$total	= 0;
			$sql 	= mysql_query("	select 	m.merchant_name, 
											e.pay_id, 
											e.merchant_id, 
											e.pay_sts, 
											e.pay_date,
											e.id_lapak_dipasang,
											e.pay_total 
									from 	e_pay e, 
											merchant m,
											electricity y
									where 	e.merchant_id = m.merchant_id and 
											e.electricity_id = y.electricity_id and
											periode_id = '".$id."' 
									order by m.merchant_name");
			while($r = mysql_fetch_array($sql)){
				//$merchant 	= executeScalar("select merchant_name from merchant where merchant_id = '".$r['merchant_id']."'");
				$tarif		= executeScalar("select e_cost_id from electricity where merchant_id = '".$r['merchant_id']."' and id_lapak_dipasang = '".$r['id_lapak_dipasang']."'");
				$ampere 	= executeScalar("select e_cost_ampere from e_cost where e_cost_id = '".$tarif."'");
				$price 		= executeScalar("select e_cost_price from e_cost where e_cost_id = '".$tarif."'");
				$lapak 		= executeScalar("select lapak_name from lapak where lapak_id = '".$r['id_lapak_dipasang']."'");
		?>
		<tr>
			<td style="text-align: center;font-size:8pt;border: solid 1px black;height: 1%"><?php echo $no; ?></td>
			<td style="text-align: left;font-size:8pt;border: solid 1px black;"><?php echo $r['merchant_name']; ?></td>
			<td style="text-align: center;font-size:8pt;border: solid 1px black;"><?php echo $lapak; ?></td>
			<td style="text-align: center;font-size:8pt;border: solid 1px black;"><?php echo $ampere; ?> Ampere</td>
			<td style="text-align: center;font-size:8pt;border: solid 1px black;">
				<?php 
					if($r['pay_sts']=='Lunas'){
						echo date("d M Y", strtotime($r['pay_date']));
					} else {
						echo "-";
					} ?>
			</td>
			<td style="text-align: center;font-size:8pt;border: solid 1px black;"><?php echo $r['pay_sts']; ?></td>
			<!-- <td style="text-align: right;font-size:8pt;border: solid 1px black;"><?php echo format_rupiah($price);  ?></td> -->
			<td style="text-align: right;font-size:8pt;border: solid 1px black;"><?php echo format_rupiah($r['pay_total']);  ?></td>
		</tr>
		<?php 
				$no++; 
				$total = $total+$r['pay_total'];
			} 
		?>
		<tr>
			<td style="text-align: center;height: 1%;font-size:10pt;border: solid 1px black;" colspan="6"><b>TOTAL </b></td>
			<td style="text-align: right;font-size:8pt;border: solid 1px black;font-weight:bold;"><?php echo format_rupiah($total); ?></td>
		</tr>
	</table>
</page>