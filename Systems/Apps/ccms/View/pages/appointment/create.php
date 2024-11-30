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
</style>


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
							<input type="text" class="form-control" name="name" placeholder="Name" autofill="off" /><br />
							
							IC / Passport:
							<input type="text" class="form-control" name="ic" placeholder="IC / Passport" value="<?= Input::get("ic") ?>" /><br />
						</div>
						
						<div class="col-md-6">						
							Phone:
							<input type="tel" class="form-control" name="phone" placeholder="+60 1..." /><br />
							
							Email:
							<input type="email" class="form-control" name="email" placeholder="example@abc.com" /><br />
						</div>
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
							<div id="calendar"></div>
							<input type="hidden" name="date" class="form-control" value="<?= date("Y-m-d") ?>" required />
							
							Time:
							<input type="time" name="time" class="form-control" value="<?= date("H:i", F::GetTime()) ?>" required /><br />
							
							Attendee:
							<select class="form-control" name="pic">
								<option value="0">Unset</option>
							<?php
								$q = DB::conn()->query("SELECT * FROM users WHERE u_id IN (SELECT cu_user FROM clinic_user WHERE cu_clinic = ?) AND u_admin = 0", [Session::get("clinic")->c_id])->results();
								
								foreach($q as $s){
								?>
								<option value="<?= $s->u_key ?>"><?= $s->u_name ?></option>
								<?php
								}
							?>
							</select><br />
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

<script>
let calendar = prepareCalendar("#calendar", {
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
			console.log(res);
			
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
</script>