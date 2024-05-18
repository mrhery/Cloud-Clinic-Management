<?php
$show = input::get("show");

switch($show){
	default:
	case "all":
		$show = "all";
	break;
	
	case "products":
		$show = "products";
	break;
	
	case "services":
		$show = "services";
	break;
	
	case "discounts":
		$show = "discounts";
	break;
	
	case "packages":
		$show = "packages";
	break;
}
?>
<div class="card">
	<div class="card-header">
		<span class="fa fa-calendar"></span> Inventories 
		
		<a href="<?= PORTAL ?>inventories/create" class="btn btn-sm btn-primary">
			<span class="fa fa-plus"></span> Add Item
		</a>
		
		<a href="<?= PORTAL ?>inventories/create-package" class="btn btn-sm btn-primary">
			<span class="fa fa-plus"></span> Add package
		</a>
	</div>
	
	<div class="card-body">
		<div class="mb-3">
			<a class="btn btn-sm btn-<?= $show == "all" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>inventories?show=all">
				All
			</a>
			
			<a class="btn btn-sm btn-<?= $show == "products" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>inventories?show=products">
				Products
			</a>
			
			<a class="btn btn-sm btn-<?= $show == "services" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>inventories?show=services">
				Services
			</a>
			
			<a class="btn btn-sm btn-<?= $show == "discounts" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>inventories?show=discounts">
				Discounts
			</a>
			
			<a class="btn btn-sm btn-<?= $show == "packages" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>inventories?show=packages">
				Packages
			</a>

			<a class="btn btn-sm btn-primary" href="<?= PORTAL ?>print-list-inventories?show=<?= $show ?>">
				Print
			</a>
		</div>
		
		<table class="table dataTable table-hover">
			<thead>
				<tr>
					<th class="text-center" width="3%">No</th>
					<th class="text-center" width="7%">Type</th>
					<th class="">Details</th>
					<th class="text-center" width="5%">Qty.</th>
					<th class="text-center" width="5%">Code</th>
					<th class="text-right" width="10%">:::</th>
				</tr>
			</thead>
			
			<tbody>
			<?php
				$no = 1;
				if(Session::get("clinic") == null){
					// echo('<p class="text-danger mb-3">Plesae select clinic first to show list</p>');
					switch($show){
						default:
						case "all":
							$r = items::list();
						break;
						
						case "products":
							$r = items::getBy(["i_type" => "product"]);
						break;
						
						case "services":
							$r = items::getBy(["i_type" => "service"]);
						break;

						case "discounts":
							$r = items::getBy(["i_type" => "discount"]);
						break;
						
						case "packages":
							$r = items::getBy(["i_type" => "package"]);
						break;
					}
				}else{
					switch($show){
						default:
						case "all":
							$r = items::getBy(["i_clinic" => Session::get("clinic")->c_id]);
						break;
						
						case "products":
							$r = items::getBy(["i_clinic" => Session::get("clinic")->c_id, "i_type" => "product"]);
						break;
						
						case "services":
							$r = items::getBy(["i_clinic" => Session::get("clinic")->c_id, "i_type" => "service"]);
						break;

						case "discounts":
							$r = items::getBy(["i_clinic" => Session::get("clinic")->c_id, "i_type" => "discount"]);
						break;
						
						case "packages":
							$r = items::getBy(["i_clinic" => Session::get("clinic")->c_id, "i_type" => "package"]);
						break;
					}
				}

				$no = 1;
				
				foreach($r as $i){
			?>
				<tr>
					<td class="text-center"><?= $no++ ?></td>
					<td class="text-center"><?= $i->i_type ?></td>
					<td>
						<?= $i->i_name ?><br /><br />
						
						<strong>Description</strong><br />
						<?= $i->i_description ?><br /><br />
						
						<strong>Sales Price: </strong> RM <?= number_format($i->i_price, 2) ?> | <strong>Purchase Price:</strong> RM <?= number_format($i->i_cost, 2) ?>
					</td>
					
					<td class="text-center">
						<?= $i->i_quantity ?>
					</td>
					
					<td class="text-center">
						<?= $i->i_code ?>
					</td>
					
					<td class="text-right">
						<a class="btn btn-sm btn-warning btn-block mb-2" href="<?= PORTAL ?>inventories/edit/<?= $i->i_key ?>">
							<span class="fa fa-edit"></span> Edit
						</a>	
						
						<a class="btn btn-sm btn-info btn-block" href="<?= PORTAL ?>inventories/card/<?= $i->i_key ?>">
							<span class="fa fa-file"></span> Stock Card
						</a>
					</td>
				</tr>
			<?php
				}
			?>
			</tbody>
		</table>
	</div>
</div>