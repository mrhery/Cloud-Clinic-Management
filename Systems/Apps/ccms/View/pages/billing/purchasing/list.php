<?php
$show = input::get("show");

switch ($show) {
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
				Credit Note
			</a>

			<a class="btn btn-sm btn-<?= $show == "debit" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>billing/purchasing?show=debit">
				Debit Note
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
				switch ($show) {
					case "all":
						$r = purchases::getBy(["p_clinic" => Session::get("clinic")->c_id]);
						break;

					case "invoice":
						$r = purchases::getBy(["p_clinic" => Session::get("clinic")->c_id, "p_type" => "invoice"]);
						break;

					case "credit":
						$r = purchases::getBy(["p_clinic" => Session::get("clinic")->c_id, "p_type" => "credit_note"]);
						break;

					case "debit":
						$r = purchases::getBy(["p_clinic" => Session::get("clinic")->c_id, "p_type" => "debit_note"]);
						break;
				}

				$no = 1;

				foreach ($r as $p) {
				?>
					<tr>
						<td class="text-center"><?= $no++ ?></td>
						<td class="text-center"><?= $p->p_date ?></td>
						<td class="text-center"><?= $p->p_doc ?></td>
						<td class="text-center"><?= $p->p_summary ?></td>
						<td class="text-right"><?= number_format($p->p_total, 2) ?></td>
						<td class="text-right"><?= number_format($p->p_paid, 2) ?></td>
						<td class="text-center"><?= $p->p_status ?></td>
						<td class="text-right">
							<a href="<?= PORTAL ?>billing/purchasing/view/<?= $p->p_key ?>" class="btn btn-sm btn-info">
								<span class="fa fa-eye"></span> View
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