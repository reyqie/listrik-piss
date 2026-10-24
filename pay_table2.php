<?php
	session_start();
	include "connection.php";
?>
<!-- jquery -->
<script src="dataTables/jquery.dataTables.js"></script>
<script src="dataTables/dataTables.tableTools.js"></script>
<script src="dataTables/dataTables.bootstrap.js"></script>
<script>
	$(document).ready(function(){
	$('#payView').dataTable({"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]});
	});
</script>
<table id="payView" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="vertical-align: middle; width:5%;text-align:center;">NO</th>
			<th style="vertical-align: middle; width:5%;text-align:center;">TAGIHAN</th>
			<th style="vertical-align: middle; width:5%;text-align:center;">KODE</th>
			<th style="vertical-align: middle; width:25%;text-align:center;">NAMA PENGGUNA</th>
			<th style="vertical-align: middle; width:15%;text-align:center;">PERIODE TAGIHAN</th>
			<th style="vertical-align: middle; width:10%;text-align:center;">JUMLAH BAYAR</th>
			<th style="vertical-align: middle; width:12%;text-align:center;">STATUS</th>
			<th style="vertical-align: middle; width:12%;text-align:center;">TANGGAL BAYAR</th>
			<?php 
				if($_SESSION['role']=='Cashier'){
				}
				else{
					echo '<th style="vertical-align: middle; width:10%;text-align:center;">AKSI</th>';
				}
			?>
		</tr>
	</thead>
	<tbody>
		<?php
		$sql = mysql_query("
				SELECT * 
				FROM e_pay 
				WHERE pay_sts = 'Lunas'
				AND pay_date >= DATE_SUB(NOW(), INTERVAL 1 YEAR)
				ORDER BY pay_id DESC
			");
		$no		= 1;
		$angs	= 0;
		while($r=mysql_fetch_array($sql)){
			$periode	= executeScalar("select periode_name from e_periode where periode_id = '".$r['periode_id']."'");
			$name		= executeScalar("select merchant_name from merchant where merchant_id = '".$r['merchant_id']."'");
			$nick 	= executeScalar("select merchant_nick from merchant where merchant_id = '".$r['merchant_id']."'");
			$checkMerchant = executeScalar("SELECT COUNT(electricity_id) FROM electricity WHERE merchant_id = '".$r['merchant_id']."'");
			$cekECost = executeScalar("select e_cost_id from electricity where electricity_id = '".$r['electricity_id']."'");
											$cekECostPrice = executeScalar("select e_cost_price from e_cost where e_cost_id = '".$cekECost."'");
											$display = 'none';

											if ($r['pay_total'] === $cekECostPrice) {
												$keterangan = '';
											} else {
												if ($r['merchant_id'] == 'L0039') {
													$keterangan = 'Pedagang bebas tarif (Khusus)';
													$display = 'inline-block';
												} else {
													if ($r['keterangan'] != NULL) {
														$keterangan = $r['keterangan'];
														$display = 'inline-block';
													} else {
														$keterangan = '';
													}
												}
											}
		?>
		<tr>
			<td style="vertical-align: middle; text-align:center;"><?php echo $no; ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo 'TL' . $r['pay_id']; ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo $r['merchant_id']; ?></td>
			<td style="vertical-align: middle; text-align:left;"><?php echo $name.' / '.($nick != NULL ? $nick : '-'); ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo $periode; ?></td>
			<td style="vertical-align: middle; text-align:center;">
				<div style="display: <?php echo $display ?>; 
															vertical-align: middle; 
															background-color: #17a2b8; 
															color: #fff; 
															padding: 2px 7px; 
															border-radius: 50%; 
															font-size: 10px;
															cursor: pointer;"
													data-toggle="tooltip" 
													data-placement="top" 
													title="<?php echo $keterangan; ?>">
													<i class="fa fa-info"></i>
												</div>
												&nbsp;
				<?php echo format_rupiah($r['pay_total']); ?>
			</td>
			<td style="vertical-align: middle; text-align:center;">
				<div style="vertical-align: middle; background-color: <?php echo $r['pay_sts'] == 'Belum Lunas' ? 'red' : 'green'; ?>; color: #fff; padding: 3px; border-radius: 5px; margin: 5px auto 5px auto; width: 110px;">		
					<i class="fa <?php echo $r['pay_sts'] == 'Belum Lunas' ? 'fa-remove' : 'fa-check'; ?>"></i>&nbsp;<?php echo $r['pay_sts']; ?>
				</div>
			</td>
			<td style="vertical-align: middle; text-align:center;"><?php echo date('d M Y', strtotime($r['pay_date'])); ?></td>
				<?php 
					if($_SESSION['role']=='Cashier'){
						
					}
					else{
						if ($checkMerchant == 0) {
							echo '<td style="vertical-align: middle; text-align:center; color:red;">Sudah Tidak Berlangganan</td>';
						} else {
							echo '<td style="vertical-align: middle; text-align:center;">
								<a style="text-decoration: none;" href="pay_action.php?task=batal&id='.$r['pay_id'].'">
									<button class="btn btn-xs btn-outline btn-danger btn-block">
										<i class="fa fa-remove"></i>&nbsp;Batalkan Pembayaran
									</button>
								</a>
							</td>';
						}
					}
				?>
		</tr>
		<?php $no++;} ?>
	</tbody>
</table>