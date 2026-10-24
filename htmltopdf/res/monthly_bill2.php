<?php
	include "../connection.php";
	
	//$id		= $_GET['id'];
	$periode	= $_POST['periode'];
	$month		= "";
	//ambil tahun
	$pyear		= substr($periode, 0, 4);
	//ambil bulan
	$month		= substr($periode, 4);
	//convert nama bulan ke angka
	$pmonth		= getMonth($month);
	//hitung jml hari dalam bulan yg dipilih
	$total_day	= cal_days_in_month(CAL_GREGORIAN, $pmonth, $pyear);
?>
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <page_header>
        <table style="width:95%; border:0px; margin-top:20px; margin-left:10px; margin-right:10px;">
            <tr>
                <td style="text-align:left; width:33%">PIOS</td>
                <td style="text-align:center; width:34%"></td>
                <td style="text-align:right; width:33%">Dicetak :  <?php echo date('d/m/Y'); ?></td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table style="width: 95%; border: 0px; margin-top:30px; margin-left:10px; margin-right:10px;">
            <tr>
                <td style="text-align: left;width: 50%"></td>
                <td style="text-align: right;width: 50%">Halaman [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>
    <div style="font-size: 22px; font-weight: bold; text-align: center; margin-top:30px;">
		Tagihan Listrik Bulan <?php echo $month.' '.$pyear; ?>
	</div>
	<br/>
	<table style="border: solid 1px black; border-collapse: collapse; margin-bottom: 5px; width:850px; margin-right:0px;" id="tableNonkomoditi">
		<tr>
			<th style="text-align: center;font-size:10pt;width: 5%; border: solid 1px black;">No</th>
			<th style="text-align: center;font-size:10pt;width: 20%; border: solid 1px black;">Pengguna</th>
			<?php
				$tgl = 1;
				while($tgl<=$total_day){
					echo '<th style="text-align: center;width: 3%; border: solid 1px black;">'.$tgl.'</th>';
					$tgl++;
				}
			?>
			
		</tr>
		 <?php
			$no		= 1;
			$total	= 0;
			$sql 	= mysql_query("select distinct(merchant_id) as id from pay_e");
			while($r = mysql_fetch_array($sql)){
				$merchant 	= executeScalar("select merchant_name from merchant_e where merchant_id = '".$r['id']."'");
		?>
		<tr>
			<td style="text-align: center;font-size:8pt;border: solid 1px black;"><?php echo $no;  ?></td>
			<td style="text-align: left;font-size:8pt;border: solid 1px black;"><?php echo $merchant; ?></td>
			<?php
				$x 	= 1;
				$sts='';
				while($x<=$total_day){
					$pid 	= executeScalar("select periode_id from periode_e where year(periode_name) = '".$pyear."' and
					month(periode_name) = '".$pmonth."' and day(periode_name) = '".$x."'");
					$x++;
					if($pid){
						//$sts	= '-';
						//$sts 	= executeScalar("select pay_sts from pay_e where merchant_id = '".$r['id']."' and periode_id = '".$pid."' ");
						$query	= "select pay_sts from pay_e where merchant_id = '".$r['id']."' and periode_id = '".$pid."'"; 
						$result = mysql_query($query) or die ("Error in query: '.$query.' " . mysql_error()); 
						$row 	= mysql_fetch_array($result); 
						//untuk mencari jika hasil query empty / kosong
						$num_results = mysql_num_rows($result);
						if($num_results > 0){
							if($row['pay_sts']=='Lunas'){
								echo '<td style="text-align: center;font-size:8pt;border: solid 1px black;">V</td>';
							}elseif($row['pay_sts']=='Belum Lunas'){
								echo '<td style="text-align: center;font-size:8pt;border: solid 1px black;">?</td>';
							}elseif($row['pay_sts']=='Batal'){
								echo '<td style="text-align: center;font-size:8pt;border: solid 1px black;">X</td>';
							}
						}
						else{
							echo '<td style="text-align: center;font-size:8pt;border: solid 1px black;">-</td>';
						}
					}else{
						echo '<td style="text-align: center;font-size:8pt;border: solid 1px black;">-</td>';
					}
				}
			?>
		</tr>
		<?php $no++; } ?>
	</table>
	<p style="font-weight: bold;">Keterangan:</p>
	V &nbsp; = Lunas<br />
	X &nbsp; = Tidak Masuk<br />
	? &nbsp; = Belum Bayar<br />
	- &nbsp; = Tidak Ada Tagihan / Tagihan Belum Dicetak
</page>