<?php
	session_start();
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
<!-- <h3>Tagihan Listrik PIOS</h3> -->
<table id="merchantView" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="vertical-align: middle; width:5%;text-align:center;">NO</th>
			<th style="vertical-align: middle; width:5%;text-align:center;">TAGIHAN</th>
			<th style="vertical-align: middle; width:5%;text-align:center;">KODE</th>
			<th style="vertical-align: middle; width:25%;">NAMA PENGGUNA</th>
			<th style="vertical-align: middle; width:12%;text-align:center;">PERIODE</th>
			<th style="vertical-align: middle; width:10%;text-align:center;">DAYA</th>
			<th style="vertical-align: middle; width:10%;text-align:center;">BIAYA</th>
			<th style="vertical-align: middle; width:12%;text-align:center;">STATUS</th>
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
			$sql 	= "select * from e_pay p join electricity e on p.electricity_id = e.electricity_id where pay_sts = 'Belum Lunas' order by pay_id desc";
			$query 	= mysql_query($sql);
			$no		= 1;
			$angs	= 0;
			while($r=mysql_fetch_array($query)){
				$name 	= executeScalar("select merchant_name from merchant where merchant_id = '".$r['merchant_id']."'");
				$periode= executeScalar("select periode_name from e_periode where periode_id = '".$r['periode_id']."'");
				$cost_id = executeScalar("select e_cost_id from electricity where merchant_id = '".$r['merchant_id']."'");
				$ampere = executeScalar("select e_cost_ampere from e_cost where e_cost_id = '".$cost_id."'");
		?>
		<tr>
			<td style="vertical-align: middle; text-align:center;"><?php echo $no; ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo 'TL' . $r['pay_id']; ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo $r['merchant_id']; ?></td>
			<td style="vertical-align: middle; text-align:left;"><?php echo $name; ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo $periode; ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo $ampere; ?> Ampere</td>
			<td style="vertical-align: middle; text-align:right;"><?php echo format_rupiah($r['pay_total']); ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo $r['pay_sts']; ?></td>
			<?php 
				if($_SESSION['role']=='Cashier'){
					
				}
				else{
					if ($r['pay_sts'] == 'Belum Lunas') {
						echo '<td style="vertical-align: middle; text-align:center;">
							<center><a style="text-decoration: none;" href="pay_action.php?task=absen&id='.$r['pay_id'].'">
							<button class="btn btn-outline btn-danger btn-block btn-xs"><i class="fa fa-remove"></i>&nbsp;&nbsp;Batalkan Tagihan</button>
							</a></center>
						</td>';
					} elseif ($r['pay_sts'] == 'Batal') {
						echo '<td style="vertical-align: middle; text-align:center;">
							<center><a style="text-decoration: none;" href="pay_action.php?task=active&id='.$r['pay_id'].'">
							<button class="btn btn-outline btn-success btn-block btn-xs"><i class="fa fa-check"></i>&nbsp;&nbsp;Aktifkan Tagihan</button>
							</a></center>
						</td>';
					}
				}
			?>
		</tr>
		<?php $no++;} ?>
	</tbody>
</table>