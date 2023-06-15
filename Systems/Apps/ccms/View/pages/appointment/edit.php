<div class="card">
	<div class="card-header">
		<a href="<?= PORTAL ?>appointments" class="btn btn-sm btn-primary mr-2">
			<span class="fa fa-arrow-left"></span> Back
		</a>
		
		Edit Appointment
	</div>
	
	<div class="card-body">
	<?php
		$a = appointments::getBy(["a_ukey" => url::get(2)]);
		
		if(count($a) > 0){
			$a = $a[0];
			
			$c = customers::getBy(["c_id" => $a->a_customer])[0];
	?>
		<form action="" method="POST">
			<div class="row">
				<div class="col-md-6 mb-2">
					<h4>Customer Info</h4>
					
					Name:
					<input type="text" class="form-control" name="name" placeholder="Name" required value="<?= $c->c_name ?>" disabled /><br />
					
					IC / Passport:
					<input type="text" class="form-control" name="ic" placeholder="IC / Passport" required value="<?= $c->c_ic ?>" disabled /><br />
					
					Address:
					<textarea class="form-control" name="address" placeholder="Address" disabled><?= $c->c_address ?></textarea><br />
					
					Phone:
					<input type="tel" class="form-control" name="phone" placeholder="+60 1..." value="<?= $c->c_phone ?>" disabled /><br />
					
					Email:
					<input type="email" class="form-control" name="email" placeholder="example@abc.com" value="<?= $c->c_email ?>" disabled /><br />
				</div>
				
				<div class="col-md-6 mb-2">
					<h4>Appointment Description</h4>
					
					Description:
					<textarea class="form-control" name="reason" placeholder="Description: Fever, cough, covid test, vaccine"><?= $a->a_reason ?></textarea>
					<br />
					
					Date:
					<input type="date" name="date" class="form-control" value="<?= date("Y-m-d", strtotime($a->a_date)) ?>" /><br />
					
					Time:
					<input type="time" name="time" class="form-control" value="<?= date("H:i", $a->a_time) ?>" /><br />
					
					Status:
					<select class="form-control" name="status">
						<option value="1" <?= $a->a_status == 1 ? "selected" : "" ?>>Approved</option>
						<option value="0" <?= $a->a_status == 0 ? "selected" : "" ?>>Pending</option>
						<option value="2" <?= $a->a_status == 2 ? "selected" : "" ?>>Cancelled</option>
					</select><br />
				</div>
				
				<div class="col-md-12 text-center">
					<button class="btn btn-success">
						<span class="fa fa-save"></span> Confirm & Save Appointment
					</button>
					
				<?php
					Controller::form("appointment",
					[
						"action"	=> "update"
					]);
				?>
				</div>
			</div>
		</form>
	<?php
		}else{
			new Alert("error", "Selected appointment is not exists.");
		}
	?>
	</div>
</div>