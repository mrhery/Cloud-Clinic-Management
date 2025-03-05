<?php
// Sales total calculation
$sales_total = 0;
$sales_total_paid = 0;
$sales_dashboard = DB::conn()->query("SELECT * FROM sales WHERE s_client = '" . Session::get("clinic")->c_id . "'")->results();
//$sales_dashboard = DB::conn()->query("SELECT * FROM sales WHERE s_client = 'discount'")->results();
foreach ($sales_dashboard as $sales) {
	$sales_total = $sales_total + $sales->s_total;
}
foreach ($sales_dashboard as $sales) {
	$sales_total_paid = $sales_total_paid + $sales->s_paid;
}

// Total client for the company
$company_clients = DB::conn()->query("SELECT * FROM clinic_customer WHERE cc_clinic = '" . Session::get("clinic")->c_id . "'")->results();
$total_company_client = count($company_clients);
// die(var_dump(count($company_clients)));

// List of client company sales daily
$client_list = DB::conn()->query("SELECT * FROM clients")->results();

foreach ($sales_dashboard as $sales) {
	foreach ($client_list as $client) {
		if ($sales->s_client == $client->c_id) {
			$sales->sc_name = $client->c_name;
		}
	}
}

// Apointment list
$appointment_list = DB::conn()->query("SELECT * FROM appointments WHERE a_status = 0 AND a_clinic = '" . Session::get("clinic")->c_id . "'")->results();

foreach ($sales_dashboard as $sales) {
	foreach ($client_list as $client) {
		if ($sales->s_client == $client->c_id) {
			$sales->sc_name = $client->c_name;
		}
	}
}

$customer_list = DB::conn()->query("SELECT * FROM customers")->results();

foreach ($appointment_list as $appointment) {
	foreach ($customer_list as $customer) {
		if ($appointment->a_clinic == $customer->c_id) {
			$appointment->ap_name = $customer->c_name;
		}
	}
}

?>

<div class="row mb-2">
	<div class="col-md-4">
		<div class="card border-primary">
			<div class="card-header bg-primary text-light ">
				<span class="fa fa-dashboard"></span>

				Sales
			</div>

			<div class="card-body text-center p-2">
				<h4><?= $sales_total ?></h4>
			</div>

			<div class="card-footer ">
				<a href="<?= PORTAL ?>billing/sales/add/" class="btn btn-primary btn-sm btn-block">
					<span class="fa fa-dollar"></span>

					Add Sales
				</a>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card border-success">
			<div class="card-header bg-success text-light ">
				<span class="fa fa-dashboard"></span>

				Cash-in
			</div>

			<div class="card-body text-center  p-2">
				<h4><?= $sales_total_paid ?></h4>
			</div>

			<div class="card-footer ">
				<a href="" class="btn btn-success btn-sm btn-block">
					<span class="fa fa-eye"></span>

					View Records
				</a>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card border-info">
			<div class="card-header bg-info text-light ">
				<span class="fa fa-dashboard"></span>

				Patients
			</div>

			<div class="card-body text-center p-2 ">
				<h4><?= count($sales_dashboard) ?></h4>
			</div>

			<div class="card-footer ">
				<a href="<?= PORTAL ?>Users/customers/add/" class="btn btn-info btn-sm btn-block">
					<span class="fa fa-plus"></span>

					Add Patient
				</a>
			</div>
		</div>
	</div>
</div>

<div class="row mb-2">
	<div class="col-md-8">
		<div class="card">
			<div class="card-header">
				<span class="fa fa-list"></span> Daily Sales
			</div>

			<table class="card-body table table-hover table-bordered">
				<thead>
					<tr>
						<th width="100px" class="text-center">Date</th>
						<th>Customer</th>
						<th class="text-right">Amount</th>
					</tr>
				</thead>

				<tbody>
					<?php
					foreach ($sales_dashboard as $sale) { ?>
						<tr>
							<td class="text-center"><?= date("d-M-Y") ?></td>
							<td><?= $sale->sc_name ?></td>
							<td class="text-right"><?= number_format($sale->s_total, 2) ?></td>
						</tr>
					<?php
					}

					?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="col-md-4">
		<div class="card">
			<div class="card-header">
				<span class="fa fa-calendar"></span> Appointment
			</div>

			<table class="card-body table table-hover table-bordered">
				<thead>
					<tr>
						<th width="100px" class="text-center">Date</th>
						<th width="100px" class="text-center">Patient</th>
						<th width="100px" class="text-center">Doctor</th>
						<th width="100px" class="text-center">Time</th>
						<th width="100px" class="text-center">Status</th>
					</tr>
				</thead>

				<tbody>
					<?php
					foreach ($appointment_list as $ap) { ?>
						<tr>
							<td class="text-center"><?= date("d-M-Y") ?></td>
							<td><?= $ap->ap_name ?></td>
							<td class="text-right"><?= $ap->a_date ?></td>
							<td class="text-center"><?= $ap->a_bookedTime ?></td>
							<td class="text-center"><?= $ap->a_status ?></td>
						</tr>
					<?php
					}

					?>
				</tbody>
			</table>
		</div>
	</div>
</div>