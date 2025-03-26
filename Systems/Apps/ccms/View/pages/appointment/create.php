<style>
			#ic-search-list {
				display: none;
				position: absolute;
				background-color: #363636;
				width: 95%;
				overflow-y: auto;
				z-index: 1;
			}

			.ic-list-item {
				color: white;
				padding: 10px;
				cursor: pointer;
				font-size: 9pt;
			}

			.ic-list-item:hover {
				background-color: black;
			}

			.btn-container {
				margin-top: 10px;
			}

			.timepicker-container { 
				width: 450px; /* Adjust as needed */
				height: 390px; /* Increase height */
				text-align: center;
				display: flex;
				flex-direction: column;
				justify-content: center; /* Center content vertically */
				align-items: center; /* Center content horizontally */
				margin: 0 auto; /* Center within the parent container */
			}

			.timepicker {
				display: flex;
				justify-content: center;
				align-items: center;
				width: 100%;
				padding: 20px;
				border: 1px solid #ccc;
				border-radius: 5px;
				background-color: #f9f9f9;
				min-height: 200px;
			}

			.timepicker div {
				display: flex;
				flex-direction: column;
				align-items: center;
				min-width: 60px; /* Increase minimum width */
			}

			.timepicker span {
				font-size: 22px; /* Increase font size */
				font-weight: bold;
			}

			.arrow {
				cursor: pointer;
				font-size: 30px; /* Increase arrow size */
				user-select: none;
			}

			.selected-time {
				margin-top: 20px; /* Increase spacing */
				font-weight: bold;
				font-size: 18px;
			}
			.input {
			padding: 5px;
			text-align: left; /* or center/right as needed */
			vertical-align: middle;
			}
</style>





<!-- <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="assets/timepicker.css"> -->
<?php
Controller::alert();
?>

<body>
<h3>Create appointment</h3>
<form autocomplete="off" method="POST">
	<div id="accordion" class="mb-3">
		<div class="card">
			<div class="card-header">
				<a class="card-link" data-toggle="collapse" href="#select-customer">
					1. Select Customer Information
				</a>
			</div>
				
			<div id="select-customer" class="collapse show" data-parent="#accordion">
				<div class="card-body p-2">
					<div class="row">
						<div class="col-md-6">
							<div class="input-group mb-3">
								<input type="text" autofocus class="form-control" id="search-ic" name="search-ic" placeholder="Keywords..."/>
								
								<div class="input-group-append">
									<button class="btn btn-outline-primary" id="btn-customer-search" type="button"><span class="fa fa-search"></span> Search</button>
									<button class="btn btn-outline-danger" id="btn-customer-reset" type="button" style="display: none;"><span class="fa fa-close"></span> Reset</button>
								</div>
							</div>
							
							<div id="ic-search-list"></div>
						</div>
						
						<div class="col-md-6"></div>
						
						<div class="col-md-6">
							<div class="form-group">
								<label for="name">Name:</label>
								<input type="text" class="form-control text-left" name="name" id="name" placeholder="Name" value="<?= Input::get("name") ?>" />
							</div>

							<div class="form-group">
								<label for="ic">IC / Passport:</label>
								<input type="text" class="form-control text-left" name="ic" id="ic" placeholder="IC / Passport" value="<?= Input::get("ic") ?>" />
							</div>
						</div>
						
						<!-- <div class="col-md-6">						
							Phone:
							<input type="tel" class="form-control" name="phone" placeholder="+60 1..." /><br />
							
							Email:
							<input type="email" class="form-control" name="email" placeholder="example@abc.com" /><br />
						</div> -->
					</div>
					
					<div class="row">
						<div class="col-6 text-right">
						</div>
						
						<div class="col-6 text-right">
							<button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" href="#select-appointment">
								Next <span class="fa fa-arrow-right"></span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="card">
			<div class="card-header">
				<a class="collapsed card-link" data-toggle="collapse" href="#select-appointment">
					2. Appointment
				</a>
			</div>
			
			<div id="select-appointment" class="collapse" data-parent="#accordion">
				<div class="card-body p-2">
					<div class="row">
						<div class="col-md-6">
							Clinic:
							<select class="form-control" name="clinic">
							
							<?php
								$q = DB::conn()->query("SELECT * FROM clinics WHERE c_id IN (SELECT cu_clinic FROM clinic_user WHERE cu_user = ?)", [Session::get("user")->u_id])->results();
								
								foreach($q as $s){
								?>
								<option value="<?= $s->c_ukey ?>"><?= $s->c_name ?></option>
								<?php
								}
							?>
							</select><br />
							
							Doctor:
							<select class="form-control" name="pic"> 
								<?php
									foreach (users::list() as $user) {
										if ($user->u_role == 2) { // Check if user role is Doctor
								?>
											<option value="<?= $user->u_id ?>">
												<?= $user->u_name ?>
											</option>
								<?php
										}
									}
								?>
							</select>
							<div id="calendar"></div>
							<input type="hidden" name="date" class="form-control" value="<?= date("Y-m-d") ?>" required />
							
							<div class="timepicker-container">
								<label><strong>Timepicker</strong></label>
								<div class="timepicker">
									<div>
										<div class="arrow" onclick="changeTime('hour', 1)">▲</div>
										<span id="hour">11</span>
										<div class="arrow" onclick="changeTime('hour', -1)">▼</div>
									</div>
									<span>:</span>
									<div>
										<div class="arrow" onclick="changeTime('minute', 1)">▲</div>
										<span id="minute">32</span>
										<div class="arrow" onclick="changeTime('minute', -1)">▼</div>
									</div>
									<div>
										<div class="arrow" onclick="changeTime('ampm', 1)">▲</div>
										<span id="ampm">PM</span>
										<div class="arrow" onclick="changeTime('ampm', -1)">▼</div>
									</div>
								</div>
								<!-- <div class="selected-time">Selected Time: <span id="selectedTime">11:32 PM</span></div> -->
							</div>
				
						</div>
						
						<div class="col-md-6">
							<table class="table table-hover table-fluid">
								<tbody id="date-appointment">
									<tr>
										<td class="text-center"><i>Please select a date</i></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					
					<div class="row">
						<div class="col-6 text-left">
							<button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" href="#select-customer">
								<span class="fa fa-arrow-left"></span> Prev 
							</button>
						</div>
						
						<div class="col-6 text-right">
							<button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" href="#select-appointment-detail">
								Next <span class="fa fa-arrow-right"></span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="card">
			<div class="card-header">
				<a class="collapsed card-link" data-toggle="collapse" href="#select-appointment-detail">
					3. Appointment Detail
				</a>
			</div>
			
			<div id="select-appointment-detail" class="collapse" data-parent="#accordion">
				<div class="card-body p-2">
					<div class="row">
						<div class="col-md-6">
							Status:
							<select class="form-control" name="status">
								<option value="0">Pending</option>
								<option value="1" selected>Approved</option>
								<option value="2">Cancelled</option>
							</select><br />
						</div>
						
						<div class="col-md-6">
							Description:
							<textarea class="form-control" name="reason" autofocus placeholder="Description"></textarea><br />
						</div>
					</div>
					
					<div class="row">
						<div class="col-6 text-left">
							<button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" href="#select-appointment">
								<span class="fa fa-arrow-left"></span> Prev 
							</button>
						</div>
						
						<div class="col-6 text-right">
							<button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" href="#select-history">
								Next <span class="fa fa-arrow-right"></span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="card">
			<div class="card-header">
				<a class="collapsed card-link" data-toggle="collapse" href="#select-history">
					4. Visit History (optional)
				</a>
			</div>
			
			<div id="select-history" class="collapse" data-parent="#accordion">
				<div class="card-body p-2">
					<table class="table table-hover table-fluid table-bordered">					
						<tbody id="visit-history">
							<tr>
								<td class="text-center"><i>No Record</i></td>
							</tr>
						</tbody>
					</table>
					
					<div class="row">
						<div class="col-6 text-left">
							<button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" href="#select-appointment-detail">
								<span class="fa fa-arrow-left"></span> Prev 
							</button>
						</div>
						
						<div class="col-6 text-right">
							<button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" href="#select-billing">
								Next <span class="fa fa-arrow-right"></span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>	
		
		<div class="card">
			<div class="card-header">
				<a class="collapsed card-link" data-toggle="collapse" href="#select-billing">
					5. Billing Information (optional)
				</a>
			</div>
			
			<div id="select-billing" class="collapse" data-parent="#accordion">
				<div class="card-body p-2">
					<table class="table table-hover table-fluid table-bordered">					
						<tbody id="billing-history">
							<tr>
								<td class="text-center"><i>No Record</i></td>
							</tr>
						</tbody>
					</table>
					
					<div class="row">
						<div class="col-6 text-left">
							<button type="button" class="btn btn-sm btn-primary" data-toggle="collapse" href="#select-history">
								<span class="fa fa-arrow-left"></span> Prev 
							</button>
						</div>
						
						<div class="col-6 text-right"></div>
					</div>
				</div>
			</div>
		</div>
	</div> 

	<div class="text-center">
		<?php
			Controller::form("appointment", [
				"action"	=> "create"
			]);
		?>
		<a href="<?= PORTAL ?>pages/appointment/preview/" class="btn btn-success btn-info usp-popup-window">
			<span class="fa fa-rocket"></span> Preview
		</a>
	</div>
</form>
</body>


<script>
	let searchTimeout;
$(document).on("keyup", "#search-ic", function() {
	clearTimeout(searchTimeout);
    let skey = $(this).val().trim();
    
    if (skey.length < 3) { // Reduce unnecessary calls
        $("#ic-search-list").hide();
        return;
    }

	searchTimeout = setTimeout(() => {
        $("#ic-search-list").show();
        $.ajax({
            url: PORTAL + "webservice/customers/search",
            method: "POST",
            data: { action: "search", skey: skey },
            dataType: "text"
        }).done(function(res) {
            try {
                let o = JSON.parse(res);
                $("#ic-search-list").html(""); // Clear previous results
                
                if (o.status === "success" && o.data && Array.isArray(o.data) && o.data.length > 0) {
                    o.data.forEach(function(c) {
                        $("#ic-search-list").append(`
                            <div class="ic-list-item" data-id="${c.id}">
                                <strong>${c.name} (${c.ic})</strong><br />
                                ${c.phone} <br /> ${c.email}
                            </div>
                        `);
                    });
                } else {
                    $("#ic-search-list").html('<div class="ic-list-item">No results found</div>');
                }
            } catch (error) {
                console.error("Invalid JSON response", error);
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error:", textStatus, errorThrown);
        });
    }, 300);
});

var calendar = prepareCalendar("#calendar", {
	singleDate: true,
	onSelectDate: function(date, selected_dates){
		$("[name=date]").val(selected_dates.join(","));
		
		$.ajax({
			method: "POST",
			url: PORTAL + "webservice/appointment/date",
			data: {
				date: selected_dates.join(",")
			},
			dataType: "text"
		}).done(function(res){
			// console.log(res);
			
			res = JSON.parse(res);
			$("#date-appointment").html("");
			
			if(res.status == "success"){
				if(res.data.length > 0){
					
					res.data.forEach(function(a){
						let badgeStatus = "dark";
						let statusText = "Cancelled";
						
						switch(a.status){
							case 0:
								badgeStatus = "warning";
								statusText = "Pending";
							break;
							
							case 1:
								badgeStatus = "success";
								statusText = "Approved";
							break;
							
							case 2:
								badgeStatus = "dark";
								statusText = "Cancelled";
							break;
						}
						
						$("#date-appointment").append('\
							<tr>\
								<td class="p-2">\
									<b>'+ a.bookedTime +'</b> '+ a.customer +'<br />\
									<b>Attendee: </b> '+ a.attendee +'<br />\
									registered on '+ a.a_date +' | <span class="badge badge-'+ badgeStatus +'">'+ statusText +'</span>\
								</td>\
							</tr>\
						');
					});
				}else{
					$("#date-appointment").html('\
						<tr>\
							<td class="text-center"><i>No appointment</i></td>\
						</tr>\
					');
				}
			}
		});
	}
});
calendar.manipulate();

function changeTime(type, delta) {
    let hourElem = document.getElementById("hour");
    let minuteElem = document.getElementById("minute");
    let ampmElem = document.getElementById("ampm");
    let selectedTimeElem = document.getElementById("selectedTime");

    let hour = parseInt(hourElem.innerText);
    let minute = parseInt(minuteElem.innerText);
    let ampm = ampmElem.innerText;

    if (type === "hour") {
        hour += delta;
        if (hour < 1) hour = 12; // Wrap around
        if (hour > 12) hour = 1;  // Wrap around
    } else if (type === "minute") {
        minute += delta * 30;
        if (minute >= 60) {
            minute = 0;
            hour += 1;
        } else if (minute < 0) {
            minute = 30;
            hour -= 1;
        }
        if (hour < 1) hour = 12;
        if (hour > 12) hour = 1;
    } else if (type === "ampm") {
        ampm = (ampm === "AM") ? "PM" : "AM";
    }

    hourElem.innerText = hour;
    minuteElem.innerText = minute.toString().padStart(2, '0');
    ampmElem.innerText = ampm;
    selectedTimeElem.innerText = `${hour}:${minute.toString().padStart(2, '0')} ${ampm}`;
}



	$(document).on("click", ".ic-list-item", function() {
		var customerId = $(this).data("id");
		var customerName = $(this).text().split(" (")[0].trim();
		var matchIC = $(this).text().match(/\(([^)]+)\)/);
		var customerIC = matchIC ? matchIC[1] : "";

		$("input[name='name']").val(customerName);
		$("input[name='ic']").val(customerIC);

		$("#ic-search-list").hide();
	});
</script>





