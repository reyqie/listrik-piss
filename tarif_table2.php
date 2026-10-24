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
<!-- <H3 style="text-align:center; margin-top:-10px;">PERLENGKAPAN LISTRIK PISS</H3> -->
<table id="lapakView" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="text-align:center;">NO</th>
			<th style="text-align:center;">PERLENGKAPAN</th>
			<th style="text-align:center;">HARGA</th>
			<th style="text-align:center;">AKSI</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$sql 	= mysql_query("select * from e_tools order by e_tools_name");
			$no		= 1;
			while($data=mysql_fetch_array($sql)){
		?>
		<tr>
			<td style="vertical-align: middle; text-align:center;"><?php echo $no; ?></td>
			<td style="vertical-align: middle; text-align:center"><?php echo $data['e_tools_name']; ?></td>
			<td style="vertical-align: middle; text-align:center"><?php echo format_rupiah($data['e_tools_price']); ?></td>
			<td><center>
				<a style="text-decoration: none" class="btn btn-outline btn-block btn-primary btn-xs modalEditTarif2" data-toggle="modal" data-target="#modalEditTarif2" data-id="<?php echo $data['e_tools_id']; ?>">
					<i class="fa fa-edit"></i>&nbsp;&nbsp;Edit
				</a>
				<a style="text-decoration: none" class="btn btn-outline btn-block btn-danger btn-xs modalDeleteTarif2" data-toggle="modal" data-target="#modalDeleteTarif2" data-id="<?php echo $data['e_tools_id']; ?>">
					<i class="fa fa-trash"></i>&nbsp;&nbsp;Hapus
				</a>
			</center></td>
		</tr>
		<?php
			$no++;
			}
		?>
	</tbody>
</table>

<script>
	$(document).ready(function() {
		$('body').on('click', '.modalEditTarif2', function() {
			var tarifID = $(this).data('id'); 

			$.ajax({
				url: 'tarif2_modal.php',
				type: 'GET',
				data: { id: tarifID }, 
				success: function(response) {
					$('#modalEditTarif2 .modal-content').html(response);
					$('#modalEditTarif2').modal('show');
				}
			});
		});

		$('body').on('click', '.modalDeleteTarif2', function() {
			var tarifID = $(this).data('id'); 

			$.ajax({
				url: 'tarif2_delete_modal.php',
				type: 'GET',
				data: { id: tarifID }, 
				success: function(response) {
					$('#modalDeleteTarif2 .modal-content').html(response);
					$('#modalDeleteTarif2').modal('show');
				}
			});
		});
	});
</script>