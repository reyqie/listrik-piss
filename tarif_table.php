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
<!-- <H3 style="text-align:center; margin-top:-10px;">BIAYA LISTRIK PISS</H3> -->
<table id="lapakView" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="text-align:center;">NO</th>
			<th style="text-align:center;">DAYA</th>
			<th style="text-align:center;">TARIF PER BULAN (RP)</th>
			<th style="text-align:center;">AKSI</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$sql 	= mysql_query("select * from e_cost order by e_cost_ampere");
			$no		= 1;
			while($data=mysql_fetch_array($sql)){
		?>
		<tr>
			<td style="text-align:center;"><?php echo $no; ?></td>
			<td style="text-align:center"><?php echo $data['e_cost_ampere']; ?> Ampere</td>
			<td style="text-align:center"><?php echo format_rupiah($data['e_cost_price']); ?></td>
			<td><center>
				<a style="text-decoration: none" class="btn btn-outline btn-block btn-primary btn-xs modalEditTarif" data-toggle="modal" data-target="#modalEditTarif" data-id="<?php echo $data['e_cost_id']; ?>">
					<i class="fa fa-edit"></i>&nbsp;&nbsp;Edit
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
		$('body').on('click', '.modalEditTarif', function() {
			var tarifID = $(this).data('id'); 

			$.ajax({
				url: 'tarif_modal.php',
				type: 'GET',
				data: { id: tarifID }, 
				success: function(response) {
					$('#modalEditTarif .modal-content').html(response);
					$('#modalEditTarif').modal('show');
				}
			});
		});
	});
</script>