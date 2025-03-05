<?php
// Sales total calculation
$sales_total = 0;
$sales_total_paid = 0;
$sales_dashboard = DB::conn()->query("SELECT * FROM sales WHERE s_client = '" . Session::get("clinic")->c_id . "'")->results();

foreach ($sales_dashboard as $sales) {
    $sales_total += $sales->s_total;
    $sales_total_paid += $sales->s_paid;
}

// Total client for the company
$company_clients = DB::conn()->query("SELECT * FROM clinic_customer WHERE cc_clinic = '" . Session::get("clinic")->c_id . "'")->results();
$total_company_client = count($company_clients);

// List of clients (for sales)
$client_list = DB::conn()->query("SELECT * FROM clients")->results();
$client_map = [];
foreach ($client_list as $client) {
    $client_map[$client->c_id] = $client->c_name;
}

// Assign client names to sales
foreach ($sales_dashboard as $sales) {
    $sales->sc_name = $client_map[$sales->s_client] ?? 'Unknown';
}

// Appointment list
$appointment_list = DB::conn()->query("SELECT * FROM appointments WHERE a_status = 0 AND a_clinic = '" . Session::get("clinic")->c_id . "'")->results();

// Fetch doctors
$doctor_list = DB::conn()->query("SELECT * FROM users")->results();
$doctor_map = [];
foreach ($doctor_list as $doctor) {
    $doctor_map[$doctor->u_id] = $doctor->u_name;
}

// Fetch customers
$customer_list = DB::conn()->query("SELECT * FROM customers")->results();
$customer_map = [];
foreach ($customer_list as $customer) {
    $customer_map[$customer->c_id] = $customer->c_name;
}

// Assign names to appointments
foreach ($appointment_list as $appointment) {
    $appointment->ap_name = $customer_map[$appointment->a_clinic] ?? 'Unknown';
    $appointment->doctor_name = $doctor_map[$appointment->a_user] ?? 'Unknown';
}
?>

<div class="row mb-2">
    <div class="col-md-4">
        <div class="card border-primary">
            <div class="card-header bg-primary text-light">
                <span class="fa fa-dashboard"></span> Sales
            </div>
            <div class="card-body text-center p-2">
                <h4><?= number_format($sales_total, 2) ?></h4>
            </div>
            <div class="card-footer">
                <a href="<?= PORTAL ?>billing/sales/add/" class="btn btn-primary btn-sm btn-block">
                    <span class="fa fa-dollar"></span> Add Sales
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-header bg-success text-light">
                <span class="fa fa-dashboard"></span> Cash-in
            </div>
            <div class="card-body text-center p-2">
                <h4><?= number_format($sales_total_paid, 2) ?></h4>
            </div>
            <div class="card-footer">
                <a href="" class="btn btn-success btn-sm btn-block">
                    <span class="fa fa-eye"></span> View Records
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-info">
            <div class="card-header bg-info text-light">
                <span class="fa fa-dashboard"></span> Patients
            </div>
            <div class="card-body text-center p-2">
                <h4><?= count($sales_dashboard) ?></h4>
            </div>
            <div class="card-footer">
                <a href="<?= PORTAL ?>Users/customers/add/" class="btn btn-info btn-sm btn-block">
                    <span class="fa fa-plus"></span> Add Patient
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
                    <?php foreach ($sales_dashboard as $sale) { ?>
                        <tr>
                            <td class="text-center"><?= date("d-M-Y") ?></td>
                            <td><?= $sale->sc_name ?></td>
                            <td class="text-right"><?= number_format($sale->s_total, 2) ?></td>
                        </tr>
                    <?php } ?>
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
                        <th class="text-center">Patient</th>
                        <th class="text-center">Doctor</th>
                        <th class="text-center">Time</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointment_list as $ap) { ?>
                        <tr>
                            <td class="text-center"><?= date("Y-m-d", strtotime($ap->a_date)) ?></td>
                            <td class="text-center"><?= $ap->ap_name ?></td>
                            <td class="text-center"><?= $ap->doctor_name ?></td>
                            <td class="text-center"><?= $ap->a_bookedTime ?></td>
                            <td class="text-center">
                                <?php if ($ap->a_status == 1): ?>
                                    <span style="color: green;">Approved</span>
                                <?php elseif ($ap->a_status == 2): ?>
                                    <span style="color: red;">Cancelled</span>
                                <?php else: ?>
                                    <span style="color: orange;">Pending</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
