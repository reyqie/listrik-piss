<?php
	session_start();
	include "connection.php";
	include "components/role_session.php";
?>

<div class="modal-header bg-primary text-white" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
	<h4 style="margin-left: 20px;"><i class="fa fa-trash fa-fw"></i>&nbsp;Hapus Data Perlengkapan Listrik</h4>
	<button style="margin-top: -35px; margin-right: 20px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
<?php 
	$tarifID		= $_GET['id'];
	$edit	= mysql_query("select * from e_tools where e_tools_id = '".$tarifID."'");
	while($r = mysql_fetch_array($edit)){
	?>
		<form action="tarif_action2.php?task=delete&id=<?php echo $r['e_tools_id']; ?>" class="form-horizontal" id="formTarif" name="formTarif" method="POST">
			<div class="form-group" style="padding:0 35px; margin-top: 0px;">
				<label>Nama Perlengkapan Listrik</label>
				<input class="form-control" id="tools" name="tools" type="text" value="<?php echo $r['e_tools_name']; ?>" disabled/>
			</div>
			<div class="form-group" style="padding:0 35px; margin-top: 0px;">
				<label>Harga <sup>(Rp)</sup></label>
				<input class="form-control" id="price" name="price" type="text" value="<?php echo $r['e_tools_price']; ?>" disabled/>
					<script>
					$("input[name='price']").TouchSpin({
						verticalbuttons: true,
						verticalupclass: 'glyphicon glyphicon-plus',
						verticaldownclass: 'glyphicon glyphicon-minus'
						});
					</script>
				</div>
				<div class="form-group" style="padding: 0 35px; margin-top: 10px; margin-bottom: 0px;">
					<center><button type="submit" class="btn btn-block btn-danger"><i class="fa fa-save"></i>&nbsp;&nbsp;Simpan</button></center>
				</div>
			</form>
		<?php }?>
</div>