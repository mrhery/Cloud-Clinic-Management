<div class="card">
    <div class="card-header">
         <a href="<?= PORTAL ?>billing/supplier/list" class="btn btn-primary btn-sm">
			<span class="fa fa-arrow-left"></span> Back
		</a> Supplier Information
		
    </div>

    <div class="card-body">
	<?php
		
			$c = clients::getBy(["c_key" => url::get(3)]);
 
				if(count($c) > 0){
					$c = $c[0];
					
					$c = clients::getBy(["c_key" => url::get(3)]);
			?>
        <form action="" method="post" enctype="multipart/form-data">
 
            <div class="row">
                <div class="col-md-12">
				<?php
					new Alert("info", "These information will be display  as an officialsupplier information.");
				?>
					<div class="row">
						<div class="col-md-6">
							Name:
							<input type="text" placeholder="Business Name" name="c_name" value="<?= $c[0]->c_name ?>"  class="form-control" /> <br />
						</div>

						<div class="col-md-6">
							Email:
							<input type="email" placeholder="Email" name="c_email" value="<?= $c[0]->c_email ?>" class="form-control" /> <br />
						</div>

						<div class="col-md-6">
							Phone:
							<input type="text" placeholder="Phone" name="c_phone" value="<?= $c[0]->c_phone ?>" class="form-control" /> <br />
						</div>

						<div class="col-md-6">
							Regsitration Number:
							<input type="text" placeholder="Reg. Number" name="c_regno" value="<?= $c[0]->c_regno ?>" class="form-control" /> <br />
						</div>
		 
						<div class="col-md-6">
							Address:
							<input placeholder="Address" name="c_address" value="<?= $c[0]->c_address?>" class="form-control"></input>
							<br />
						</div>
						
					<!-- 	<div class="col-md-6">
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
						</div> -->

						<div class="col-md-12 text-center">
							<button class="btn btn-sm btn-primary">
								<span class="fa fa-save"></span> Save
							</button>
							
						<?php
							Controller::form("clients", ["action" => "edit"]);
						?>
						</div>
					</div>
                </div>
            </div>
        </form>
		<?php
		}
		?>
	
	
    </div>

</div>