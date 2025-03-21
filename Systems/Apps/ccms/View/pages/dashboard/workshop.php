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
                <h4><?= count($customer_list) ?></h4>
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
    
    <div style="max-height: 700px; padding-right: 10px; width: 100%;"> 
        <!-- Scrollable container -->
      
    <?php
        $counter = 0;

        foreach ($sales_dashboard as $sale) {
            if ($counter >= 3) break;
            $status = $sale->s_status; 
    ?>
<div class="card mb-2" style="min-height: 110px; display: flex;">
    <div class="card-body p-2">
        <div class="row">
            <div class="col-7">
                Doc No: <?= $sale->s_doc ?><br />
                Patient: 
                <?php
                $c = customers::getBy(["c_id" => $sale->s_client]);
                if(count($c) > 0){
                    $c = $c[0];
                ?>
                    <?= $c->c_name ?><br />
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
                    <?php
                        if ($status == "paid") {
                            echo '<span class="badge bg-success text-white d-inline-block">Paid</span>';
                        } else if ($status == "partial"){
                            echo '<span class="badge bg-warning text-dark d-inline-block">Partial</span>';
                        } else {
                            echo 'Unpaid';
                        }
                    ?>
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
                <button data-toggle="modal" data-target="#salesPopup" class="btn btn-sm btn-primary" title="">
                        See more 
                </button>
            </div>
        <?php endif; ?>
    </div>
</div>



    <!-- Appointments Section -->
    <div class="col-md-6 d-flex flex-column" style="height: 100vh;"> <!-- Reduce the height here -->

    <div style="position: sticky; top: 0; z-index: 10; padding: 10px; text-align: center; width: 100%;">
    <h2 style="font-size: 18px; margin-bottom: 5px;">Appointment List</h2> <!-- Reduce font size -->
</div>

<div style="max-height: 1000px; overflow-y: auto;"> <!-- Reduce max-height here -->
    <?php
    
    foreach ($appointment_list as $appointment) {
       
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
   <div class="card mb-2" style="padding: 8px;">
    <div class="card-body p-2">
        <div class="row align-items-start"> <!-- Align items to the top -->
            <div class="col-md-4 p-1 text-start">
                <div class="h-100" 
                    style="border-right: 2px solid black; margin-right: 50px;">
                    <div>Date: <?= date("d M Y", strtotime($appointment->a_bookedDate . " " . $appointment->a_bookedTime)) ?></div>
                    <div>Time: <?= date("H:i:s\ ", strtotime($appointment->a_bookedDate . " " . $appointment->a_bookedTime)) ?></div>
                </div>
            </div>
            <div class="col-md-4 p-1 text-start">
                <div>Patient:  
                    <?php
                    $c = customers::getBy(["c_id" => $appointment->a_customer]);
                    if(count($c) > 0){
                        $c = $c[0];
                    ?>
                        <?= $c->c_name ?> (<?= $c->c_ic ?>)<br />
                    <?php
                    } else {
                        unset($c);
                        echo "-";
                    }
                    ?> 
                </div>

                <div>Doctor: 
                    <?php
                    $u = users::getBy(["u_id" => $appointment->a_attendee]);
                    if(count($u) > 0){
                        $u = $u[0];
                    ?>
                        <?= $u->u_name ?> <br />
                    <?php
                    } else {
                        unset($u);
                        echo "Unset";
                    }
                    ?>
                </div>
                <div>
                    Status:
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
            <div class="col-md-4 p-1 text-start">
                <div>Phone No: <?= $c->c_phone ?></div>
            </div>
        </div>
    </div>
</div>
    <?php 
        // $counter++;
    } 
    ?>
   </div> <!-- Closing the max-height div -->


            <div style="text-align: center; padding: 5px;">
                <button data-toggle="modal" data-target="#appointmentPopup" class="btn btn-sm btn-primary" title="">
                        See more 
                </button>
            </div>
    
    </div>
</div>
</div>

<div class="modal fade" id="salesPopup">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <span class="fa fa-file-o"></span> Daily Sales
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div style="max-height: calc(100vh - 100px); overflow-y: auto; width: 100%;"> 
                    <?php
                    if (!empty($sales_dashboard)) {
                        echo "<!-- Debug: Total Sales Found - " . count($sales_dashboard) . " -->";
                        foreach ($sales_dashboard as $sale) {
                            // Debugging output
                            echo "<!-- Debug: Raw Status - " . var_export($sale->s_status, true) . " -->";
                            
                            // Ensure status is correctly interpreted
                            $status = (string) trim($sale->s_status);
                    ?>
                    <div class="card mb-3" style="min-height: 110px; display: flex;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7">
                                    Doc No: <?= htmlspecialchars($sale->s_doc) ?><br />
                                    Patient: 
                                    <?php
                                    $c = customers::getBy(["c_id" => $sale->s_client]);
                                    if (!empty($c)) {
                                        $c = $c[0];
                                    ?>
                                        <?= htmlspecialchars($c->c_name) ?><br />
                                    <?php
                                    } else {
                                        echo "-";
                                    }
                                    ?>   
                                    Total: <?= number_format($sale->s_total, 2) ?>
                                </div>
                                <div class="col-5 text-end">
                                    <span>Date: <?= date("d M Y", strtotime($sale->s_date)) ?></span><br />
                                    Status:  
                                    <?php
                                    if ($status == "paid") {
                                        echo '<span class="badge bg-success text-white d-inline-block">Paid</span>';
                                    } else if ($status == "partial"){
                                        echo '<span class="badge bg-warning text-dark d-inline-block">Partial</span>';
                                    } else {
                                        echo 'Unpaid';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                        }
                    } else {
                        echo "<p>No sales data available.</p>";
                    }
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


    <div class="modal fade" id="appointmentPopup">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">
						<span class="fa fa-file-o"></span> Appointment List
					</h4>
					
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<div class="modal-body">
                <div style="max-height: calc(100vh - 100px); overflow-y: auto; width: 100%;"> 
                <!-- Scrollable container -->
              
                <?php
                $counter = 0;

                foreach ($appointment_list as $appointment) {

                    $customer = customers::getBy(["c_id" => $appointment->a_customer]);
                    $user = users::getBy(["u_id" => $appointment->a_attendee]);

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
     <div class="card mb-2" style="padding: 8px;">
    <div class="card-body p-2">
        <div class="row align-items-start"> <!-- Align items to the top -->
            <div class="col-md-4 p-1 text-start position-relative">
                <div class="h-100" 
                    style="border-right: 2px solid black; margin-right: 50px;">
                    <div>Date: <?= date("d M Y", strtotime($appointment->a_bookedDate . " " . $appointment->a_bookedTime)) ?></div>
                    <div>Time: <?= date("H:i:s\ ", strtotime($appointment->a_bookedDate . " " . $appointment->a_bookedTime)) ?></div>
                </div>
            </div>
            <div class="col-md-4 p-1 text-start">
                <div>Patient:  
                    <?php
                    $c = customers::getBy(["c_id" => $appointment->a_customer]);
                    if(count($c) > 0){
                        $c = $c[0];
                    ?>
                        <?= $c->c_name ?> (<?= $c->c_ic ?>)<br />
                    <?php
                    } else {
                        unset($c);
                        echo "-";
                    }
                    ?> 
                </div>

                <div>Doctor: 
                    <?php
                    $u = users::getBy(["u_id" => $appointment->a_attendee]);
                    if(count($u) > 0){
                        $u = $u[0];
                    ?>
                        <?= $u->u_name ?> <br />
                    <?php
                    } else {
                        unset($u);
                        echo "Unset";
                    }
                    ?>
                </div>
                <div>
                    Status:
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
            <div class="col-md-4 p-1 text-start">
                <div>Phone No: <?=  $c->c_phone ?></div>
            </div>
        </div>
    </div>
</div>
                <?php } ?>
            </div>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
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

<script>
document.getElementById("seeMore").addEventListener("click", function() {
    fetch("<?= PORTAL ?>ajax/get-full-sales-list.php")
    .then(response => response.text())
    .then(data => {
        document.getElementById("salesTable").getElementsByTagName('tbody')[0].innerHTML = data;
        document.getElementById("seeMore").style.display = "none";
    });
});
</script>

<style>

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

