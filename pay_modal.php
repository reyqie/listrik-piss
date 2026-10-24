<?php
	session_start();
	include "connection.php";
	include "components/role_session.php";
?>
<div class="modal-header bg-primary text-white" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
	<h4 style="margin-left: 20px;"><i class="fa fa-money fa-fw"></i>&nbsp;Bayar Tagihan</h4>
	<button style="margin-top: -35px; margin-right: 20px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
	<form action="pay_action.php?task=insert&id=<?php echo $_GET['id']; ?>"  id="form_pay" name="form_pay" method="POST" class="form-horizontal">
		<div class="form-group" style="padding: 0 35px; margin-top: 0px;">
			<label>Kode Tagihan</label>
			<input id="kode" name="kode" type="text" value="<?php echo 'TL' . $_GET['id']; ?>" class="form-control form-xs" disabled />
		</div>
		<div class="form-group" style="padding: 0 35px; margin-top: 0px;">
			<label>Tanggal Bayar</label>
			<input id="pay_date" name="pay_date" type="date" class="form-control form-xs" required />
		</div>
		<div class="fomr-group" style="padding: 0 20px;">
			<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-money"></i>&nbsp;&nbsp;Bayar</button>
		</div>
	</form>
</div>

