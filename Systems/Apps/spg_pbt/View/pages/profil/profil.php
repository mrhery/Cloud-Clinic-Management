<?php
new Controller(["profil"]);
$u = Session::get("user")->u_id;
$gud = users::getBy(["u_id" => $u]);

if (count($gud) > 0) {
	$gud = $gud[0];
} else {
	echo "No data found!";
}

switch (url::get(1)) {
	case "":
?>
		<div class="card">
			<div class="card-header">
				<a class="btn btn-sm btn-primary float-right" href="<?php echo PORTAL ?>profil/edit/<?php echo $u ?>">Edit Pengguna</a>
			</div>
			<div class="card-body">
				<form action="" method="get">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<div class="row">

										<div class="col-md-4">
											<img src="<?= PORTAL ?>assets/images/profile/<?= $gud->u_picture ?>" class="img-responsive" alt="" style="width:100%;height:100%;">
										</div>
										<div class="col-md-8 float-left">
											Nama Pengguna:
											<input type="text" class="form-control" placeholder="Name" value="<?= $gud->u_name ?>" disabled /><br />
											Nombor IC :
											<input type="text" class="form-control" placeholder="IC" value="<?= $gud->u_ic ?>" disabled /><br />
											Alamat :
											<input type="text" class="form-control" placeholder="Alamat" value="<?= $gud->u_alamat ?>" disabled /><br />
											Email :
											<input type="text" class="form-control" placeholder="Email" value="<?= $gud->u_email ?>" disabled /><br />
											Kata laluan :
											<input type="password" class="form-control" placeholder="Kata laluan" disabled /><br />
											Nombor Telefon :
											<input type="text" class="form-control" placeholder="Phone" value="<?= $gud->u_alamat ?>" disabled /><br />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	<?php
		break;

	case "edit":
	?>
		<div class="card">
			<div class="card-header">
				<a class="btn btn-sm btn-primary float-right" href="<?php echo PORTAL ?>profil">Kembali</a>
			</div>
			<div class="card-body">
				<form action="" method="POST">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<div class="row">

										<div class="col-md-4">
											<img src="<?= PORTAL ?>assets/images/profile/<?= $gud->u_picture ?>" class="img-responsive" alt="" style="width:100%;height:100%;">
										</div>
										<div class="col-md-8 float-left">
											Nama Pengguna:
											<input type="text" name="u_name" class="form-control" placeholder="Name" value="<?= $gud->u_name ?>" /><br />
											Nombor IC :
											<input type="text" name="u_ic" class="form-control" placeholder="IC" value="<?= $gud->u_ic ?>" /><br />
											Alamat :
											<input type="text" name="u_alamat" class="form-control" placeholder="Alamat" value="<?= $gud->u_alamat ?>" /><br />
											Email :
											<input type="text" class="form-control" placeholder="Email" value="<?= $gud->u_email ?>" /><br />
											Password :
											<input type="password" name="u_password" class="form-control" placeholder="Password" value="<?= $gud->u_password ?>" /><br />
											Nombor Telefon :
											<input type="text" name="u_phone" class="form-control" placeholder="Phone" value="<?= $gud->u_phone ?>" /><br />
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 text-center">
							<?php
							Controller::form("profil", [
								"action"	=> "edit"
							]);
							?>
							<button class="btn btn-sm btn-success">
								Simpan Maklumat
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>

<?php
}
?>