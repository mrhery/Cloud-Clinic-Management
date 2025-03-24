<?php
Controller::alert();
?>

<div class="card">
    <div class="card-header">
         <a href="<?= PORTAL ?>Clinic" class="btn btn-primary btn-sm">
			<span class="fa fa-arrow-left"></span> Back
		</a> Business Information
		
    </div>

    <div class="card-body">
	<?php
		if(Session::get("admin")){
	?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
				<?php
					// new Alert("info", "These information will be display in as an official letterhead of your business.");
				?>
					<div class="row">
						<div class="col-md-6">
							Name:
							<input type="text" placeholder="Business Name" name="name" class="form-control" /> <br />
						</div>

						<div class="col-md-6">
							Email:
							<input type="email" placeholder="Email" name="email" class="form-control" /> <br />
						</div>

						<div class="col-md-6">
							Phone:
							<input type="text" placeholder="Phone" name="phone" class="form-control" maxlength="10" pattern="\d{9,10}"/> <br />
						</div>

						<div class="col-md-6">
							Regsitration Number:
							<input type="text" placeholder="Reg. Number" name="regno" class="form-control" /> <br />
						</div>

						<div class="col-md-6">
							Address:
							<textarea placeholder="Address" name="address" class="form-control"></textarea>
							<br />
						</div>
						
						<div class="col-md-6">
							Owner:
							<select class="form-control" name="owner">
							<?php
								foreach(users::getBy(["u_admin" => 0]) as $u){
								?>
								<option value="<?= $u->u_id ?>"><?= $u->u_name ?></option>
								<?php
								}
							?>
							</select>
							<br />
						</div>

						<div class="col-md-12 text-center">
							<button class="btn btn-sm btn-primary">
								<span class="fa fa-save"></span> Save
							</button>
							
						<?php
							Controller::form("clinic", ["action" => "create"]);
						?>
						</div>
					</div>
                </div>
            </div>
        </form>
	<?php
		}else{
			new Alert("error", "Only admin allowed to access this page.");
		}
	?>
    </div>
</div>