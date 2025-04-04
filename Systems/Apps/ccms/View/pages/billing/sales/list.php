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
	
	case "debit":
		$show = "debit";
	break;
}
?>

<a href="<?= PORTAL ?>billing/sales/add" class="fab fab-right-bottom bg-primary text-light">
	<span class="fa fa-plus"></span>
</a>


<div class="mb-3">
	<a class="btn btn-sm btn-<?= $show == "all" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>billing/sales?show=all">
		All
	</a>
	
	<a class="btn btn-sm btn-<?= $show == "invoice" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>billing/sales?show=invoice">
		Invoices / Bills
	</a>
	
	<a class="btn btn-sm btn-<?= $show == "credit" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>billing/sales?show=credit">
		Credit Note
	</a>
	
	<a class="btn btn-sm btn-<?= $show == "debit" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>billing/sales?show=debit">
		Debit Note
	</a>

	<a class="btn btn-sm btn-primary" href="<?= PORTAL ?>print-list-sales?show=<?= $show ?>">
		Print
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
	<?php

		if(Session::get("clinic") == null){
			// echo('<p class="text-danger mb-3">Plesae select clinic first to show list</p>');
			switch($show){
				case "all":
					$r = sales::list();
				break;
				
				case "invoice":
					$r = sales::getBy(["s_type" => "invoice"]);
				break;
				
				case "credit":
					$r = sales::getBy(["s_type" => "credit_note"]);
				break;
				
				case "debit":
					$r = sales::getBy(["s_type" => "debit_note"]);
				break;
			}
		}else{
			switch($show){
				case "all":
					$r = sales::getBy(["s_clinic" => Session::get("clinic")->c_id]);
				break;
				
				case "invoice":
					$r = sales::getBy(["s_clinic" => Session::get("clinic")->c_id, "s_type" => "invoice"]);
				break;
				
				case "credit":
					$r = sales::getBy(["s_clinic" => Session::get("clinic")->c_id, "s_type" => "credit_note"]);
				break;
				
				case "debit":
					$r = sales::getBy(["s_clinic" => Session::get("clinic")->c_id, "s_type" => "debit_note"]);
				break;
			}
		}
		
		
		$no = 1;
		
		foreach($r as $s){
		?>
		<tr>
			<td class="text-center"><?= $no++ ?></td>
			<td class="text-center"><?= $s->s_date ?></td>
			<td class="text-center"><?= $s->s_doc ?></td>					
			<td class="text-center"><?= $s->s_summary ?></td>
			<td class="text-right"><?= number_format($s->s_total, 2) ?></td>
			<td class="text-right"><?= number_format($s->s_paid, 2) ?></td>
			<td class="text-center"><?= $s->s_status ?></td>
			<td class="text-right">
				<a href="<?= PORTAL ?>billing/sales/view/<?= $s->s_key ?>" class="btn btn-sm btn-info usp-popup-window">
					<span class="fa fa-eye"></span> View
				</a>
			</td>
		</tr>
		<?php
		}
	?>
	</tbody>
</table>