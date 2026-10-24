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
	$('#requestView').dataTable({"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]});
	});
</script>
<h3>Daftar Pemohon Lapak PIOS</h3>
<table id="requestView" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="width:5%;">No</th>
			<th style="width:15%;">Pedagang</th>
			<th style="width:9%;">Lapak</th>
			<th style="width:26%;">Alamat</th>
			<th style="width:10%;">Telp Rumah</th>
			<th style="width:10%;">Telp HP</th>
			<th style="width:10%;">Jualan</th>
			<th style="width:8%;">Status</th>
			<th style="width:7%;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$sql 	= "select * from request where req_status = 'Disetujui' order by req_id desc";
			$query 	= mysql_query($sql);
			$no		= 1;
			while($data=mysql_fetch_array($query)){
			$lapak 	= executeScalar("select lapak_name from lapak where lapak_id='".$data['lapak_id']."' ");
			$rid 	= executeScalar("select rent_id from rent where req_id='".$data['req_id']."' ");
		?>
		<tr>
			<td style="text-align:center;"><?php echo $no; ?></td>
			<td><?php echo $data['req_name']; ?>
			</td>
			<td><?php 
				echo $lapak; ?>
			</td>
			<td><?php echo $data['address1']; ?></td>
			<td><?php echo $data['phone1']; ?></td>
			<td><?php echo $data['phone2']; ?></td>
			<td><?php echo $data['merchant_type']; ?></td>
			<td><?php echo $data['req_status']; ?></td>
			<td><center><a href="register_acc_edit2.php?id=<?php echo $rid; ?>">
				<button class="btn btn-outline btn-block btn-primary btn-xs">Lihat Detail</button>
			</a></center></td>
		</tr>
		<?php $no++; } ?>
	</tbody>
</table>