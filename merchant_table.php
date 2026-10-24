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
<!-- <h3><center><strong>DATA PENGGUNA LISTRIK PISS</strong></center></h3></br> -->
<table id="merchantView" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="width:5%;text-align:center;">NO</th>
			<th style="text-align:center">KODE</th>
			<th style="text-align:center">NAMA PENGGUNA</th>
			<th style="width:15%;text-align:center">LAPAK PASANG</th>
			<th style="width:18%;text-align:center;">DAYA DIGUNAKAN</th>
			<th style="width:12%;text-align:center;">TARIF</th>
			<th style="width:12%;text-align:center;">STATUS</th>
			<th style="width:15%;text-align:center;">AKSI</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sql 	= "	select 	* 
					from 	electricity
					order by electricity_id desc";
		$query 	= mysql_query($sql);
		$no		= 1;
		while($r=mysql_fetch_array($query)){
			$name 	= executeScalar("select merchant_name from merchant where merchant_id = '".$r['merchant_id']."'");
			$price 	= executeScalar("select e_cost_price from e_cost where e_cost_id = '".$r['e_cost_id']."'");
			$ampere = executeScalar("select e_cost_ampere from e_cost where e_cost_id = '".$r['e_cost_id']."'");
			$lapak 	= executeScalar("select lapak_name from lapak where lapak_id = '".$r['id_lapak_dipasang']."'");
		?>
		<tr>
			<td style="vertical-align: middle; text-align:center;"><?php echo $no; ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo $r['merchant_id']; ?></td>
			<td style="vertical-align: middle; text-align:left;"><?php echo $name; ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo $lapak; ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo $ampere; ?> Ampere</td>
			<td style="vertical-align: middle; text-align:right;"><?php echo format_rupiah($price); ?></td>
			<td style="vertical-align: middle; text-align:center;">
				<div style="background-color: <?php echo $r['electricity_sts'] == 'Tidak Aktif' ? 'red' : 'green'; ?>; color: #fff; padding: 3px; border-radius: 5px; margin: 5px auto 5px auto; width: 110px;">		
					<i class="fa <?php echo $r['electricity_sts'] == 'Tidak Aktif' ? 'fa-remove' : 'fa-check'; ?>"></i>&nbsp;<?php echo $r['electricity_sts']; ?>
				</div>
			</td>
			<td style="vertical-align: middle; text-align:center;">
				<a style="text-decoration: none" href="merchant_edit.php?id=<?php echo $r['electricity_id']; ?>&kode=<?php echo $r['merchant_id'];?>">
					<button class="btn btn-outline btn-primary btn-block btn-xs"><i class="fa fa-eye"></i>&nbsp;&nbsp;Lihat Detail</button>
				</a>
			</td>
		</tr>
		<?php $no++;} ?>
	</tbody>
</table>