<?php
$show = input::get("show");

switch($show){
	default:
	case "all":
		$show = "all";
	break;
	
	case "invoice":
		$show = "invoice";
	break;
	
	case "credit":
		$show = "credit";
	break;
}
?>

<div class="card">
    <div class="card-header">
        <span class="fa fa-building"></span> Purchasing Records
		
		<a href="<?= PORTAL ?>billing/purchasing/add" class="btn btn-primary btn-sm">
			<span class="fa fa-plus"></span> Add Record
		</a>
    </div>

    <div class="card-body">
		<div class="mb-3">
			<a class="btn btn-sm btn-<?= $show == "all" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>billing/purchasing?show=all">
				All
			</a>
			
			<a class="btn btn-sm btn-<?= $show == "invoice" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>billing/purchasing?show=invoice">
				Invoices / Bills
			</a>
			
			<a class="btn btn-sm btn-<?= $show == "credit" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>billing/purchasing?show=credit">
				Credit / Debit Note
			</a>
		</div>
		
        <table class="table dataTable table-hover table-fluid">
			<thead>
				<tr>
					<th class="text-center" width="5%">No</th>
					<th class="text-center">Date</th>
					<th class="text-center">Doc.</th>					
					<th class="text-center" width="20%">Details</th>
					<th class="text-right">Total</th>
					<th class="text-right">Paid</th>
					<th class="text-center">Status</th>
					<th class="text-right" width="10%">:::</th>
				</tr>
			</thead>
			
			<tbody>
			</tbody>
		</table>
    </div>
</div>