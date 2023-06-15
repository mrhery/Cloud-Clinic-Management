<?php
$date = date("d-M-Y");

if(!empty(Input::get("date"))){
	$date = date("d-M-Y", strtotime(Input::get("date")));
}

?>
<div class="row">
	<div class="col-md-8">
		<div class="row">
			<div class="col-md-6 mb-4">
				<div class="card">
					<div class="card-header">
						<span class="fa fa-calendar"></span> Calendar
					</div>
					
					<div class="card-body">
						<div id="calendarX"></div>
					</div>
				</div>
			</div>
	
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-6 mb-4">
						<div class="card">
							<div class="card-body bg-success text-light">
								<strong>Patients</strong><br />
								<h4 class="text-light"><?= count(customers::list()) ?></h4>
								Total Patients
							</div>
						</div>
					</div>
					
					<div class="col-md-6 mb-4">
						<div class="card">
							<div class="card-body bg-danger text-light">
								<strong>Appointments</strong><br />
								<h4 class="text-light"><?= count(appointments::getBy(["a_date" => date("d-M-Y")])) ?></h4>
								Appointments Today
							</div>
						</div>
					</div>
					
					<div class="col-md-6 mb-4">
						<div class="card">
							<div class="card-body bg-primary text-light">
								<strong>Appointments</strong><br />
								<h4 class="text-light"><?= count(appointments::getBy(["a_date" => date("d-M-Y", strtotime("+1 day"))])) ?></h4>
								Appointments Tomorrow
							</div>
						</div>
					</div>
					
					<div class="col-md-6 mb-4">
						<div class="card">
							<div class="card-body bg-dark text-light">
								<strong>Appointments</strong><br />
								<h4 class="text-light">
								<?php
									$b = strtotime("-3 days");
									$a = strtotime("+3 days");
									$r = DB::conn()->query("SELECT * FROM appointments WHERE a_time > ? AND a_time < ?", [$b, $a])->results();
									echo count($r);
								?>
								</h4>
								Appointments This Week
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<span class="fa fa-list"></span> List of Appointments for <?= $date ?>
					</div>
					
					<div class="card-body">
						<table class="table table-fluid table-hover table-bordered dataTable">
							<thead>
								<tr>
									<th class="text-center" width="5%">No</th>
									<th class="text-center" width="15%">Date / Time</th>
									<th>Detail</th>
									<th class="text-right" width="15%">:::</th>
								</tr>
							</thead>
							
							<tbody>
							<?php
								$no = 1;
								foreach(appointments::getBy(["a_date" => $date]) as $a){
								?>
								<tr>
									<td class="text-center"><?= $no++ ?></td>
									<td class="text-center"><?= date("d M Y H:i:s\ ", $a->a_time) ?></td>
									<td>
									<?php										
										$c = customers::getBy(["c_id" => $a->a_customer]);
										
										if(count($c) > 0){
											$c = $c[0];
										?>
											<strong>Patient:</strong><br />
											<?= $c->c_name ?> (<?= $c->c_ic ?>)<br /><br />
											
											<strong>Appointment:</strong><br />
											<?= $a->a_reason ?><br />
											
											<?php
												switch($a->a_status){
													case "1": 
														echo "<span class='badge badge-success'>Approved</span>"; 
													break;
													
													case "0": 
														echo "<span class='badge badge-warning'>Pending</span>"; 
													break;
													
													case "2": 
														echo "<span class='badge badge-danger'>Cancelled</span>"; 
													break;
												}
											?>
										<?php
										}else{
											echo "Information not found";
										}
									?>
									</td>
									<td class="text-right">
										<a href="<?= PORTAL ?>appointments/edit/<?= $a->a_ukey ?>" class="btn btn-primary btn-sm">
											<span class="fa fa-eye"></span>  View
										</a>
									</td>
								</tr>
								<?php
								}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div id="chartContainer" style="height: 370px; width: 100%;"></div>
			</div>
		</div>
	</div>
</div>

<?php
$selectedDate = date("Y-m-d", strtotime($date));

Page::append(<<<HTML
<script>
var calendar = new FullCalendar.Calendar($("#calendarX")[0], {
	initialView: 'dayGridMonth',
	eventClick: function(info) {
		console.log(info);
	}
});

calendar.render();

$(document).on("click", ".fc-day", function(){
	var selectedDate = $(this).data("date");
	
	$(".fc-day").removeClass("bg-info");
	$(this).addClass("bg-info");
	
	window.location = PORTAL + "dashboard?date=" + selectedDate;
});

setTimeout(function(){
	$(".fc-day[data-date=$selectedDate]").addClass("bg-info");
}, 1500);

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Appointments Thru the Week"
	},
  	axisY: {
      includeZero: true
    },
	data: [{
		type: "column", //change type to bar, line, area, pie, etc
		//indexLabel: "{y}", //Shows y value on all Data Points
		indexLabelFontColor: "#5A5757",
      	indexLabelFontSize: 16,
		indexLabelPlacement: "outside",
		dataPoints: [
			{ x: 10, y: 71, indexLabel: "Monday" },
			{ x: 20, y: 55, indexLabel: "Teusday" },
			{ x: 30, y: 50, indexLabel: "Wednesday" },
			{ x: 40, y: 65, indexLabel: "Thursday" },
			{ x: 50, y: 92, indexLabel: "Friday" },
			{ x: 60, y: 68, indexLabel: "Saturday" },
			{ x: 70, y: 38, indexLabel: "Sunday" },
		]
	}]
});
chart.render();


</script>
HTML
);
