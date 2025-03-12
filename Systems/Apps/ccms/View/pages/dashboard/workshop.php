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
    <div class="col-md-6 d-flex flex-column align-items-start" style="height: 100vh;"> 
    <!-- Ensure the column takes full height -->
    <div style="position: sticky; top: 0; z-index: 10; padding: 10px; text-align: center; width: 100%;">
        <h1 style="font-size: 20px;">Daily Sales</h1>
    </div>
    
    <div style="max-height: 700px; padding-right: 10px; overflow-y: auto; width: 100%;"> 
        <!-- Scrollable container -->
      
        <?php
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
        $counter++; 
        } 
        ?>
        
        <?php if (count($sales_dashboard) > 3): ?>
            <div style="text-align: center; padding: 5px;">
                <a href="#salesPopup" class="btn btn-link" onclick="openPopup()">See more</a>
            </div>
        <?php endif; ?>
    </div>
</div>



    <!-- Appointments Section -->
    <div class="col-md-6 d-flex flex-column" style="height: 100vh;"> <!-- Reduce the height here -->

    <div style="position: sticky; top: 0; z-index: 10; padding: 10px; text-align: center; width: 100%;">
    <h2 style="font-size: 18px; margin-bottom: 5px;">Appointment List</h2> <!-- Reduce font size -->
</div>

<div style="max-height: 700px;"> <!-- Reduce max-height here -->
    <?php
    $counter = 0;

    foreach ($appointment_list as $appointment) {
        if ($counter >= 3) break;

        $appointment_name = isset($appointment->a_customer->c_name) ? htmlspecialchars($appointment->a_customer->c_name) : "Mr.Hery";
        $doctor_name = isset($appointment->doctor_name) ? htmlspecialchars($appointment->doctor_name) : "-";
        $appointment_date = isset($appointment->a_date) ? date("Y-m-d", strtotime($appointment->a_date)) : "-";
        $booked_time = isset($appointment->a_bookedTime) ? $appointment->a_bookedTime : "-";
        $status = isset($appointment->a_status) ? $appointment->a_status : 0;
        $appointment_phone = isset($appointment->a_customer->c_phone) ? htmlspecialchars($appointment->a_customer->c_phone) : '1234567890';

        $status_classes = [
            1 => "bg-success text-white",
            2 => "bg-danger text-white",
            0 => "bg-warning text-dark"
        ];
        $status_text = [
            1 => "Approved",
            2 => "Cancelled",
            0 => "Pending"
        ];
    ?>
    <div class="card mb-2 shadow" style="padding: 8px;"> <!-- Reduce margin and padding -->
        <div class="card-body p-2"> <!-- Reduce padding -->
            <div class="row">
                <div class="col-md-4 p-1 d-flex flex-column justify-content-center text-start position-relative">
                    <div class="h-100 d-flex flex-column justify-content-center" 
                        style="border-right: 2px solid black; margin-right: 50px;"> <!-- Reduce margin -->
                        <div><strong>Date:</strong> <?= date("d M Y", strtotime($appointment->a_date)) ?></div>
                        <div><strong>Time:</strong> <?= $appointment->a_bookedTime ?></div>
                    </div>
                </div>
                <div class="col-md-4 p-1 d-flex flex-column justify-content-start text-start">
                    <div><strong>Patient:</strong> <?= $appointment_name ?></div>
                    <div><strong>Doctor:</strong> <?= $doctor_name ?></div>
                    <div>
                        <strong>Status:</strong>
                        <span class="badge <?= $status_classes[$status] ?>"><?= $status_text[$status] ?></span>
                    </div>
                </div>
                <div class="col-md-4 p-1 d-flex flex-column align-items-start">
                    <div><strong>Phone No:</strong> <?= htmlspecialchars($appointment_phone) ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php 
        $counter++;
    } 
    ?>
   </div> <!-- Closing the max-height div -->

<div style="text-align: center; padding: 10px;">
    <a href="#appointmentPopup" class="btn btn-link" onclick="openPopup1()">See more</a>
</div>
</div>

<div id="salesPopup" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <div class="col-md-6 d-flex flex-column align-items-start" style="height: 100vh;"> 
    <!-- Ensure the column takes full height -->
    <div style="position: sticky; top: 0; z-index: 10; padding: 10px; text-align: center; width: 100%;">
        <h1 style="font-size: 20px;">Daily Sales</h1>
    </div>
    
    <div style="max-height: 700px; padding-right: 10px; overflow-y: auto; width: 100%;"> 
        <!-- Scrollable container -->
      
        <?php
        $counter = 0;

        foreach ($sales_dashboard as $sale) {
           
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
       
        } 
        ?>
    </div>
</div>

<div id="appointmentPopup" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closePopup1()">&times;</span>
        <div class="col-md-6 d-flex flex-column" style="height: 100vh;"> <!-- Reduce the height here -->

    <div style="position: sticky; top: 0; z-index: 10; padding: 10px; text-align: center; width: 100%;">
    <h2 style="font-size: 18px; margin-bottom: 5px;">Appointment List</h2> <!-- Reduce font size -->
</div>

<div style="max-height: 700px;"> <!-- Reduce max-height here -->
    <?php
    $counter = 0;

    foreach ($appointment_list as $appointment) {
       

        $appointment_name = isset($appointment->a_customer->c_name) ? htmlspecialchars($appointment->a_customer->c_name) : "Mr.Hery";
        $doctor_name = isset($appointment->doctor_name) ? htmlspecialchars($appointment->doctor_name) : "-";
        $appointment_date = isset($appointment->a_date) ? date("Y-m-d", strtotime($appointment->a_date)) : "-";
        $booked_time = isset($appointment->a_bookedTime) ? $appointment->a_bookedTime : "-";
        $status = isset($appointment->a_status) ? $appointment->a_status : 0;
        $appointment_phone = isset($appointment->a_customer->c_phone) ? htmlspecialchars($appointment->a_customer->c_phone) : '1234567890';

        $status_classes = [
            1 => "bg-success text-white",
            2 => "bg-danger text-white",
            0 => "bg-warning text-dark"
        ];
        $status_text = [
            1 => "Approved",
            2 => "Cancelled",
            0 => "Pending"
        ];
    ?>
    <div class="card mb-2 shadow" style="padding: 8px;"> <!-- Reduce margin and padding -->
        <div class="card-body p-2"> <!-- Reduce padding -->
            <div class="row">
                <div class="col-md-4 p-1 d-flex flex-column justify-content-center text-start position-relative">
                    <div class="h-100 d-flex flex-column justify-content-center" 
                        style="border-right: 2px solid black; margin-right: 50px;"> <!-- Reduce margin -->
                        <div><strong>Date:</strong> <?= date("d M Y", strtotime($appointment->a_date)) ?></div>
                        <div><strong>Time:</strong> <?= $appointment->a_bookedTime ?></div>
                    </div>
                </div>
                <div class="col-md-4 p-1 d-flex flex-column justify-content-start text-start">
                    <div><strong>Patient:</strong> <?= $appointment_name ?></div>
                    <div><strong>Doctor:</strong> <?= $doctor_name ?></div>
                    <div>
                        <strong>Status:</strong>
                        <span class="badge <?= $status_classes[$status] ?>"><?= $status_text[$status] ?></span>
                    </div>
                </div>
                <div class="col-md-4 p-1 d-flex flex-column align-items-start">
                    <div><strong>Phone No:</strong> <?= htmlspecialchars($appointment_phone) ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php 
       
    } 
    ?>
   </div> <!-- Closing the max-height div -->
</div>


<script>
    function openPopup() {
    document.getElementById("salesPopup").style.display = "block";
}

// Close the pop-up
function closePopup() {
    document.getElementById("salesPopup").style.display = "none";
}

// Close modal if user clicks outside the modal content
window.onclick = function(event) {
    var modal = document.getElementById("salesPopup");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<script>
    function openPopup1() {
    document.getElementById("appointmentPopup").style.display = "block";
}

// Close the pop-up
function closePopup1() {
    document.getElementById("appointmentPopup").style.display = "none";
}

// Close modal if user clicks outside the modal content
window.onclick = function(event) {
    var modal = document.getElementById("appointmentPopup");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

<style>
    /* Modal Styling */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

/* Modal Content */
.modal-content {
    background-color: white;
    margin: 15% auto;
    padding: 20px;
    border-radius: 8px;
    width: 50%;
    text-align: center;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
}

/* Close Button */
.close {
    color: red;
    float: right;
    font-size: 24px;
    cursor: pointer;
}

</style>

