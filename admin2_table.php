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
	$('#admin2View').dataTable({"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]]});
	});
</script>
<!--<div class="table-responsive-->
<table id="admin2View" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%" style="font-size: 13px;">
	<thead>
		<tr>
			<th style="vertical-align: middle; width:10%; text-align:center;">NO</th>
			<th style="vertical-align: middle; width:10%; text-align:center;">USERNAME</th>
			<th style="vertical-align: middle; width:30%; text-align:center;">NAMA</th>
			<th style="vertical-align: middle; width:30%; text-align:center;">PASSWORD</th>
			<th style="vertical-align: middle; width:20%; text-align:center;">POSISI</th>
			<th style="vertical-align: middle; width:10%; text-align:center;">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$sql 	= "select * from admin where role in('pp', 'developer') order by id_admin asc";
		$query 	= mysql_query($sql);
		$no		= 1;
			while($data=mysql_fetch_array($query)) { 
		?>
		<tr>
			<td style="text-align:center; vertical-align: middle;"><?php echo $no; ?></td>
			<td style="text-align:center; vertical-align: middle;"><?php echo $data['username']; ?></td>
			<td style="text-align: left; vertical-align: middle;"><?php echo $data['name']; ?></td>
			<td style="text-align: center; vertical-align: middle;"><?php echo $data['password']; ?></td>
			<td style="text-align: center; vertical-align: middle; text-transform: uppercase;">
				<div style="vertical-align: middle; background-color: green; color: #fff; padding: 3px; border-radius: 5px; margin: 5px auto 5px auto; width: 80px;">		
					<i class="fa fa-user fa-fw"></i>&nbsp;<?php echo $data['role']; ?>
				</div>
			</td>
			<td style="text-align: center; vertical-align: middle;">
				<a class="btn btn-xs btn-outline btn-primary btn-block modalEditAdmin" data-toggle="modal" data-target="#modalEditAdmin" data-id="<?php echo $data['id_admin']; ?>">
					<i class="fa fa-edit"></i>&nbsp;Edit
				</a>
				<a class="btn btn-xs btn-outline btn-danger btn-block modalDeleteAdmin" data-toggle="modal" data-target="#modalDeleteAdmin" data-id="<?php echo $data['id_admin']; ?>">
					<i class="fa fa-trash"></i>&nbsp;Hapus
				</a>
			</td>
		</tr>
		<?php
			$no++;
			}
		?>
	</tbody>
</table>

<script>
	$(document).ready(function() {
		$('body').on('click', '.modalEditLaborer', function() {
			var laborerID = $(this).data('id'); 

			$.ajax({
				url: 'laborer_modal.php',
				type: 'GET',
				data: { id: laborerID }, 
				success: function(response) {
					$('#modalEditLaborer .modal-content').html(response);
					$('#modalEditLaborer').modal('show');
				}
			});
		});
	});

	$(document).ready(function() {
		$('body').on('click', '.modalDeleteLaborer', function() {
			var laborerID = $(this).data('id'); 

			$.ajax({
				url: 'laborer_delete_modal.php',
				type: 'GET',
				data: { id: laborerID }, 
				success: function(response) {
					$('#modalDeleteLaborer .modal-content').html(response);
					$('#modalDeleteLaborer').modal('show');
				}
			});
		});
	});
</script>