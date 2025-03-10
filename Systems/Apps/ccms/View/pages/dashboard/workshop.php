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

<!-- <style>
.col-10 {
    text-align: left !important;
    margin-left: -149px;
}
</style> -->

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
     
<div class="row justify-content-center">

    <!-- Sales Cards Section -->
    <div class="col-md-6 d-flex flex-column" style="height: 100vh;"> 
    <!-- Ensure the column takes full height -->
    <div style="position: sticky; top: 0;  z-index: 10; padding: 10px; text-align: center;">
            <h1 style="font-size: 20px;">Daily Sales</h1>
        </div>
    <div style="flex: 1;max-height: 700px; overflow-y: auto; padding-right: 10px;"> 
        <!-- Scrollable container -->
        <br>
      
        <?php
        $no = 1;

        if(Session::get("admin")){
            $q = sales::list();
        }else{
            $q = DB::conn()->query("SELECT * FROM sales WHERE s_id IN (SELECT cc_customer FROM clinic_customer WHERE cc_clinic = ?)", [Session::get("clinic")->c_id])->results();
        }

        foreach ($sales_dashboard as $sale) {
        ?>
            <div class="card mb-3 shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            Doc:  <b><?= $sale->s_doc ?> </b><br />
                            Date: <?= $sale->s_date ?> | Total: <?= number_format($sale->s_total, 2) ?> | Paid: <?= number_format($sale->s_paid, 2) ?>
                            <hr />
                            <span class="badge badge-dark">Status: <?= $sale->s_status ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
        } 
        ?>
    </div>
</div>


    <!-- Appointments Section -->
    <div class="col-md-6 d-flex flex-column" style="height: 100vh;">
       
    <div style="position: sticky; top: 0;  z-index: 10; padding: 10px; text-align: center; border-bottom: 1px solid #ddd;">
            <h2 style="font-size: 20px;">Appointment List</h2>
        </div>
    <div style="max-height: 700px; overflow-y: auto; overflow-x: hidden;"> <!-- Scrollable container -->
       
        <?php
        $no = 1;

        if (Session::get("admin")) {
            $appointment_list = appointments::list();
        } else {
            $appointment_list = DB::conn()->query("SELECT * FROM appointments WHERE a_id IN (SELECT cc_customer FROM clinic_customer WHERE cc_clinic = ?)", [Session::get("clinic")->c_id])->results();
        }

        foreach ($appointment_list as $appointment) {
            $appointment_name = isset($appointment->a_customer->c_name) ? htmlspecialchars($appointment->a_customer->c_name) : "Mr.Hery";
            $doctor_name = isset($appointment->doctor_name) ? htmlspecialchars($appointment->doctor_name) : "-";
            $appointment_date = isset($appointment->a_date) ? date("Y-m-d", strtotime($appointment->a_date)) : "-";
            $booked_time = isset($appointment->a_bookedTime) ? $appointment->a_bookedTime : "-";
            $status = isset($appointment->a_status) ? $appointment->a_status : 0;

            // Define status classes
            $status_classes = [
                1 => "bg-success text-white",   // Approved (Green)
                2 => "bg-danger text-white",    // Cancelled (Red)
                0 => "bg-warning text-dark"     // Pending (Orange)
            ];
            $status_text = [
                1 => "Approved",
                2 => "Cancelled",
                0 => "Pending"
            ];
        ?>
            <div class="card mb-3 shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-10">
                            <b><?= $appointment_name ?> </b><br />
                            Date: <?= $appointment_date ?> | Doctor: <?= $doctor_name ?> | Time: <?= $booked_time ?>
                            <hr />
                            <div class="p-2 rounded <?= $status_classes[$status] ?>" style="display: inline-block;">
                                <b>Status: <?= $status_text[$status] ?></b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
        } 
        ?>
    </div>
</div>
</div>

