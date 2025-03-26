<?php
Controller::alert();
?>
<div class="card">
    <div class="card-header">
         <a href="<?= PORTAL ?>Clinic" class="btn btn-primary btn-sm">
			<span class="fa fa-arrow-left"></span> Back
		</a>
		Edit Business Information
		
    </div>

    <div class="card-body">
	<?php
		$c = clinics::getBy(["c_ukey" => url::get(2)]);
		
		if(count($c) > 0){
			$c = $c[0];
	?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
				<?php
					new Alert("info", "These information will be display in as an official letterhead of your business.");
				?>
					<div class="row">
						<div class="col-md-6">
							Name:
							<input type="text" placeholder="Business Name" name="name" class="form-control" value="<?= $c->c_name ?>" disabled/> <br />
						</div>

						<div class="col-md-6">
							Email:
							<input type="email" placeholder="Email" name="email" class="form-control" value="<?= $c->c_email ?>" /> <br />
						</div>

						<div class="col-md-6">
							Phone:
							<input type="text" placeholder="Phone" name="phone" class="form-control" value="<?= $c->c_phone ?>" maxlength="10" pattern="\d{9,10}" /> <br />
						</div>

						<div class="col-md-6">
							Regsitration Number:
							<input type="text" placeholder="Reg. Number" name="regno" class="form-control" value="<?= $c->c_regno ?>" /> <br />
						</div>

						<div class="col-md-6">
							Address:
							<textarea placeholder="Address" name="address" class="form-control"><?= $c->c_address ?></textarea>
							<br />
						</div>

						<div class="col-md-12 text-center">
							<button class="btn btn-sm btn-primary">
								<span class="fa fa-save"></span> Save
							</button>
							
						<?php
							Controller::form("clinic", ["action" => "update"]);
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

<script>
document.querySelector("form").addEventListener("submit", function(event) {
    var phoneInput = document.getElementById("phone").value;
    if (!/^\d{9,10}$/.test(phoneInput)) {
        document.getElementById("phone-error").style.display = "block"; 
    } else {
        document.getElementById("phone-error").style.display = "none";
    }
});
</script>