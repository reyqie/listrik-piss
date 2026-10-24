<?php
	include "connection.php";
	function executeScalar($sql,$def=0){
		$rs = mysql_query($sql) or die(mysql_error().$sql);
		if (mysql_num_rows($rs)) {$r = mysql_fetch_row($rs);mysql_free_result($rs);return $r[0];}
		return $def;
	}
?>
<!-- jquery -->
<script src="dataTables/jquery.dataTables.js"></script>
<script src="dataTables/dataTables.tableTools.js"></script>
<script src="dataTables/dataTables.bootstrap.js"></script>
<script>
	$(document).ready(function() {
		//data table
		$('#homeView').dataTable({"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]});
	});
</script>
<table id="homeView" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="width:10%;">No</th>
			<th style="width:20%;">Nama Pedagang</th>
			<th style="width:20%;">Lapak Awal</th>
			<th style="width:20%;">Lapak Akhir</th>
			<th style="width:20%;">Tanggal Pindah</th>
			<th style="width:10%;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sql 	= "select * from log_lapak";
		$query 	= mysql_query($sql);
		$no		= 1;
			while($data=mysql_fetch_array($query)) { 
		?>
		<tr>
			<td style="text-align:center;"><?php echo $no; ?></td>
			<td><?php echo $lapak 	= executeScalar("select nama from pedagang where id_pedagang='".$data[1]."' "); ?></td>
			<td><?php echo $lapak2 	= executeScalar("select lapak_nama from lapak where lapak_id='".$data[2]."' "); ?></td>
			<td><?php echo $lapak3 	= executeScalar("select lapak_nama from lapak where lapak_id='".$data[3]."' "); ?></td>
			<td><?php echo $data[4]; ?></td>
			<td><center><a href="home_edit.php?id=<?php echo $data[0]; ?>"><button class="btn btn-outline btn-block btn-primary btn-xs">Edit</button></a></center></td>
		</tr>
		<?php
			$no++;
			}
		?>
	</tbody>
</table>