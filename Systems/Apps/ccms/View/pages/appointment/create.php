<style>
#ic-search-list {
	display: none;
	position: absolute; 
	background-color: #363636; 
	width: 95%; 
	overflow-y: auto;
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

<div class="card">
	<div class="card-header">
		<a href="<?= PORTAL ?>appointments" class="btn btn-sm btn-primary mr-2">
			<span class="fa fa-arrow-left"></span> Back
		</a>
		
		Create new Appointments
	</div>
	
	<div class="card-body">
	<?php
		if(!isset($_GET["ic"])){
		?>
		<h4>Customer Info</h4>
		<div class="row">
			<div class="col-md-6">
				<div class="card mb-2">
					<div class="card-header">
						<span class="fa fa-search"></span> Search Customer
					</div>
					
					<div class="card-body">
						<form action="" method="GET">
							<input type="text" autofocus class="form-control" id="search-ic" name="ic" placeholder="Keywords..." />
							
							<div id="ic-search-list"></div>
						</form>
					</div>
				</div>
			</div>
		</div>
		
		<?php
		}else{
			$c = customers::getBy(["c_ic" => Input::get("ic")]);
		?>
		<form action="" method="POST">
			<div class="row">
				<div class="col-md-6 mb-2">
					<h4>Customer Info</h4>
					
					<div class="card mb-3">
						<div class="card-header">
							<span class="fa fa-search"></span> Search Customer
						</div>
						
						<div class="card-body">
							<form action="" method="GET">
								<div class="input-group mb-3">
									<input disabled type="text"  class="form-control" id="search-ic" name="ic" value="<?= Input::get("ic") ?>" placeholder="Keywords..." />
									
									<div class="input-group-append">
										<a class="btn btn-danger" href="<?= PORTAL ?>appointments/create"> 
											<span class="fa fa-close"></span> Clear
										</a>
									</div>
								</div>
							</form>
						</div>
					</div>
					
				<?php
					if(count($c) > 0){
						$c = $c[0];
				?>
					Name:
					<input type="text" class="form-control" name="name" placeholder="Name" value="<?= $c->c_name ?>" required /><br />
					
					IC / Passport:
					<input type="text" class="form-control" name="ic" placeholder="IC / Passport" readonly value="<?= $c->c_ic ?>" value="<?= Input::get("ic") ?>" required /><br />
					
					Address:
					<textarea class="form-control" name="address" placeholder="Address"><?= $c->c_address ?></textarea><br />
					
					Phone:
					<input type="tel" class="form-control" name="phone" placeholder="+60 1..." value="<?= $c->c_phone ?>" /><br />
					
					Email:
					<input type="email" class="form-control" name="email" placeholder="example@abc.com" value="
					<?= $c->c_email ?>" /><br />
				<?php
					}else{
						new Alert("info", "New customer registration.");
				?>
					Name:
					<input type="text" class="form-control" name="name" placeholder="Name" autofocus required /><br />
					
					IC / Passport:
					<input type="text" class="form-control" name="ic" placeholder="IC / Passport" value="<?= Input::get("ic") ?>" required /><br />
					
					Address:
					<textarea class="form-control" name="address" placeholder="Address"></textarea><br />
					
					Phone:
					<input type="tel" class="form-control" name="phone" placeholder="+60 1..." /><br />
					
					Email:
					<input type="email" class="form-control" name="email" placeholder="example@abc.com" /><br />
				<?php
					}
				?>
				</div>
				
				<div class="col-md-6 mb-2">
					<h4>Appointment Description</h4>
					
					Description:
					<textarea class="form-control" name="reason" autofocus placeholder="Description: Fever, cough, covid test, vaccine" required></textarea>
					<br />
					
					Date:
					<input type="date" name="date" class="form-control" value="<?= date("Y-m-d") ?>" required /><br />
					
					Time:
					<input type="time" name="time" class="form-control" value="<?= date("H:i", F::GetTime()) ?>" required /><br />
					
					Status:
					<select class="form-control" name="status">
						<option value="0">Pending</option>
						<option value="1">Approved</option>
						<option value="2">Cancelled</option>
					</select><br />
					
					Note:
					<input type="text" class="form-control" name="note" placeholder="Notes" /><br />
				</div>
				
				<div class="col-md-12 text-center">
					<button class="btn btn-success">
						<span class="fa fa-save"></span> Confirm & Save Appointment
					</button>
					
				<?php
					Controller::form("appointment",
					[
						"action"	=> "create"
					]);
				?>
				</div>
			</div>
		</form>
		<?php
		}
	?>
		
		
	</div>
</div>

<?php
Page::append(<<<HTML
<script>
$("#search-ic").on("keyup", function(){
	var skey = $(this).val();
	$("#ic-search-list").show();
	
	$.ajax({
		url: PORTAL + "webservice/customers",
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
				$("#ic-search-list").append('\
					<div class="ic-list-item" data-ic="'+ c.ic +'">\
						<strong>'+ c.name +' ('+ c.ic +')</strong><br />\
						'+ c.phone +' <br /> '+ c.email +'\
					</div>\
				');
			});
		}
	});
});

$(document).on("click", ".ic-list-item", function(){
	var ic = $(this).data("ic");
	
	window.location = PORTAL + "appointments/create?ic=" + ic;
});
</script>
HTML
);