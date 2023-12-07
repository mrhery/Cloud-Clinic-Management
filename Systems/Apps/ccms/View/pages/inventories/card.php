<?php
$i = items::getBy(["i_key" => url::get(2), "i_clinic" => Session::get("clinic")->c_id]);

$show = input::get("show");

switch($show){
	default:
	case "today":
		$show = "today";
	break;
	
	case "week":
		$show = "week";
	break;
	
	case "month":
		$show = "month";
	break;
	
	case "year":
		$show = "year";
	break;
}
?>
<div class="card">
	<div class="card-header">
		<a href="<?= PORTAL ?>inventories" class="btn btn-sm btn-primary mr-2">
			<span class="fa fa-arrow-left"></span> Back
		</a>
		
		Stock Card
	</div>
	
	<div class="card-body">
	<?php
		if(count($i) > 0){
			$i = $i[0];
	?>
		<div class="row">
			<div class="col-md-3">
				Name:
				<input type="text" class="form-control" name="name" placeholder="Item or Service name" value="<?= $i->i_name ?>" disabled /><br />
				
				Description:
				<textarea class="form-control" name="description" placeholder="Description" disabled><?= $i->i_description ?></textarea><br />
				
				Type:
				<select class="form-control" name="type" disabled>
					<option value="product" <?= $i->i_type == "product" ? "selected" : "" ?>>Product</option>
					<option value="service" <?= $i->i_type == "service" ? "selected" : "" ?>>Service</option>
				</select><br />
				
				<div class="row">
					<div class="col-md-6">
						Sale Price:
						<input type="number" class="form-control" step="0.1" placeholder="0.00" name="price" value="<?= $i->i_price ?>" disabled /><br />
					</div>
					
					<div class="col-md-6">
						P. Price:
						<input type="number" class="form-control" step="0.1" placeholder="0.00" name="cost" value="<?= $i->i_cost ?>" disabled /><br />
					</div>
				</div>
				
				Code:
				<input type="text" class="form-control" name="code" placeholder="Item code" value="<?= $i->i_code ?>" disabled /><br />
				
				SKU:
				<input type="text" class="form-control" name="sku" placeholder="SKU(s)" value="<?= $i->i_sku ?>" disabled /><br />
			</div>
			
			<div class="col-md-9">
				<div class="mb-3">
					<a class="btn btn-sm btn-<?= $show == "today" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>inventories/card/<?= $i->i_key ?>?show=today">
						Today
					</a>
					
					<a class="btn btn-sm btn-<?= $show == "week" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>inventories/card/<?= $i->i_key ?>?show=week">
						This week
					</a>
					
					<a class="btn btn-sm btn-<?= $show == "month" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>inventories/card/<?= $i->i_key ?>?show=month">
						This month
					</a>
					
					<a class="btn btn-sm btn-<?= $show == "year" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>inventories/card/<?= $i->i_key ?>?show=year">
						This year
					</a>
				</div>
				
				<table class="table table-hover table-bordered dataTable">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Date</th>
							<th class="text-center">Quantity</th>
							<th class="text-right">Cost</th>
							<th>Remarks</th>
						</tr>
					</thead>
					
					<tbody>
					<?php
						switch($show){
							case "today":
								$r = item_inventory::getBy(["ii_date" => F::GetDate(), "ii_clinic" => Session::get("clinic")->c_id, "ii_item" => $i->i_id]);
							break;
							
							case "week":
								$r = item_inventory::getBy(["ii_date" => F::GetDate(), "ii_clinic" => Session::get("clinic")->c_id, "ii_item" => $i->i_id]);
							break;
							
							case "month":
								$r = item_inventory::getBy(["ii_date" => F::GetDate(), "ii_clinic" => Session::get("clinic")->c_id, "ii_item" => $i->i_id]);
							break;
							
							case "year":
								$r = item_inventory::getBy(["ii_date" => F::GetDate(), "ii_clinic" => Session::get("clinic")->c_id, "ii_item" => $i->i_id]);
							break;
						}
					?>
					</tbody>
				</table>
			</div>
		</div>
	<?php
		}
	?>
	</div>
</div>
