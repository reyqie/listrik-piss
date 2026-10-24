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
	$('#historyoutstanding').dataTable({"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]});
	});
</script>
<!-- <h3>Daftar Tagihan Listrik</h3> -->
	<table id="historyoutstanding" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th style="vertical-align: middle; width:8%;text-align:center;">NO</th>
				<th style="vertical-align: middle; width:8%;text-align:center;">TAGIHAN</th>
				<th style="vertical-align: middle; width:8%;text-align:center;">KODE</th>
				<th style="vertical-align: middle; width:25;text-align:center;">PENGGUNA LISTRIK</th>
				<th style="vertical-align: middle; width:15%;text-align:center;">LAPAK PASANG</th>
				<th style="vertical-align: middle; width:15%;text-align:center;">PERIODE</th>
				<th style="vertical-align: middle; width:15%;text-align:center;">BIAYA</th>
				<th style="vertical-align: middle; width:15%;text-align:center;">STATUS</th>
				<th style="vertical-align: middle; width:10%;text-align:center;">AKSI</th>
			</tr>
		</thead>
		<tbody>
			<?php
			// $sql 	= "select * from e_pay where pay_sts != 'Lunas' order by pay_id desc";
			$sql 	= "select * from e_pay p join electricity e on p.electricity_id = e.electricity_id where pay_sts = 'Belum Lunas' order by pay_id desc";
			$query 	= mysql_query($sql);
			$no		= 1;
			$angs	= 0;
			while($r=mysql_fetch_array($query)){
				$periode = executeScalar("select periode_name from e_periode where periode_id = '".$r['periode_id']."'");
				$name	 = executeScalar("select merchant_name from merchant where merchant_id = '".$r['merchant_id']."'");
				$lapakpasang	= executeScalar("select lapak_name from lapak where lapak_id = '".$r['id_lapak_dipasang']."'");
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
				<td style="vertical-align: middle; text-align:left;"><?php echo $name; ?></td>
				<td style="vertical-align: middle; text-align:center;"><?php echo $lapakpasang; ?></td>
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
				<td style="vertical-align: middle; text-align:center;"><?php echo $r['pay_sts']; ?></td>
				<td style="vertical-align: middle;">
					<?php if($_SESSION['role'] == 'Cashier') {

					} else { ?>
					<a href="#" style="text-decoration: none; margin-bottom:5px;" class="btn btn-outline btn-warning btn-block btn-xs modalEditPrice" data-id="<?php echo $r['pay_id']; ?>">
						<i class="fa fa-edit"></i>&nbsp;Edit
					</a>
					<?php } ?>
					<a style="text-decoration: none;" href="htmltopdf/merchant_bill2.php?id=<?php echo $r[0]; ?>" target="_blank">
						<button class="btn btn-primary btn-outline btn-block btn-xs"><i class="fa fa-print"></i>&nbsp;&nbsp;Cetak</button>
					</a>
					<?php 
						if($_SESSION['role']=='Cashier'){
							
						}
						else{
							if ($r['pay_sts'] == 'Belum Lunas') {
								echo '<button class="btn btn-danger btn-outline btn-block btn-xs open-confirm" 
										style="margin-top: 5px;" 
										data-url="pay_action.php?task=absen&id='.$r['pay_id'].'"
										data-toggle="modal" 
										data-target="#confirmationModal">
										<i class="fa fa-remove"></i>&nbsp;&nbsp;Tagihan Off 
									</button>';
							}
						}
					?>
				</td>
			</tr>
			<?php $no++;} ?>
		</tbody>
	</table>