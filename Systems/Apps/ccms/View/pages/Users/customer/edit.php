<?php
Controller::alert();
?>

<div class="card">
    <div class="card-header">
        <a href="<?= PORTAL ?>Users/customers/list" class="btn btn-sm btn-primary">
            <span class="fa fa-arrow-left"></span> Back
        </a>
		Edit Customer
    </div>

    <div class="card-body">
	<?php
		if(Session::get("admin")){
			$c = customers::getBy(["c_ukey" => url::get(3)]);
		}else{
			$c = customers::getBy(["c_ukey" => url::get(3), "c_id" => function($column){
				return "$column IN (SELECT cc_customer FROM clinic_customer WHERE cc_clinic = '". Session::get("clinic")->c_id ."')";
			}]);
		}
		
		if(count($c) > 0){
			$c = $c[0];
	?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
					<div class="row">
						<div class="col-md-12">
							Name:
							<input type="text" placeholder="Name" name="name" class="form-control" value="<?= $c->c_name ?>" /><br />
						</div>

						<div class="col-md-6">
							Email:
							<input type="email" placeholder="Email" name="email" class="form-control" value="<?= $c->c_email ?>" /><br />
						</div>

						<div class="col-md-6">
							Phone:
							<input type="text" placeholder="+60 ..." name="phone" class="form-control" value="<?= $c->c_phone ?>" /><br />
						</div>

						<div class="col-md-6">
							IC:
							<input type="text" placeholder="IC / Passport" name="ic" class="form-control" value="<?= $c->c_ic ?>" /><br />
						</div>

						<div class="col-md-6">
							Address:
							<textarea type="text" placeholder="Address" name="address" rows="3" class="form-control" value=""><?= $c->c_address ?></textarea><br />
						</div>

						<div class="col-md-12 text-center">
							<button class="btn btn-sm btn-primary">
								<span class="fa fa-save"></span> Save
							</button>
							
						<?php
							Controller::form("customer", ["action" => "update"]);
						?>
						</div>

					</div>
                </div>
            </div>
        </form>
	<?php
		}else{
			new Alert("error", "Selected customer information is not found.");
		}
	?>
    </div>
</div>