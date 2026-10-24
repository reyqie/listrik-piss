<?php
	include "../connection.php";
	$total = 0;
?>
<page backtop="10mm" backbottom="10mm" backleft="2mm" backright="2mm">
    <page_header>
        <table style="width:97%; border:0px; margin-top:20px; margin-bottom:30px; margin-left:10px; margin-right:10px;">
            <tr>
                <td style="text-align:left; width:33%"></td>
                <td style="text-align:center; width:34%"></td>
                <td style="text-align:right; width:33%">Dicetak : <?php echo date('d M Y'); ?></td>
            </tr>
        </table>
		<br />
    </page_header>
    <page_footer>
        <table style="width: 97%; border: 0px; margin-top:30px; margin-left:10px; margin-right:10px;">
            <tr>
                <td style="text-align: left;width: 50%"></td>
                <td style="text-align: right;width: 50%">Halaman [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>
    <div style="font-size: 18px; font-weight: bold; text-align: center; margin-top:15px;">
		LAPORAN OUTSTANDING LISTRIK <br>
		PASAR INDUK SURABAYA SIDOTOPO (PISS)
	</div>
	<br/><br>
	<table style="border: solid 1px black; font-size:8pt; border-collapse: collapse; margin-bottom: 5px; width:680px; margin-right:0px;" id="tableNonkomoditi">
		<tr>
			<th style="text-align: center;width: 3%;height: 3%; border: solid 1px black;">NO</th>
			<th style="text-align: center;width: 8%; border: solid 1px black;">KODE TAGIHAN</th>
			<th style="text-align: center;width: 23%; border: solid 1px black;">PENGGUNA LISTRIK</th>
			<th style="text-align: center;width: 10%; border: solid 1px black;">STATUS PEDAGANG</th>
			<th style="text-align: center;width: 10%; border: solid 1px black;">STATUS LISTRIK</th>
			<th style="text-align: center;width: 8%; border: solid 1px black;">LAPAK PASANG</th>
			<th style="text-align: center;width: 8%; border: solid 1px black;">DAYA</th>
			<th style="text-align: center;width: 12%;border: solid 1px black;">PERIODE</th>
			<th style="text-align: center;width: 10%; border: solid 1px black;">TARIF</th>
			<th style="text-align: center;width: 13%;border: solid 1px black;">TAGIHAN</th>
		</tr>
		 <?php
			$query = mysql_query("
				SELECT DISTINCT 
					p.pay_id, 
					p.merchant_id, 
					p.pay_total, 
					p.pay_sts,
					p.id_lapak_dipasang, 
					p.periode_id,
					e.electricity_sts
				FROM e_pay p
				JOIN electricity e ON p.merchant_id = e.merchant_id
				WHERE p.pay_sts = 'Belum Lunas'
				AND e.electricity_sts = 'Aktif'
				ORDER BY p.periode_id, p.merchant_id
			");

			$no		= 1;
			$total	= 0;
			while($r = mysql_fetch_array($query)){
				$tlid 		= sprintf("%07d", $r['pay_id']);
				$lid		= executeScalar("select lapak_id from rent where merchant_id = '".$r['merchant_id']."' and (rent_sts2 != 'Pindah' && rent_sts2 != 'Batal') limit 1");
				$lapak		= executeScalar("select lapak_name from lapak where lapak_id = '".$r['id_lapak_dipasang']."'");
				$name		= executeScalar("select merchant_name from merchant where merchant_id = '".$r['merchant_id']."'");
				$tarif		= executeScalar("select e_cost_id from electricity where merchant_id = '".$r['merchant_id']."' and id_lapak_dipasang = '".$r['id_lapak_dipasang']."'");
				$price		= executeScalar("select e_cost_price from e_cost where e_cost_id = '".$tarif."'");
				$ampere		= executeScalar("select e_cost_ampere from e_cost where e_cost_id = '".$tarif."'");
				$periode	= executeScalar("select periode_name from e_periode where periode_id = '".$r['periode_id']."'");
				$merchantSts= executeScalar("select merchant_status from merchant where merchant_id = '".$r['merchant_id']."'");
		?>
		<tr>
			<td style="text-align: center;font-size: 8pt;height: 1%;border: solid 1px black;"><?php echo $no;  ?></td>
			<td style="text-align: center;font-size:8pt;border: solid 1px black;">TL<?php echo $tlid; ?></td>
			<td style="text-align: left;font-size:8pt;border: solid 1px black;"><?php echo $name; ?></td>
			<td style="text-align: center;font-size:8pt;border: solid 1px black;"><?php echo $merchantSts; ?></td>
			<td style="text-align: center;font-size:8pt;border: solid 1px black;"><?php echo $r['electricity_sts']; ?></td>
			<td style="text-align: center;font-size:8pt;border: solid 1px black;"><?php echo $lapak; ?></td>
			<td style="text-align: center;font-size:8pt;border: solid 1px black;"><?php echo $ampere; ?> Ampere</td>
			<td style="text-align: center;font-size:8pt;border: solid 1px black;"><?php echo $periode; ?></td>
			<td style="text-align: right;font-size:8pt;border: solid 1px black;"><?php echo format_rupiah($price);  ?></td>
			<td style="text-align: right;font-size:8pt;border: solid 1px black;"><?php echo format_number($r['pay_total']);  ?></td>
		</tr>
		<?php 
				$no++; 
				$total = $total+$r['pay_total'];
			} 
		?>
		<tr>
			<td style="text-align: center;font-size:8pt;border: solid 1px black;" colspan="9"><b>TOTAL </b></td>
			<td style="text-align: right;font-size:8pt;border: solid 1px black;font-weight:bold;"><?php echo format_number($total); ?></td>
		</tr>
	</table>
</page>