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
		
		Add Item
	</div>
	
	<div class="card-body">
		<form action="" method="POST">
			<div class="row">
				<div class="col-md-6">
					Name:
					<input type="text" class="form-control" name="name" placeholder="Item or Service name" /><br />
					
					Description:
					<textarea class="form-control" name="description" placeholder="Description"></textarea><br />
					
					Type:
					<select class="form-control" name="type">
						<option value="product">Product</option>
						<option value="service">Service</option>
					</select><br />
					
					
				</div>
				
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-6">
							Sale Price:
							<input type="number" class="form-control" step="0.1" placeholder="0.00" name="price" /><br />
						</div>
						
						<div class="col-md-6">
							Purchase Price:
							<input type="number" class="form-control" step="0.1" placeholder="0.00" name="cost" /><br />
						</div>
					</div>
					
					Code:
					<input type="text" class="form-control" name="code" placeholder="Item code" /><br />
					
					SKU:
					<input type="text" class="form-control" name="sku" placeholder="SKU(s)" /><br />
				</div>
				
				<div class="col-md-12 text-center">
				<?php
					Controller::form("inventories", [
						"action"	=> "add"
					]);
				?>
					<button class="btn btn-success">
						<span class="fa fa-save"></span> Save
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
