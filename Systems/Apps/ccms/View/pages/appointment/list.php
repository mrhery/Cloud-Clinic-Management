<?php
$show = input::get("show");

if(empty($show)){
	$show = "today";
}
?>
<div class="card">
	<div class="card-header">
		<span class="fa fa-calendar"></span> Appointments 
		
		<a href="<?= PORTAL ?>appointments/create" class="btn btn-sm btn-primary">
			<span class="fa fa-plus"></span> Create new Appointment
		</a>
	</div>
	
	<div class="card-body">
		<div class="mb-3">
			<a class="btn btn-sm btn-<?= $show == "today" ? "dark" : "secondary" ?>" href="<?= PORTAL ?>appointments?show=today">
				Today
			</a>
			
			<a class="btn btn-sm btn-<?= $show == "now" ? "dark" : "secondary" ?>" href="<?= PORTAL ?>appointments?show=now">
				Now
			</a>
			
			<a class="btn btn-sm btn-<?= $show == "tomorrow" ? "dark" : "secondary" ?>" href="<?= PORTAL ?>appointments?show=tomorrow">
				Tomorrow
			</a>
			
			<a class="btn btn-sm btn-<?= $show == "week" ? "dark" : "secondary" ?>" href="<?= PORTAL ?>appointments?show=week">
				This Week
			</a>
			
			<a class="btn btn-sm btn-<?= $show == "month" ? "dark" : "secondary" ?>" href="<?= PORTAL ?>appointments?show=month">
				This Month
			</a>
			
			<a class="btn btn-sm btn-<?= $show == "year" ? "dark" : "secondary" ?>" href="<?= PORTAL ?>appointments?show=year">
				This Year
			</a>
			
			<a class="btn btn-sm btn-<?= $show == "pending" ? "dark" : "secondary" ?>" href="<?= PORTAL ?>appointments?show=pending">
				Pending
			</a>
			
			
		</div>
		
		<table class="table dataTable table-hover">
			<thead>
				<tr>
					<th class="text-center" width="3%">No</th>
					<th class="text-center" width="7%">Datetime</th>
					<th class="">Appointment</th>
					<th class="text-center" width="5%">Status</th>
					<th class="text-right" width="7%">:::</th>
				</tr>
			</thead>
			
			<tbody>
			<?php
				$no = 1;
				
				switch($show){
					case "today":
						$r = Session::get("admin") ? appointments::getBy(["a_date" => date("d-M-Y")]) : appointments::getBy(["a_date" => date("d-M-Y"), "a_clinic" => Session::get("clinic")->c_id]);
					break;
					
					case "now":
						$b = strtotime("-2 hours");
						$a = strtotime("+2 hours");
						
						if(Session::get("admin")){
							$r = DB::conn()->query("SELECT * FROM appointments WHERE a_time > ? AND a_time < ?", [$b, $a])->results();
						}else{
							$r = DB::conn()->query("SELECT * FROM appointments WHERE a_time > ? AND a_time < ? AND a_clinic = ?", [$b, $a, Session::get("clinic")->c_id])->results();
						}
					break;
					
					case "tomorrow":
						if(Session::get("admin")){
							$r = appointments::getBy(["a_date" => date("d-M-Y", strtotime("+1 day"))]);
						}else{
							$r = appointments::getBy(["a_date" => date("d-M-Y", strtotime("+1 day")), "a_clinic" => Session::get("clinic")->c_id]);
						}
						
					break;
					
					case "week":
						$b = strtotime("-3 days");
						$a = strtotime("+3 days");
						
						if(Session::get("admin")){
							$r = DB::conn()->query("SELECT * FROM appointments WHERE a_time > ? AND a_time < ?", [$b, $a])->results();
						}else{
							$r = DB::conn()->query("SELECT * FROM appointments WHERE a_time > ? AND a_time < ? AND a_clinic = ?", [$b, $a, Session::get("clinic")->c_id])->results();
						}
					break;
					
					case "month":
						if(Session::get("admin")){
							$r = DB::conn()->query("SELECT * FROM appointments WHERE a_date LIKE ?", ["%" . date("M-Y") . "%"])->results();
						}else{
							$r = DB::conn()->query("SELECT * FROM appointments WHERE a_date LIKE ? AND a_clinic = ?", ["%" . date("M-Y") . "%", Session::get("clinic")->c_id])->results();
						}
					break;
					
					case "year":
						if(Session::get("admin")){
							$r = DB::conn()->query("SELECT * FROM appointments WHERE a_date LIKE ?", ["%" . date("-Y") . "%"])->results();
						}else{
							$r = DB::conn()->query("SELECT * FROM appointments WHERE a_date LIKE ? AND a_clinic = ?", ["%" . date("-Y") . "%", Session::get("clinic")->c_id])->results();
						}
					break;
					
					case "pending":
						if(Session::get("admin")){
							$r = appointments::getBy(["a_status" => 0]);
						}else{
							$r = appointments::getBy(["a_status" => 0, "a_clinic" => Session::get("clinic")->c_id]);
						}
							
					break;
				}
				
				foreach($r as $a){
					$c = customers::getBy(["c_id" => $a->a_customer])[0];
			?>
				<tr>
					<td class="text-center"><?= $no++ ?></td>
					<td class="text-center"><?= date("d M Y H:i:s\ ", $a->a_time) ?></td>
					<td>
						<strong>Customer</strong><br />
						<?= $c->c_name ?> (<?= $c->c_ic ?>)<br /><br />
						
						<strong>Description</strong><br />
						<?= $a->a_reason ?>
					</td>
					<td class="text-center">
					<?php
						switch($a->a_status){
							case "1": echo "Approved"; break;
							case "0": echo "Pending"; break;
							case "2": echo "Cancelled"; break;
						}
					?>
					</td>
					<td class="text-right">
						<a class="btn btn-sm btn-warning" href="<?= PORTAL ?>appointments/edit/<?= $a->a_ukey ?>">
							<span class="fa fa-edit"></span> Edits
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