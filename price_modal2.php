<?php
	session_start();
	include "connection.php";
	include "components/role_session.php";
?>

<div class="modal-header bg-primary text-white" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
	<h4 style="margin-left: 20px;"><i class="fa fa-edit fa-fw"></i>&nbsp;Edit Data Biaya</h4>
	<button style="margin-top: -35px; margin-right: 20px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
    <?php 
		$priceID		= $_GET['id'];
		$edit	= mysql_query("select * from e_pay where pay_id = '".$priceID."'");
		while($r = mysql_fetch_array($edit)){
			$periode = executeScalar("select periode_name from e_periode where periode_id = '".$r['periode_id']."'");
			$name	 = executeScalar("select merchant_name from merchant where merchant_id = '".$r['merchant_id']."'");
	?>
		<form class="form-horizontal" id="formPrice" name="formPrice" method="POST" action="price_action.php?task=update2&id=<?php echo $priceID; ?>&merchant=<?php echo $r['merchant_id'] ?>&eid=<?php echo $r['electricity_id']; ?>">
			<div class="form-group" style="padding:0 35px; margin-top: 0px;">
				<label>TAGIHAN</label>
				<input type="text" class="form-control" name="pay_id" id="pay_id" value="TL<?php echo $r['pay_id']; ?>" disabled>
			</div>
			<div class="form-group" style="padding:0 35px; margin-top: 0px;">
				<label>PENGGUNA LISTRIK</label>
				<input type="text" class="form-control" name="name" id="name" value="<?php echo $name; ?>" disabled>
			</div>
			<div class="form-group" style="padding:0 35px; margin-top: 0px;">
				<label>PERIODE</label>
				<input type="text" class="form-control" name="periode" id="periode" value="<?php echo $periode; ?>" disabled>
			</div>
			<div class="form-group" style="padding:0 35px; margin-top: 0px;">
				<label>Biaya</label>
				<input class="form-control" id="price" name="price" type="number" value="<?php echo $r['pay_total']; ?>" />
			</div>
			<div class="form-group" style="padding:0 35px; margin-top: 0px;">
				<label>Keterangan</label>
				<textarea class="form-control" name="keterangan" id="keterangan" rows="3" placeholder="Keterangan edit biaya tagihan"><?php echo trim($r['keterangan']) ?></textarea>
			</div>
			<div class="form-group" style="padding: 0 35px; margin-top: 10px; margin-bottom: 0px;">
				<center><button type="submit" class="btn btn-block btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Simpan</button></center>
			</div>
		</form>
	<?php }?>
</div>