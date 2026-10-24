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
	$('#rentView').dataTable({"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]});
	});
</script>
<!-- <h3 style="margin-top:-10px;text-align:center;"><center><strong>PERIODE TAGIHAN LISTRIK</strong></center></h3></br> -->
<table id="rentView" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="width:8%;text-align:center;">NO</th>
			<th style="width:25%;text-align:center;">PERIODE TAGIHAN</th>
			<th style="width:20%;text-align:center;">CETAK</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no		= 0;
			$sql 	= "select * from e_periode order by periode_id desc";
			$query 	= mysql_query($sql);
			while($data=mysql_fetch_array($query)){
				$no++;
		?>
		<tr>
			<td style="text-align:center;"><?php echo $no; ?></td>
			<td style="text-align:center;"><?php echo $data['periode_name']; ?></td>
			<td>
				<a style="text-decoration: none;" class="btn btn-block btn-outline btn-primary btn-xs" href="htmltopdf/monthly_bill.php?id=<?php echo $data['periode_id'];?>" target="_blank">
					<i class="fa fa-file-text"></i>&nbsp;&nbsp;Rekap Tagihan
				</a>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>