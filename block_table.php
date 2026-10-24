<?php
	include "connection.php";
?>
<!-- jquery -->
<script src="dataTables/jquery.dataTables.js"></script>
<script src="dataTables/dataTables.tableTools.js"></script>
<script src="dataTables/dataTables.bootstrap.js"></script>
<script>
	$(document).ready(function() {
	//data table
	$('#lapakView').dataTable({"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]});
	});
</script>
<H3 style="text-align:center; margin-top:-10px;">Data Block Lapak PIOS 2015</H3>
<table id="lapakView" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="text-align:center;">No</th>
			<th style="text-align:center;">Block</th>
			<th style="text-align:right">Jumlah Sekarang</th>
			<th style="text-align:right">Jumlah Max</th>
			<th style="text-align:center;">Tipe Block</th>
			<th style="text-align:right">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sql 	= mysql_query("select * from block order by block_id desc");
		$no		= 1;
			while($data=mysql_fetch_array($sql)) { 
		?>
		<tr>
			<td style="text-align:center;"><?php echo $no; ?></td>
			<td style="text-align:center;"><?php echo $data['block_id']; ?></td>
			<td style="text-align:right"><?php echo $data['block_now']; ?> Unit</td>
			<td style="text-align:right"><?php echo $data['block_max']; ?> Unit</td>
			<td style="text-align:center;"><?php echo $data['block_type']; ?></td>
			<td><center>
				<a href="block_edit.php?id=<?php echo $data[0]; ?>">
					<button class="btn btn-outline btn-block btn-primary btn-xs">Edit</button>
				</a>
			</center></td>
		</tr>
		<?php
			$no++;
			}
		?>
	</tbody>
</table>