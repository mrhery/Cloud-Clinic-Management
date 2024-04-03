<?php
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
        <span class="fa fa-building"></span> Cashflow Records
		
		<a href="<?= PORTAL ?>billing/cashflow/add" class="btn btn-primary btn-sm">
			<span class="fa fa-plus"></span> Add Record
		</a>
    </div>

    <div class="card-body">
		<div class="mb-3">
			<a class="btn btn-sm btn-<?= $show == "today" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>billing/cashflow?show=today">
				Today
			</a>
			
			<a class="btn btn-sm btn-<?= $show == "week" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>billing/cashflow?show=week">
				This week
			</a>
			
			<a class="btn btn-sm btn-<?= $show == "month" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>billing/cashflow?show=month">
				This month
			</a>
			
			<a class="btn btn-sm btn-<?= $show == "year" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>billing/cashflow?show=year">
				This year
			</a>
		</div>
		
        <table class="table dataTable table-hover table-fluid">
			<thead>
				<tr>
					<th class="text-center" width="5%">No</th>
					<th class="text-center">Date</th>
					<th class="text-center">Doc.</th>					
					<th class="text-center" width="20%">Details</th>
					<th class="text-right">Amount (RM)</th>
					<th class="text-center">User</th>
					<th class="text-right" width="10%">:::</th>
				</tr>
			</thead>
			
			<tbody>
			<?php
				switch($show){
					case "today":
						$r = transactions::getBy(["t_delete" => 0, "t_doc_datetime" => function(){
							return "DATE(t_doc_datetime) = DATE(NOW())";
						}]);
					break;
					
					case "week":
						$r = transactions::getBy(["t_delete" => 0, "t_doc_datetime" => function(){
							return "YEARWEEK(t_doc_datetime, 1) = YEARWEEK(CURDATE(), 1)";
						}]);
					break;
					
					case "month":
						$r = transactions::getBy(["t_delete" => 0, "t_doc_datetime" => function(){
							return "MONTH(t_doc_datetime) = MONTH(CURRENT_DATE()) AND YEAR(t_doc_datetime) = YEAR(CURRENT_DATE())";
						}]);
					break;
					
					case "year":
						$r = transactions::getBy(["t_delete" => 0, "t_doc_datetime" => function(){
							return "YEAR(t_doc_datetime) = YEAR(CURRENT_DATE())";
						}]);
					break;
				}
				
				$no = 1;
				
				foreach($r as $t){
				?>
				<tr>
					<td class="text-center"><?= $no++ ?></td>
					<td class="text-center"><?= $t->t_doc_datetime ?></td>
					<td class="text-center"><?= $t->t_doc_no ?></td>					
					<td class="text-center"><?= $t->t_description ?></td>
					<td class="text-right"><?= number_format($t->t_amount, 2) ?></td>
					<td class="text-center"><?= $t->t_user ?></td>
					<td class="text-right">
						<a href="<?= PORTAL ?>billing/cashflow/view/<?= $t->t_key ?>" class="btn btn-sm btn-info">
							<span class="fa fa-eye"></span>
						</a>
						
						<a href="<?= PORTAL ?>billing/cashflow/edit/<?= $t->t_key ?>" class="btn btn-sm btn-warning">
							<span class="fa fa-edit"></span>
						</a>
						
						<a href="<?= PORTAL ?>billing/cashflow/delete/<?= $t->t_key ?>" class="btn btn-sm btn-danger">
							<span class="fa fa-trash"></span>
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