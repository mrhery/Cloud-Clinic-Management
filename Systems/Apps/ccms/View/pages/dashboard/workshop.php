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


// Fetch customers
$customer_list = DB::conn()->query("SELECT * FROM customers")->results();

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

    
    $sale_status = $sale->s_status;
    $status_class = "bg-success text-white"; // Default class
    $status_text = "Paid"; // Default text
    switch ($sale_status) {
        case 1:
        case "Paid":
            $status_class = "bg-success text-white";
            $status_text = "Paid";
            break;
        case 0:
        case "Partial":
            $status_class = "bg-danger text-white";
            $status_text = "Partial";
            break;
    }
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
                <div>
                    Status:
                    <span class="badge <?= $status_class ?>"> <?= $status_text ?></span>
                </div>
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
        $c = customers::getBy(["c_id" => $appointment->a_customer])[0];
        $u = users::getBy(["u_id" => $appointment->a_attendee])[0] ?? null;
        // $appointment_name = isset($appointment->a_customer->c_name) ? htmlspecialchars($appointment->a_customer->c_name) : "Mr.Hery";
        // $doctor_name = isset($appointment->doctor_name) ? htmlspecialchars($appointment->doctor_name) : "Dr.Hery";
        // $appointment_date = isset($appointment->a_date) ? date("Y-m-d", strtotime($appointment->a_date)) : "-";
        // $booked_time = isset($appointment->a_bookedTime) ? $appointment->a_bookedTime : "-";
        // $status = isset($appointment->a_status) ? $appointment->a_status : 0;
        // $appointment_phone = isset($appointment->a_customer->c_phone) ? htmlspecialchars($appointment->a_customer->c_phone) : '1234567890';
        // $appointment_ic = isset($appointment->a_customer->c_ic) ? htmlspecialchars($appointment->a_customer->c_ic) : '123123';

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
                        <div><strong>Date:</strong> <?= date("d M Y", strtotime($appointment->a_bookedDate)) ?></div>
                        <div><strong>Time:</strong> <?= $appointment->a_bookedTime ?></div>
                    </div>
                </div>
                <div class="col-md-4 p-1 d-flex flex-column justify-content-start text-start">
                    <div><strong>Patient:</strong> <?=$c->c_name?></div>
                    <div><strong>Doctor:</strong> <?= $u ? htmlspecialchars($u->u_name) : "" ?></div>
                    <div>
                        <strong>Status:</strong>
                        <?php
                            switch ($appointment->a_status) {
                                case "1":
                                ?>
                                    <span class="badge badge-success">Approved</span>
                                <?php
                                break;
                                
                                case "0":
                                ?>
                                    <span class="badge badge-warning">Pending</span>
                                <?php
                                break;
                                
                                case "2":
                                ?>
                                    <span class="badge badge-dark">Cancelled</span>
                                <?php
                                break;
                            }
                        ?>
                    </div>
                </div>
                <div class="col-md-4 p-1 d-flex flex-column align-items-start">
                    <div><strong>Phone No:</strong> <?= $c->c_phone ?></div>
                    <div><strong>IC No:</strong> <?= $c->c_ic ?></div>
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
        <div class="col-md-6 d-flex flex-column align-items-start" style="height: 100vh; width: 100%;"> 
            <div style="position: sticky; top: 0; z-index: 10; padding: 10px; text-align: center; width: 100%; background: white;">
                <h1 style="font-size: 20px;">Daily Sales</h1>
            </div>
            
            <div style="max-height: calc(100vh - 100px); overflow-y: auto; width: 100%;"> 
                <!-- Scrollable container -->
              
                <?php
                $counter = 0;

                foreach ($sales_dashboard as $sale) {
                    $status_classes = [
                        1 => "bg-success text-white",
                        0 => "bg-danger text-white",
                        "Paid" => "bg-success text-white",
                        "Partial" => "bg-danger text-white"
                    ];
                
                    $status_text = [
                        1 => "Paid",
                        0 => "Partial",
                        "Paid" => "Paid",
                        "Partial" => "Partial"
                    ];
                    $status_class = isset($status_classes[$sale->s_status]) ? $status_classes[$sale->s_status] : "bg-success text-white";
                    $status_label = isset($status_text[$sale->s_status]) ? $status_text[$sale->s_status] : "Paid";
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
                                Status: <span class="badge <?= $status_class ?>"> <?= $status_label ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div id="appointmentPopup" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closePopup1()">&times;</span>
        <div class="col-md-6 d-flex flex-column align-items-start" style="height: 100vh; width: 100%;"> 
        <div style="position: sticky; top: 0; z-index: 10; padding: 10px; text-align: center; width: 100%; background: white;">
    <h2 style="font-size: 18px; margin-bottom: 5px;">Appointment List</h2> <!-- Reduce font size -->
</div>

<div style="max-height: calc(100vh - 100px); overflow-y: auto; width: 100%;">  <!-- Reduce max-height here -->
    <?php
    $counter = 0;

    foreach ($appointment_list as $appointment) {
     
        $c = customers::getBy(["c_id" => $appointment->a_customer])[0];
        $u = users::getBy(["u_id" => $appointment->a_attendee])[0] ?? null;
        // $appointment_name = isset($appointment->a_customer->c_name) ? htmlspecialchars($appointment->a_customer->c_name) : "Mr.Hery";
        // $doctor_name = isset($appointment->doctor_name) ? htmlspecialchars($appointment->doctor_name) : "Dr.Hery";
        // $appointment_date = isset($appointment->a_date) ? date("Y-m-d", strtotime($appointment->a_date)) : "-";
        // $booked_time = isset($appointment->a_bookedTime) ? $appointment->a_bookedTime : "-";
        // $status = isset($appointment->a_status) ? $appointment->a_status : 0;
        // $appointment_phone = isset($appointment->a_customer->c_phone) ? htmlspecialchars($appointment->a_customer->c_phone) : '1234567890';
        // $appointment_ic = isset($appointment->a_customer->c_ic) ? htmlspecialchars($appointment->a_customer->c_ic) : '123123';

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
                        <div><strong>Date:</strong> <?= date("d M Y", strtotime($appointment->a_bookedDate)) ?></div>
                        <div><strong>Time:</strong> <?= $appointment->a_bookedTime ?></div>
                    </div>
                </div>
                <div class="col-md-4 p-1 d-flex flex-column justify-content-start text-start">
                    <div><strong>Patient:</strong> <?=$c->c_name?></div>
                    <div><strong>Doctor:</strong> <?= $u ? htmlspecialchars($u->u_name) : "" ?></div>
                    <div>
                        <strong>Status:</strong>
                        <?php
                            switch ($appointment->a_status) {
                                case "1":
                                ?>
                                    <span class="badge badge-success">Approved</span>
                                <?php
                                break;
                                
                                case "0":
                                ?>
                                    <span class="badge badge-warning">Pending</span>
                                <?php
                                break;
                                
                                case "2":
                                ?>
                                    <span class="badge badge-dark">Cancelled</span>
                                <?php
                                break;
                            }
                        ?>
                    </div>
                </div>
                <div class="col-md-4 p-1 d-flex flex-column align-items-start">
                    <div><strong>Phone No:</strong> <?= $c->c_phone ?></div>
                    <div><strong>IC No:</strong> <?= $c->c_ic ?></div>
                </div>
            </div>
        </div>
    </div>
    <?php 
        
    } 
    ?>
   </div> <!-- Closing the max-height div -->
    </div>
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
    overflow: auto; /* Allow scrolling */
    background-color: rgba(0,0,0,0.4);
}

/* Ensure modal content covers full screen */
.modal-content {
    background-color: white;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-height: 80vh; /* Limit height to allow scrolling */
    overflow-y: auto; /* Enable scrolling */
}

/* Optional: Close button styling */
.close {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 30px;
    cursor: pointer;
}

.col-md-6 {
    width: 100%;
}

</style>

