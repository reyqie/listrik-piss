<?php
	session_start();
	include "connection.php";
	include "components/role_session.php";
?>

<div class="modal-header bg-primary text-white" style="border-top-left-radius: 5px; border-top-right-radius: 5px;">
	<h4 style="margin-left: 20px;"><i class="fa fa-edit fa-fw"></i>&nbsp;Edit Data Pengguna Listrik</h4>
	<button style="margin-top: -35px; margin-right: 20px;" type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
								<?php
									$registerID		= $_GET['id'];
									$edit	= mysql_query("select * from electricity where electricity_id = '".$registerID."'");
									while($r = mysql_fetch_array($edit)){
										$name 			= executeScalar("select merchant_name from merchant where merchant_id = '".$r['merchant_id']."'");
										$ampere 		= executeScalar("select e_cost_ampere from e_cost where e_cost_id = '".$r['e_cost_id']."'");
										$lapak 			= executeScalar("select lapak_name from lapak where lapak_id = '".$r['id_lapak_dipasang']."'");
										$namapetugas	= executeScalar("select checker_name from checker where checker_id = '".$r['id_petugas']."'");
								?>
								<form action="register_action.php?task=update&id=<?php echo $registerID; ?>" id="formRegister" name="formRegister" method="POST" class="form-horizontal">
									<div class="form-group" style="padding:0 35px; margin-top: 0px;">
										<label>Nama Pengguna Listrik</label>
										<input id="name" name="name" type="text" class="form-control" autofocus="autofocus" value="<?php echo $name; ?>" disabled> 
									</div>
									<div class="form-group" style="padding:0 35px; margin-top: 0px;">
										<label>Lapak Pemasangan Listrik</label>
										<!-- <input id="lapak" name="lapak" type="text" class="form-control" value="<?php echo $lapak; ?>" disabled>  -->
										<select class="form-control" name="lapak" id="lapak" required>
											<option value="<?php echo $r['id_lapak_dipasang']; ?>"><?php echo $lapak; ?></option>
											<?php 
												$sql = mysql_query("select 	lapak.lapak_id as id_lapak, 
																			lapak.lapak_name as nama_lapak 
																	from 	rent
																	join 	lapak ON lapak.lapak_id = rent.lapak_id 
																	where 	rent.merchant_id = '".$r['merchant_id']."' AND
																			( rent_sts != 'Batal' AND rent_sts2 != 'Batal' )");
												while($d = mysql_fetch_array($sql)){
											?>
												<option value="<?php echo $d['id_lapak'];?>"><?php echo $d['nama_lapak']; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group" style="padding:0 35px; margin-top: 0px;">
										<label>Petugas Lapangan</label>
										<!-- <input id="lapak" name="lapak" type="text" class="form-control" value="<?php echo $lapak; ?>" disabled>  -->
										<select class="form-control" name="petugas" id="petugas" required>
											<option value="<?php echo $r['id_petugas']; ?>"><?php echo $namapetugas; ?></option>
											<?php 
												$sql = mysql_query("select * from checker where checker_role = 'Kepala Teknisi' OR checker_role = 'Teknisi'");
												while($f = mysql_fetch_array($sql)){
											?>
												<option value="<?php echo $f['checker_id'];?>"><?php echo $f['checker_name']; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group" style="padding:0 35px; margin-top: 0px;">
										<div class="row">
											<div class="col-lg-6">
												<label>Daya Yang Digunakan</label>
												<select class="form-control" name="tarif" id="tarif" required>
													<option value="<?php echo $r['e_cost_id']; ?>"><?php echo $ampere; ?> Ampere</option>
													<?php 
														$sql = mysql_query("select * from e_cost order by e_cost_ampere");
														while($d = mysql_fetch_array($sql)){
													?>
														<option value="<?php echo $d['e_cost_id'];?>"><?php echo $d['e_cost_ampere']; ?> Ampere</option>
													<?php } ?>
												</select>
											</div>
											<div class="col-lg-6">
												<label>Status</label>
												<select class="form-control" name="status" id="status">
													<option value="<?php echo $r['electricity_sts']; ?>"><?php echo $r['electricity_sts']; ?></option>
													<option value="Aktif">Aktif</option>
													<option value="Tidak Aktif">Tidak Aktif</option>
												</select>
											</div>
										</div>
									</div>
									<div class="form-group" style="padding: 0 35px; margin-top: 10px; margin-bottom: 0px;">
										<center><button type="submit" class="btn btn-block btn-primary"><i class="fa fa-save"></i>&nbsp;&nbsp;Simpan</button></center>
									</div>
								</form>
								<?php } ?>
</div>