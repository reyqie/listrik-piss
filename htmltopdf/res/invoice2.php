<?php
	include "../damel/connection.php";
?>
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <page_header>
        <table style="width:95%; border:0px; margin-top:30px; margin-left:10px; margin-right:10px;">
            <tr>
                <td style="text-align: left;    width: 33%">Invoice</td>
                <td style="text-align: center;    width: 34%"></td>
                <td style="text-align: right;    width: 33%"><?php echo date('d/m/Y'); ?></td>
            </tr>
        </table>
    </page_header>
    <page_footer>
        <table style="width: 95%; border: solid 1px black; margin-top:30px; margin-left:10px; margin-right:10px;">
            <tr>
                <td style="text-align: left;width: 50%">www.houseofticket.com</td>
                <td style="text-align: right;width: 50%">Halaman [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>
    <div style="font-size: 20px; font-weight: bold; text-align: center;margin-top:30px;">
		<img src="./res/hot.png" alt="" style="height: 10mm"> Invoice Pemesanan Kamar Hotel (House of TIcket)
	</div>
    <br/>
	<h4>Data pemesan beserta ordernya adalah sebagai berikut:</h4>
	<?php
		$date_now 	= date("dmY");
		$id			= $_GET['id'];
		$sql 		= mysql_query("select * from hotrans where hotrans_id = '".$id."'");
		while($r= mysql_fetch_array($sql)){
	?>
	<table style="margin-bottom: 5px;font-size:12pt;" id="tableCheckout">
		<tr><td>Nama        </td><td> : <b><?php echo $r['hotrans_customer']; ?></b> </td></tr>
		<tr><td>No. KTP     </td><td> : <?php echo $r['hotrans_ktp']; ?></td></tr>
		<tr><td>E-mail      </td><td> : <?php echo $r['hotrans_email']; ?></td></tr>
		<tr><td>Telpon      </td><td> : <?php echo $r['hotrans_phone']; ?></td></tr>
		<tr><td>Alamat 	 	</td><td> : <?php echo $r['hotrans_address']; ?></td></tr>
		<tr><td>Kota 		</td><td> : <?php echo $r['hotrans_city']; ?></td></tr>
		<tr><td>Kode Pos 	</td><td> : <?php echo $r['hotrans_post_code']; ?></td></tr>
		<tr><td>Nomor Order </td><td> : <?php echo $date_now.'0'.$id; ?></td></tr>
	</table>
	<?php 
		// Mengambil data transaksi
		$sql2 				= mysql_query("select * from hotrans_detail hd, room r, hotel h
		where hd.room_id 	= r.room_id and 
		hd.hotel_id			= h.hotel_id and
		hd.hotrans_id 		= '".$id."'");
		$total				= 0;
		$subtotal_rp		= 0;
		while ($d = mysql_fetch_array($sql2)){
			$check_in	 	= $d['check_in'];
			$checkin 		= date("d-m-Y", strtotime($check_in));
			$check_out	 	= $d['check_out'];
			$checkout 		= date("d-m-Y", strtotime($check_out));
	?>
	<br />
	<table style="border:1px;""margin-bottom:5px; font-size:12pt; width:850px; margin-right:0px;" id="tableDetail">
		<tr bgcolor="#D3DCE3">
			<th>Hotel</th>
			<th>Ruangan</th>
			<th style="text-align:right;">Harga</th>
			<th style="text-align:right;">Jumlah</th>
			<th style="text-align:right;">Durasi</th>
			<th style="text-align:right;">Check In</th>
			<th style="text-align:right;">Check Out</th>
			<th style="text-align:right;">Total</th>
		</tr>
		<tr>
			<td><?php echo $d['hotel_name'];?></td>
			<td><?php echo $d['room_name'];?></td>
			<td style="text-align:right;">Rp. <?php echo number_format($d['room_price'], 0 , '' , '.' ) . ',-';?></td>
			<td style="text-align:right;"><?php echo $d['room_qty'];?> Kamar</td>
			<td style="text-align:right;"><?php echo $d['night_qty'];?> Malam</td>
			<td style="text-align:right;"><?php echo $checkin;?></td>
			<td style="text-align:right;"><?php echo $checkout;?></td>
			<td style="text-align:right;"><b>Rp. <?php echo number_format($d['grand_total'], 0 , '' , '.' ) . ',-';?></b></td>
		</tr>
	</table>
	<br />
	Silahkan lakukan pembayaran sesuai dengan <b>Total Biaya</b> di atas pada rekening:<br />
	Rekening : <b>BCA</b><br />
	No. Rek : <b>2582065196</b><br />
	Atas Nama : <b>Allan P.</b>
	<?php }} ?>
</page>