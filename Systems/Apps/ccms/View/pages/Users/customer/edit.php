<?php
Controller::alert();
?>
<h4>Edit Patient</h4>

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
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					Name:
					<input type="text" placeholder="Name" name="name" class="form-control" value="<?= $c->c_name ?>" /><br />
				</div>

				<div class="col-md-12">
					Email:
					<input type="email" placeholder="Email" name="email" class="form-control" value="<?= $c->c_email ?>" /><br />
				</div>

				<div class="col-md-12">
					Phone:
					<input type="text" placeholder="+60 ..." name="phone" class="form-control" value="<?= $c->c_phone ?>" /><br />
				</div>
				
				<div class="col-md-12">
					IC:
					<input type="text" placeholder="IC / Passport" name="ic" class="form-control" value="<?= $c->c_ic ?>" /><br />
				</div>

				<div class="col-md-12">
					Address:
					<textarea type="text" placeholder="Address" name="address" rows="3" class="form-control" value=""><?= $c->c_address ?></textarea><br />
				</div>
				
				<div class="col-md-12 text-center">
					<button class="btn btn-sm btn-primary">
						<span class="fa fa-save"></span> Save
					</button>
					
				<?php
					Controller::form("customer", ["action" => "edit"]);
				?>
				</div>

			</div>
		</div>
		
		<div class="col-md-6">
		<!--
		<h3>Vehicles</h3>
			
			<table class="table table-hover table-bordered table-fluid">
				<thead>
					<tr>
						<th class="text-center">No</th>
						<th class="text-center">Plate</th>
						<th>Brand / Model</th>
					</tr>
				</thead>
				
				<tbody>
					<tr>
						<td class="text-center">1</td>
						<td class="text-center">JSN 471</td>
						<td>Honda BRV</td>
					</tr>
					
					<tr>
						<td class="text-center">2</td>
						<td class="text-center">JTW 7442</td>
						<td>Produa Axia</td>
					</tr>
					
					<tr>
						<td class="text-center">3</td>
						<td class="text-center">JPD 1929</td>
						<td>Nissan Almera</td>
					</tr>
				</tbody>
			</table>
		-->
		</div>
	</div>
</form>
<?php
}else{
	new Alert("error", "Selected customer information is not found.");
}
?>