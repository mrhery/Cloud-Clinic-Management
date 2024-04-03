

<div class="card">
	<div class="card-header">
		<a href="<?= PORTAL ?>vehicles" class="btn btn-sm btn-primary">
			<span class="fa fa-arrow-left"></span> Back
		</a> Edit Vehicle 
	</div>
	
	<div class="card-body">
	<?php
		$v = vehicles::getBy(["v_key" => url::get(2), "v_business" => Session::get("clinic")->c_id]);
		
		if(count($v) > 0){
				$v = $v[0]
		?>
		<form action="" method="POST">
			<div class="row">
				<div class="col-md-6">
					Plate No:
					<input type="text" class="form-control" name="no" placeholder="Plate No" value="<?= $v->v_no ?>" /><br />
					
					Brand:
					<input type="text" class="form-control" name="brand" placeholder="Brand" value="<?= $v->v_brand ?>" /><br />
					
					Model:
					<input type="text" class="form-control" name="model" placeholder="Model" value="<?= $v->v_model ?>" /><br />
					
					<?php
						Controller::form("vehicles", [
							"action"	=> "edit"
						]);
					?>
					
					<button class="btn btn-primary btn-sm">
						<span class="fa fa-save"></span> Save
					</button>
				</div>
			</div>
		</form>
		<?php
		}else{
			new Alert("error", "No vehicle information found.");
		}
	?>
	</div>
</div>