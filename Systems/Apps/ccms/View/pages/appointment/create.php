<div class="card">
	<div class="card-header">
		<a href="<?= PORTAL ?>appointments" class="btn btn-sm btn-primary mr-2">
			<span class="fa fa-arrow-left"></span> Back
		</a>
		
		Create new Appointments
	</div>
	
	<div class="card-body">
		<form action="" method="POST">
			<div class="row">
				<div class="col-md-6 mb-2">
					<h4>Customer Info</h4>
					
					Name:
					<input type="text" class="form-control" name="name" placeholder="Name" /><br />
					
					IC / Passport:
					<input type="text" class="form-control" name="ic" placeholder="IC / Passport" /><br />
					
					Address:
					<textarea class="form-control" name="address" placeholder="Address"></textarea>
					
					Phone:
					<input type="tel" class="form-control" name="phone" placeholder="+60 1..." /><br />
					
					Email:
					<input type="email" class="form-control" name="email" placeholder="example@abc.com" /><br />
				</div>
				
				<div class="col-md-6 mb-2">
					<h4>Appointment Description</h4>
					
					Description:
					<textarea class="form-control" name="description" placeholder="Description: Fever, cough, covid test, vaccine"></textarea><br />
					
					Status:
					<select class="form-control" name="status">
						<option value="1">Approved</option>
						<option value="0">Pending</option>
						<option value="2">Cancelled</option>
					</select><br />
				</div>
				
				<div class="col-md-12 text-center">
					<button class="btn btn-success">
						<span class="fa fa-save"></span> Confirm & Save Appointment
					</button>
				</div>
			</div>
		</form>
	</div>
</div>