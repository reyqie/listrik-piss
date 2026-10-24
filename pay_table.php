<?php
	include "connection.php";
?>
<script src="dataTables/jquery.dataTables.js"></script>
<script src="dataTables/dataTables.tableTools.js"></script>
<script src="dataTables/dataTables.bootstrap.js"></script>
<script>
	$(document).ready(function() {
		$('#merchantView').dataTable({"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]});
	});
</script>
<!-- <h3>Tagihan Listrik PISS</h3> -->
<table id="merchantView" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="width:6%;text-align:center;">NO</th>
			<th style="width:8%;text-align:center;">TAGIHAN</th>
			<th style="width:8%;text-align:center;">KODE</th>
			<th style="width:25%;text-align:center;">NAMA PENGGUNA</th>
			<th style="width:12%;text-align:center;">PERIODE</th>
			<th style="width:10%;text-align:center;">DAYA</th>
			<th style="width:10%;text-align:center;">BIAYA</th>
			<th style="width:12%;text-align:center;">STATUS</th>
			<th style="width:10%;text-align:center;">AKSI</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sql = "SELECT *
				FROM e_pay p
				JOIN electricity e ON p.electricity_id = e.electricity_id
				WHERE p.pay_sts = 'Belum Lunas'
				ORDER BY p.pay_id DESC";
		$query 	= mysql_query($sql);
		$no		= 1;
		$angs	= 0;
		while($r=mysql_fetch_array($query)){
			$name 	= executeScalar("select merchant_name from merchant where merchant_id = '".$r['merchant_id']."'");
			$nick 	= executeScalar("select merchant_nick from merchant where merchant_id = '".$r['merchant_id']."'");
			$tarif 	= executeScalar("select e_cost_id from electricity where merchant_id = '".$r['merchant_id']."'");
			$periode= executeScalar("select periode_name from e_periode where periode_id = '".$r['periode_id']."'");
			$price 	= executeScalar("select e_cost_price from e_cost where e_cost_id = '".$tarif."'");
			$ampere = executeScalar("select e_cost_ampere from e_cost where e_cost_id = '".$tarif."'");
			$jml 	= executeScalar("select pay_total from e_pay where pay_id = '".$r['pay_id']."'");
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
			<td style="vertical-align: middle; text-align:center;"><?php echo "TL".$r['pay_id']; ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo $r['merchant_id']; ?></td>
			<td style="vertical-align: middle; text-align:left;"><?php echo $name.' / '.($nick != NULL ? $nick : '-'); ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo $periode; ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo $ampere; ?> Ampere</td>
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
			<td style="vertical-align: middle; text-align:center;">
				<!-- Button HTML (to Trigger Modal) -->
				<a class="btn btn-xs btn-outline btn-primary btn-block modalPay" data-toggle="modal" data-target="#modalPay" data-id="<?php echo $r['pay_id']; ?>"><i class="fa fa-money"></i>&nbsp;&nbsp;Bayar</a>
			</td>
		</tr>
		<?php $no++;} ?>
	</tbody>
</table>

<script>
	$(document).ready(function() {
		$('body').on('click', '.modalPay', function() {
			var payID = $(this).data('id'); 

			$.ajax({
				url: 'pay_modal.php',
				type: 'GET',
				data: { id: payID }, 
				success: function(response) {
					$('#modalPay .modal-content').html(response);
					$('#modalPay').modal('show');
				}
			});
		});
	});
</script>