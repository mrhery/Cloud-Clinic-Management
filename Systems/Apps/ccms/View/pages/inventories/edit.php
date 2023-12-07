<?php
$i = items::getBy(["i_key" => url::get(2), "i_clinic" => Session::get("clinic")->c_id]);
?>
<style>
#ic-search-list {
	display: none;
	position: absolute;
	background-color: #363636;
	width: 95%;
	overflow-y: auto;
}

.ic-list-item {
	color: white;
	padding: 10px;
	cursor: pointer;
	font-size: 9pt;
}

.ic-list-item:hover {
	background-color: black;
}
</style>

<div class="card">
	<div class="card-header">
		<a href="<?= PORTAL ?>inventories" class="btn btn-sm btn-primary mr-2">
			<span class="fa fa-arrow-left"></span> Back
		</a>
		
		Edit Item
	</div>
	
	<div class="card-body">
	<?php
		if(count($i) > 0){
			$i = $i[0];
	?>
		<form action="" method="POST">
			<div class="row">
				<div class="col-md-6">
					Name:
					<input type="text" class="form-control" name="name" placeholder="Item or Service name" value="<?= $i->i_name ?>" /><br />
					
					Description:
					<textarea class="form-control" name="description" placeholder="Description"><?= $i->i_description ?></textarea><br />
					
					Type:
					<select class="form-control" name="type">
						<option value="product" <?= $i->i_type == "product" ? "selected" : "" ?>>Product</option>
						<option value="service" <?= $i->i_type == "service" ? "selected" : "" ?>>Service</option>
					</select><br />
				</div>
				
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-6">
							Sale Price:
							<input type="number" class="form-control" step="0.1" placeholder="0.00" name="price" value="<?= $i->i_price ?>" /><br />
						</div>
						
						<div class="col-md-6">
							Purchase Price:
							<input type="number" class="form-control" step="0.1" placeholder="0.00" name="cost" value="<?= $i->i_cost ?>" /><br />
						</div>
					</div>
					
					Code:
					<input type="text" class="form-control" name="code" placeholder="Item code" value="<?= $i->i_code ?>" /><br />
					
					SKU:
					<input type="text" class="form-control" name="sku" placeholder="SKU(s)" value="<?= $i->i_sku ?>" /><br />
				</div>
				
				<div class="col-md-12 text-center">
				<?php
					Controller::form("inventories", [
						"action"	=> "edit"
					]);
				?>
					<button class="btn btn-success">
						<span class="fa fa-save"></span> Save
					</button>
				</div>
			</div>
		</form>
	<?php
		}
	?>
	</div>
</div>
