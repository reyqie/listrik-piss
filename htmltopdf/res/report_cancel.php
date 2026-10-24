<?php
	include "../connection.php";
	$date1		= $_POST['date1'];
	$date2		= $_POST['date2'];
	$total		= 0;
?>
<page backtop="10mm" backbottom="10mm" backleft="5mm" backright="5mm">
    <page_header>
        <table style="width:97%; border:0px; margin-top:20px; margin-left:10px; margin-right:10px;">
            <tr>
                <td style="text-align:left; width:33%"></td>
                <td style="text-align:center; width:34%"></td>
                <td style="text-align:right; width:33%">Dicetak : <?php echo date('d M Y'); ?></td>
            </tr>
        </table>
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
		LAPORAN TAGIHAN LISTRIK OFF<br>
		PASAR INDUK SURABAYA SIDOTOPO (PISS)
	</div>
	<br/><br>
	<table style="margin-bottom: 5px;font-size:10pt; width:100%;" >
		<tr>
			<td style="width: 7%;">Tanggal</td>
			<td style="width: 93%;">: <?php echo date("d M Y", strtotime($date1)).' sd '.date("d M Y", strtotime($date2)); ?></td>
		</tr>
	</table>
	<br />
	<table style="border: solid 1px black; font-size:10pt; border-collapse: collapse; margin-bottom: 5px; width:700px; margin-right:0px;" id="tableNonkomoditi">
		<tr>
			<th style="text-align: center;width: 5%; border: solid 1px black;">NO</th>
			<th style="text-align: center;width: 12%; border: solid 1px black;">NO TAGIHAN</th>
			<th style="text-align: center;width: 20%; border: solid 1px black;">PENGGUNA LISTRIK</th>
			<th style="text-align: center;width: 12%; border: solid 1px black;">LAPAK</th>
			<th style="text-align: center;width: 12%; border: solid 1px black;">DAYA</th>
			<th style="text-align: center;width: 12%;border: solid 1px black;">PERIODE</th>
			<th style="text-align: center;width: 12%;border: solid 1px black;">TGL OFF</th>
			<th style="text-align: center;width: 15%; border: solid 1px black;">TARIF (RP)</th>
		</tr>
		 <?php
			$query 	= mysql_query("select p.pay_id, p.merchant_id, p.pay_total, p.cancel_date, p.pay_sts, 
					c.e_cost_ampere, c.e_cost_price, p.periode_id, e.e_cost_id, pr.periode_name
					from e_pay p, e_periode pr, electricity e, e_cost c
					where p.periode_id = pr.periode_id and
					p.merchant_id = e.merchant_id and
					e.e_cost_id = c.e_cost_id and
					p.pay_sts = 'Batal' and
					(p.cancel_date between '".$date1."' and '".$date2."')
					order by p.pay_date, pr.periode_name, p.merchant_id");
			$no		= 1;
			while($r=mysql_fetch_array($query)){
				$tlid 		= sprintf("%07d", $r['pay_id']);
				$lid		= executeScalar("select lapak_id from rent where merchant_id = '".$r['merchant_id']."' and (rent_sts2 != 'Pindah' && rent_sts2 != 'Batal') limit 1");
				$lapak		= executeScalar("select lapak_name from lapak where lapak_id = '".$lid."'");
				$name		= executeScalar("select merchant_name from merchant where merchant_id = '".$r['merchant_id']."'");
		?>
		<tr>
			<td style="text-align: center;font-size:8pt;border: solid 1px black;"><?php echo $no;  ?></td>
			<td style="text-align: center;font-size:8pt;border: solid 1px black;">TL<?php echo $tlid; ?></td>
			<td style="text-align: left;font-size:8pt;border: solid 1px black;"><?php echo $name; ?></td>
			<td style="text-align: center;font-size:8pt;border: solid 1px black;"><?php echo $lapak; ?></td>
			<td style="text-align: center;font-size:8pt;border: solid 1px black;"><?php echo $r['e_cost_ampere']; ?> Ampere</td>
			<td style="text-align: center;font-size:8pt;border: solid 1px black;"><?php echo $r['periode_name']; ?></td>
			<td style="text-align: center;font-size:8pt;border: solid 1px black;"><?php echo date("d M Y", strtotime($r['cancel_date'])); ?></td>
			<td style="text-align: right;font-size:8pt;border: solid 1px black;"><?php echo format_number($r['e_cost_price']);  ?></td>
		</tr>
		<?php
				$no++; 
				$total = $total+$r['pay_total'];
			} 
		?>
		<tr>
			<td style="text-align: center;font-size:8pt;border: solid 1px black;" colspan="7"><b>TOTAL </b></td>
			<td style="text-align: right;font-size:8pt;border: solid 1px black;font-weight:bold;"><?php echo format_number($total); ?></td>
		</tr>
	</table>
</page>