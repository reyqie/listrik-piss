<?php
	session_start();
	include "connection.php";
	include "components/role_session.php";
?>

<div class="modal-header bg-primary text-white" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
	<h4 style="margin-left: 20px;"><i class="fa fa-edit fa-fw"></i>&nbsp;Edit Data Tarif</h4>
	<button style="margin-top: -35px; margin-right: 20px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
    <?php 
		$tarifID		= $_GET['id'];
		$edit	= mysql_query("select * from e_cost where e_cost_id = '".$tarifID."'");
		while($r = mysql_fetch_array($edit)){
	?>
		<form class="form-horizontal" id="formTarif" name="formTarif" method="POST" action="tarif_action.php?task=update&id=<?php echo $r[0]; ?>">
			<div class="form-group" style="padding:0 35px; margin-top: 0px;">
				<label>Daya Digunakan</label>
				<select class="form-control" name="ampere" id="ampere" disabled>
					<option value="<?php echo $r['e_cost_ampere']; ?>"><?php echo $r['e_cost_ampere']; ?> Ampere</option>
				</select>
			</div>
			<div class="form-group" style="padding:0 35px; margin-top: 0px;">
				<label>Tarif Per Bulan <sup>(Rp)</sup> </label>
				<input class="form-control" id="price" name="price" type="text" value="<?php echo $r['e_cost_price']; ?>" />
				<script>
					$("input[name='price']").TouchSpin({
						verticalbuttons: true,
						verticalupclass: 'glyphicon glyphicon-plus',
						verticaldownclass: 'glyphicon glyphicon-minus'
					});
				</script>
			</div>
			<div class="form-group" style="padding: 0 35px; margin-top: 10px; margin-bottom: 0px;">
				<center><button type="submit" class="btn btn-block btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Simpan</button></center>
			</div>
		</form>
	<?php }?>
</div>