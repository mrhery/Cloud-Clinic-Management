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
    <div style="flex: 1;max-height: 700px; padding-right: 10px;"> 
        <!-- Scrollable container -->
      
      
        <?php
        $no = 1;

        if(Session::get("admin")){
            $q = sales::list();
        }else{
            $q = DB::conn()->query("SELECT * FROM sales WHERE s_id IN (SELECT cc_customer FROM clinic_customer WHERE cc_clinic = ?)", [Session::get("clinic")->c_id])->results();
        }

        $status_classes = [
            1 => "bg-success text-white",   // Approved (Green)
            2 => "bg-danger text-white",    // Cancelled (Red)
            0 => "bg-warning text-dark"     // Pending (Orange)
        ];
        $status_text = [
            1 => "Paid",
            0 => "Partial"
        ];
        
       
        
        $counter = 0;

        foreach ($sales_dashboard as $sale) {
            if ($counter >= 3) break;
            $status_classes = ($sale->s_status == 1) ? "bg-success text-white" : "bg-dark text-white";
        ?>
        
            <div class="card mb-3 shadow" style="min-height: 110px; display: flex;">
            <div class="card-body">
                <div class="row">
                    <div class="col-7">
                        Doc No: <b><?= $sale->s_doc ?></b><br />
                        Patient: 
                        <?php
                        $c = customers::getBy(["c_id" => $sale->s_client]);
                        if(count($c) > 0){
                            $c = $c[0];
                        ?>
                            <strong><?= $c->c_name ?></strong><br />
                        <?php
                        } else {
                            unset($c);
                            echo "-";
                        }
                        ?>   
                        Total: <?= number_format($sale->s_total, 2) ?>
                    </div>

                    <div class="col-5 text-end">
                        <span>Date: <?= date("d M Y", strtotime($sale->s_date)) ?></span><br />
                       Status: <span class="badge <?= $status_classes ?>"> <?= $sale->s_status ?></span>
                    </div>
                </div>
            </div>
        </div>
            <?php 
    $counter++; // Increment the counter
} 
?>
<?php if (count($sales_dashboard) > 3): ?>
    <div style="text-align: center; padding: 10px;">
        <a href="sales_page.php" class="btn btn-link">See more</a>
    </div>
<?php endif; ?>
    </div>
</div>


    <!-- Appointments Section -->
    <div class="col-md-6 d-flex flex-column" style="height: 70vh;">
       
    <div style="position: sticky; top: 0;  z-index: 10; padding: 10px; text-align: center;">
            <h2 style="font-size: 20px;">Appointment List</h2>
        </div>
    <div style="max-height: 500px;"> <!-- Scrollable container -->
       
        <?php
        $no = 1;

        if (Session::get("admin")) {
            $appointment_list = appointments::list();
        } else {
            $appointment_list = DB::conn()->query("SELECT * FROM appointments WHERE a_id IN (SELECT cc_customer FROM clinic_customer WHERE cc_clinic = ?)", [Session::get("clinic")->c_id])->results();
        }

        $counter = 0;

        foreach ($appointment_list as $appointment) {
            $appointment_name = isset($appointment->a_customer->c_name) ? htmlspecialchars($appointment->a_customer->c_name) : "Mr.Hery";
            $doctor_name = isset($appointment->doctor_name) ? htmlspecialchars($appointment->doctor_name) : "-";
            $appointment_date = isset($appointment->a_date) ? date("Y-m-d", strtotime($appointment->a_date)) : "-";
            $booked_time = isset($appointment->a_bookedTime) ? $appointment->a_bookedTime : "-";
            $status = isset($appointment->a_status) ? $appointment->a_status : 0;
            $appointment_phone = isset($appointment->a_customer->c_phone) ? htmlspecialchars($appointment->a_customer->c_phone) : 'N/A';

            if ($counter >= 3) break;
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
            <!-- Left Box: Date & Time Details -->
            <div class="col-md-4 p-1 d-flex flex-column justify-content-center text-start" 
                 style="border-right: 3px solid black;">
                <div><strong>Date:</strong> <?= date("d M Y", strtotime($appointment->a_date)) ?></div>
                <div><strong>Time:</strong> <?= $appointment->a_bookedTime ?></div>
            </div>

            <!-- Middle Box: Patient, Doctor, and Status -->
            <div class="col-md-4 p-1 d-flex flex-column justify-content-center text-start" 
                 style="">
                <div><strong>Patient:</strong> <?= $appointment_name ?></div>
                <div><strong>Doctor:</strong> <?= $doctor_name ?></div>
                <div>
                    <strong>Status:</strong>
                    <span class="badge <?= $status_classes[$status] ?>"><?= $status_text[$status] ?></span>
                </div>
            </div>

            <!-- Right Box: Phone Number -->
            <div class="col-md-4 p-1 d-flex flex-column justify-content-center text-end">
                <div><strong>Phone:</strong> <?= htmlspecialchars($appointment_phone) ?></div>
            </div>
        </div>
    </div>
</div>



            
            
                

                   
            
            <?php 
    $counter++; // Increment the counter
} 
?>
<?php if (count($appointment_list) > 3): ?>
    <div style="text-align: center; padding: 10px;">
        <a href="sales_page.php" class="btn btn-link">See more</a>
    </div>
<?php endif; ?>
    </div>
</div>
</div>


