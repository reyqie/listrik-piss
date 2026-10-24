<?php
	session_start();
	include "connection.php";
?>

<style>
	/* HEADER FLEX */
	.dt-header{
		display:flex;
		justify-content:space-between;
		align-items:center;
		margin-bottom:10px;
	}

	/* RIGHT SIDE */
	.dt-right{
		display:flex;
		align-items:center;
		gap:10px;
	}

	/* SEARCH BOX */
	.dataTables_filter input{

		border-radius:10px;
		border:1px solid #ddd;
		padding:6px 12px;
		transition:.2s;
	}

	.dataTables_filter input:focus{

		border-color:#6366f1;
		box-shadow:0 0 0 3px rgba(99,102,241,.15);
		outline:none;

	}

	/* BUTTON EXPORT */
	.btn-export{

		margin-top: -3px;
		padding:12px 20px;
		border-radius:8px;
		color:#fff;
		font-size:14px;
		font-weight:600;
		text-decoration:none;
		display:inline-flex;
		align-items:center;
		gap:6px;
		transition:.2s;
		box-shadow:0 4px 12px rgba(0,0,0,.1);
		
	}

	a.btn-export {
		text-decoration: none;
	}

	.btn-excel{

		background:linear-gradient(135deg,#16a34a,#22c55e);

	}

	.btn-pdf{

		background:linear-gradient(135deg,#dc2626,#ef4444);

	}

	.btn-export:hover{

		transform:translateY(-2px);
		box-shadow:0 6px 18px rgba(0,0,0,.2);
		color: #fff;
	}

	.dt-right{
		display:flex;
		align-items:center;
		gap:10px;
	}

	.dataTables_filter{
		margin:0;
	}
</style>

<script src="dataTables/jquery.dataTables.js"></script>
<script src="dataTables/dataTables.tableTools.js"></script>
<script src="dataTables/dataTables.bootstrap.js"></script>
<script>
$(document).ready(function() {

	var table = $('#merchantView').DataTable({

		"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, "All"]],

		"dom":
			"<'dt-header'<'dt-left'l><'dt-right'f<'dt-buttons'>>>"+
			"tr"+
			"<'dt-footer'ip>"

	});

	// inject button setelah table jadi
	$('.dt-buttons').html(`

		<a href="exportExcel/exportReportMerchant.php" class="btn-export btn-excel" target="_blank">
			<i class="fa fa-file-excel-o"></i> Excel
		</a>

		<a href="htmltopdf/report_merchant.php" class="btn-export btn-pdf" target="_blank">
			<i class="fa fa-file-pdf-o"></i> PDF
		</a>

	`);

});
</script>
<!-- <h3><center>Data Pengguna Listrik PISS</center></h3></br> -->
<table id="merchantView" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th style="width:10%;text-align:center;">NO</th>
			<th style="text-align:center;">KODE</th>
			<th style="text-align:center;">PENGGUNA</th>
			<th style="text-align:center;">LAPAK</th>
			<th style="text-align:center;">DAYA</th>
			<th style="text-align:center;">TARIF</th>
			<th style="text-align:center;">STS PEDAGANG</th>
			<th style="text-align:center;">STS LISTRIK</th>
			<th style="text-align:center">PETUGAS</th>
			<th style="text-align:center">MULAI LANGGANAN</th>
			<th style="text-align:center;">AKSI</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$query 	= mysql_query("select * from electricity order by electricity_id desc");
			$no		= 1;

			function timeAgo($date)
			{
				$now = new DateTime(); // waktu sekarang
				$reg = new DateTime($date); // waktu register
				$diff = $now->diff($reg);

				if ($diff->y >= 1) {
					return $diff->y . " tahun lalu";
				} elseif ($diff->m >= 1) {
					return $diff->m . " bulan lalu";
				} else {
					return $diff->d . " hari lalu";
				}
			}

			while($data=mysql_fetch_array($query)){
				$price 			= executeScalar("select e_cost_price from e_cost where e_cost_id = '".$data['e_cost_id']."'");
				$ampere 		= executeScalar("select e_cost_ampere from e_cost where e_cost_id = '".$data['e_cost_id']."'");
				$name 			= executeScalar("select merchant_name from merchant where merchant_id = '".$data['merchant_id']."'");
				$petugas 		= executeScalar("select checker_name from checker where checker_id = '".$data['id_petugas']."'");
				$lapakpasang	= executeScalar("select lapak_name from lapak where lapak_id = '".$data['id_lapak_dipasang']."'");
				$statusPedagang = executeScalar("select merchant_status from merchant where merchant_id = '".$data['merchant_id']."'");
		?>
		<tr>
			<td style="vertical-align: middle; text-align:center;"><?php echo $no; ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo $data['merchant_id']; ?></td>
			<td style="vertical-align: middle; text-align:left;"><?php echo $name; ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo $lapakpasang != NULL ? $lapakpasang : 'Tidak Ada'; ?></td>
			<td style="vertical-align: middle; text-align:center;"><?php echo $ampere; ?> Amp</td>
			<td style="vertical-align: middle; text-align:center;"><?php echo format_rupiah($price); ?></td>
			<td style="vertical-align: middle; text-align:center;">
				<div style="vertical-align: middle; background-color: <?php echo $statusPedagang == 'Tidak Aktif' ? 'red' : 'green'; ?>; color: #fff; padding: 3px; border-radius: 5px; margin: 5px auto 5px auto; width: 110px;">		
					<i class="fa <?php echo $statusPedagang == 'Tidak Aktif' ? 'fa-remove' : 'fa-check'; ?>"></i>&nbsp;<?php echo $statusPedagang; ?>
				</div>
			</td>
			<td style="vertical-align: middle; text-align:center;">
				<div style="vertical-align: middle; background-color: <?php echo $data['electricity_sts'] == 'Tidak Aktif' ? 'red' : 'green'; ?>; color: #fff; padding: 3px; border-radius: 5px; margin: 5px auto 5px auto; width: 110px;">		
					<i class="fa <?php echo $data['electricity_sts'] == 'Tidak Aktif' ? 'fa-remove' : 'fa-check'; ?>"></i>&nbsp;<?php echo $data['electricity_sts']; ?>
				</div>
			</td>
			<td style="vertical-align: middle; text-align:center;">
				<div style="vertical-align: middle; background-color: <?php echo $data['id_petugas'] == '26' ? '#428bca' : 'green'; ?>; color: #fff; padding: 3px; border-radius: 5px; margin: 5px auto 5px auto; width: 140px;">		
					<i class="fa fa-user"></i>&nbsp;&nbsp;<?php echo $petugas; ?>
				</div>
			</td>
			<td style="vertical-align: middle; text-align:center;">
				<?php echo date('d M Y', strtotime($data['register_date'])); ?><br>
				<!-- Umur waktu -->
				<div style="margin-top: 5px; background: #ccc; padding: 3px 10px; border-radius: 5px; display: inline-block; font-size: 12px;">
					<?php echo timeAgo($data['register_date']); ?>
				</div>
			</td>
			<td style="vertical-align: middle; text-align:center;"><center>
				<!-- <a style="text-decoration: none" class="btn btn-outline btn-block btn-primary btn-xs modalEditRegister" data-toggle="modal" data-target="#modalEditRegister" data-id="<?php echo $data['electricity_id']; ?>">
					<i class="fa fa-edit"></i>&nbsp;&nbsp;Edit
				</a> -->
				<a style="text-decoration: none" href="merchant_edit.php?id=<?php echo $data['electricity_id']; ?>&kode=<?php echo $data['merchant_id'];?>">
					<button class="btn btn-outline btn-primary btn-block btn-xs" style="margin-bottom: 5px;"><i class="fa fa-eye"></i>&nbsp;&nbsp;Lihat Detail</button>
				</a>

				<?php if($_SESSION['role']=='Cashier'){
					
				}
				else{ ?>
				<a style="text-decoration: none" class="btn btn-outline btn-block btn-danger btn-xs modalDeleteRegister" data-toggle="modal" data-target="#modalDeleteRegister" data-id="<?php echo $data['electricity_id']; ?>">
					<i class="fa fa-trash"></i>&nbsp;&nbsp;Hapus
				</a>
				<?php } ?>
			</center></td>
		</tr>
		<?php $no++;} ?>
	</tbody>
</table>

<script>
	$(document).ready(function() {
		$('body').on('click', '.modalEditRegister', function() {
			var registerID = $(this).data('id'); 

			$.ajax({
				url: 'register_modal.php',
				type: 'GET',
				data: { id: registerID }, 
				success: function(response) {
					$('#modalEditRegister .modal-content').html(response);
					$('#modalEditRegister').modal('show');
				}
			});
		});
	});

	$('body').on('click', '.modalDeleteRegister', function() {
			var registerID = $(this).data('id'); 

			$.ajax({
				url: 'register_delete_modal.php',
				type: 'GET',
				data: { id: registerID }, 
				success: function(response) {
					$('#modalDeleteRegister .modal-content').html(response);
					$('#modalDeleteRegister').modal('show');
				}
			});
		});
</script>