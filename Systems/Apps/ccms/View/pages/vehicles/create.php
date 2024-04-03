

<div class="card">
	<div class="card-header">
		<a href="<?= PORTAL ?>vehicles" class="btn btn-sm btn-primary">
			<span class="fa fa-arrow-left"></span> Back
		</a> Add Vehicle 
		
		
	</div>
	
	<div class="card-body">
		<form action="" method="POST">
			<div class="row">
				<div class="col-md-6">
					Plate No:
					<input type="text" class="form-control" name="no" placeholder="Plate No" /><br />
					
					Brand:
					<input type="text" class="form-control" name="brand" placeholder="Brand" /><br />
					
					Model:
					<input type="text" class="form-control" name="model" placeholder="Model" /><br />
					
					<?php
						Controller::form("vehicles", [
							"action"	=> "add"
						]);
					?>
					
					<button class="btn btn-primary btn-sm">
						<span class="fa fa-save"></span> Save
					</button>
				</div>
			</div>
		</form>
	</div>
</div>