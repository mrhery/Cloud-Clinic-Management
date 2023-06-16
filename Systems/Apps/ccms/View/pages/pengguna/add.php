<?php
Controller::alert();
?>

<div class="card">
    <div class="card-header">
		<a href="<?= PORTAL ?>pengguna/list" class="btn btn-sm btn-primary">
            <span class="fa fa-arrow-left"></span> Back
        </a>
		Add new Staff
    </div>

    <div class="card-body">
         <form action="" method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-6">
					Name:
					<input type="text" placeholder="Name" name="name" class="form-control" /><br />
					
					IC:
					<input type="text" placeholder="IC No." name="ic" class="form-control" /><br />
					
					Email:
					<input type="email" placeholder="Email" name="email" class="form-control" /><br />
					
					Phone:
					<input type="text" placeholder="Phone" name="phone" class="form-control" /><br />
					
					Address:
					<textarea type="text" placeholder="Address" name="alamat" rows="3" class="form-control"></textarea><br />
				</div>

				<div class="col-md-6">
				<?php
					if(Session::get("admin")){
				?>
					Role:
					<select class="form-control" name="role">
					<?php
						foreach (roles::list() as $role) {
						?>
							<option value="<?= $role->r_id ?>">
								<?= $role->r_name ?>
							</option>
						<?php
						}
					?>
					</select><br />
				<?php
					}
				?>
					
					Password:
					<input type="text" placeholder="Password" name="password" class="form-control" /><br />
					
					Image:
					<div class="col-md-4 mx-auto">
						<img src="<?= PORTAL ?>assets/images/profile/<?= $u->u_picture ?>" class="img img-responsive" width="50%" alt="Tiada Gambar dijumpai" /><br />
					</div>
					<input type="file" accept="image/*" multiple class="form-control" name="picture" />
					<br />
				</div>
				
				<div class="col-md-12 text-center">
					<?php
					Controller::form(
						"pengguna",
						[
							"action" => "add"
						]
					);
					?>
					<button class="btn btn-sm btn-primary">
						<span class="fa fa-save"></span> Create
					</button>
				</div>

			</div>
		</form>
    </div>
</div>