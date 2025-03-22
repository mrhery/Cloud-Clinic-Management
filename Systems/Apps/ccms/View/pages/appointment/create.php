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

		.timepicker-container {
            max-width: 300px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .btn-container {
            margin-top: 10px;
        }
        .selected-time {
            font-size: 20px;
            font-weight: bold;
            margin-top: 10px;
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
								<input type="text" autofocus class="form-control" id="search-ic" name="search-ic" placeholder="Keywords..." autofill="off" />
								
								<div class="input-group-append">
									<button class="btn btn-outline-primary" id="btn-customer-search" type="button"><span class="fa fa-search"></span> Search</button>
									<button class="btn btn-outline-danger" id="btn-customer-reset" type="button" style="display: none;"><span class="fa fa-close"></span> Reset</button>
								</div>
							</div>
							
							<div id="ic-search-list"></div>
						</div>
						
						<div class="col-md-6"></div>
						
						<div class="col-md-6">
							<input type="hidden" name="c_id" />
							Name:
							<input type="text" class="form-control" name="name" placeholder="Name" autofill="off" value="<?= Input::get("name") ?>" /><br />
							
							IC / Passport:
							<input type="text" class="form-control" name="ic" placeholder="IC / Passport" value="<?= Input::get("ic") ?>" /><br />
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
									foreach (roles::list() as $role) {
										if ($role->r_name == "Doctor") { // Filter only Doctor role
								?>
											<option value="<?= $role->r_id ?>">
												<?= $role->r_name ?>
											</option>
								<?php
										}
									}
								?>
							</select>
							<div id="calendar"></div>
							<input type="hidden" name="date" class="form-control" value="<?= date("Y-m-d") ?>" required />
							
							<form id="timeForm" method="POST" action="save_time.php">
							<div class="timepicker-container">
								<label><strong>Enter Time</strong></label>
								<div class="form-row">
									<div class="col">
										<select id="hour" class="form-control"></select>
									</div>
									<div class="col">
										<select id="minute" class="form-control">
											<option value="00">00</option>
											<option value="30">30</option>
										</select>
									</div>
									<div class="col">
										<select id="ampm" class="form-control">
											<option value="AM">AM</option>
											<option value="PM">PM</option>
										</select>
									</div>
								</div>
								<div class="btn-container">
									<button type="button" id="now" class="btn btn-primary">Now</button>
									<button type="button" id="clear" class="btn btn-danger">Clear</button>
								</div>
								<div class="selected-time">Selected Time: <span id="selectedTime">--:-- --</span></div>
								<input type="hidden" name="a_bookedTime" id="a_bookedTime" />
							</div>
						</form>
				
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
		<button class="btn btn-success">
			<span class="fa fa-rocket"></span> Submit
		</button>
	</div>
</form>
</body>


<script>
	$(document).on("keyup", "#search-ic", function(){
    var skey = $(this).val();
    $("#ic-search-list").show();

    $.ajax({
        url: PORTAL + "webservice/customers/search",
        method: "POST",
        data: {
            action: "search",
            skey: skey
        },
        dataType: "text"
    }).done(function(res){
        var o = JSON.parse(res);

        if(o.status == "success"){
            $("#ic-search-list").html("");

            o.data.forEach(function(c){
                $("#ic-search-list").append(`
                    <div class="ic-list-item" data-id="${c.id}">
                        <strong>${c.name} (${c.ic})</strong><br />
                        ${c.phone} <br /> ${c.email}
                    </div>
                `);
            });
        }
    });
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

$(document).ready(function () {
    // Populate hours from 1 to 12 without leading zeros
    for (let i = 1; i <= 12; i++) {
        $("#hour").append(`<option value="${i}">${i}</option>`);
    }

    // Update selected time function
	function updateTime() {
    let hour = parseInt($('#hour').val(), 10);
    let minute = $('#minute').val();
    let ampm = $('#ampm').val();

    // Convert 12-hour format to 24-hour format
    if (ampm === 'PM' && hour !== 12) {
        hour += 12;
    } else if (ampm === 'AM' && hour === 12) {
        hour = 0;
    }

    // Format hour and minute with leading zeros
    let formattedHour = String(hour).padStart(2, '0');
    let formattedMinute = String(minute).padStart(2, '0');

    $("#selectedTime").text(`${formattedHour}:${formattedMinute}`);
    $("#time").val(`${formattedHour}:${formattedMinute}`); // Store in 24-hour format
}

    $("select").change(updateTime);

    // Set to current time
    $('#now').click(function (event) {
        event.preventDefault(); // Prevents form submission if inside a form

        let now = new Date();
        let hours24 = now.getHours();
        let minutes = now.getMinutes();
        let ampm = hours24 >= 12 ? 'PM' : 'AM';

        // Convert 24-hour format to 12-hour format
        let hours12 = hours24 % 12 || 12; // 0 or 12 should be converted to 12 AM/PM
        minutes = minutes >= 30 ? '30' : '00'; // Round minutes to 00 or 30

        // Update dropdown values
        $('#hour').val(hours12);
        $('#minute').val(minutes);
        $('#ampm').val(ampm);

        // Manually trigger change to update display
        updateTime();
    });

    // Clear selection
		$('#clear').click(function (event) {
			event.preventDefault(); // Prevents unintended navigation

			$('#hour').prop('selectedIndex', 0);
			$('#minute').prop('selectedIndex', 0);
			$('#ampm').prop('selectedIndex', 0);

			$('#selectedTime').text('--:-- --');
			$('#time').val('');
		});
});

		$(document).on("click", ".ic-list-item", function(){
			var customerId = $(this).data("id");
			var customerName = $(this).text().split(" (")[0]; // Extracts name
			var customerIC = $(this).text().match(/\(([^)]+)\)/)[1]; // Extracts IC from parentheses

			// Assign values to text fields
			$("input[name='name']").val(customerName);
			$("input[name='ic']").val(customerIC);

			// Hide search list
			$("#ic-search-list").hide();
		});
</script>





