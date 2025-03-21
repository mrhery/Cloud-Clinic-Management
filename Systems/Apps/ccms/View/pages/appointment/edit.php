<style>
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

<?php
$a = appointments::getBy(["a_ukey" => url::get(2)]);

if(count($a) > 0){
	$a = $a[0];
	
	$c = customers::getBy(["c_id" => $a->a_customer])[0];
?>
<h4><span class="fa fa-edit"></span> Update Appointment Information</h4>
<form action="" method="POST">
	<div class="row">
		<div class="col-md-6 mb-2">
			<b>Customer Info</b><br />
			
			Name:
			<input type="text" class="form-control" name="name" placeholder="Name" required value="<?= $c->c_name ?>" disabled /><br />
			
			IC / Passport:
			<input type="text" class="form-control" name="ic" placeholder="IC / Passport" required value="<?= $c->c_ic ?>" disabled /><br />
			
			Address:
			<textarea class="form-control" name="address" placeholder="Address" disabled><?= $c->c_address ?></textarea><br />
			
			Phone:
			<input type="tel" class="form-control" name="phone" placeholder="+60 1..." value="<?= $c->c_phone ?>" disabled /><br />
			
			Email:
			<input type="email" class="form-control" name="email" placeholder="example@abc.com" value="<?= $c->c_email ?>" disabled /><br />
		</div>
		
		<div class="col-md-6 mb-2">
			<b>Appointment Description</b><br />
			
			Description:
			<textarea class="form-control" name="reason" placeholder="Description: Fever, cough, covid test, vaccine"><?= $a->a_reason ?></textarea>
			<br />
			
			Date:
			<input type="date" name="date" class="form-control" value="<?= date("Y-m-d", strtotime($a->a_date)) ?>" /><br />
			
			Time:
			<div class="timepicker-container">
				<label><strong>Enter Time</strong></label>
				<div class="form-row">
					<div class="col">
						<select id="hour" class="form-control" name="hour">
							<!-- Hours will be populated dynamically -->
						</select>
					</div>
					<div class="col">
						<select id="minute" class="form-control" name="minute">
							<option value="00">00</option>
							<option value="30">30</option>
						</select>
					</div>
					<div class="col">
						<select id="ampm" class="form-control" name="ampm">
							<option value="AM">AM</option>
							<option value="PM">PM</option>
						</select>
					</div>
				</div>
				<div class="btn-container">
					<button id="now" class="btn btn-primary">Now</button>
					<button id="clear" class="btn btn-danger">Clear</button>
				</div>
				<div class="selected-time">Selected Time: <span id="selectedTime">--:-- --</span></div>
			</div>

			<input type="hidden" name="time" id="time" value="<?= date('h:i A', strtotime($a->a_time)) ?>" />

			
			Status:
			<select class="form-control" name="status">
				<option value="1" <?= $a->a_status == 1 ? "selected" : "" ?>>Approved</option>
				<option value="0" <?= $a->a_status == 0 ? "selected" : "" ?>>Pending</option>
				<option value="2" <?= $a->a_status == 2 ? "selected" : "" ?>>Cancelled</option>
			</select><br />
			
			Note:
			<input type="text" class="form-control" name="note" placeholder="Notes for this update" /><br />
		</div>
		
		<div class="col-md-12 text-center">
			<button class="btn btn-success">
				<span class="fa fa-save"></span> Update
			</button>
			
		<?php
			Controller::form("appointment",
			[
				"action"	=> "update",
				"id"		=> $a->a_ukey
			]);
		?>
		</div>
	</div>
</form>

<hr />

<h4>Appointments Update Logs</h4>

<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th class="text-center" width="5%">No</th>
			<th class="text-center" width="250px">Date</th>
			<th class="text-center" width="10%">Status</th>
			<th>Note</th>
			<th class="text-center" width="10%">User</th>
		</tr>
	</thead>
	
	<tbody>
	<?php
		$no = 1;
		foreach(appointment_status::getBy(["as_appointment" => $a->a_id], ["order" => "as_id DESC"]) as $as){
		?>
		<tr>
			<td class="text-center"><?= $no++ ?></td>
			<td class="text-center"><?= date("d-M-Y H:i:s\ ", $as->as_time) ?></td>
			<td class="text-center">
			<?php 
				switch($as->as_status){
					case 1: echo "Approved"; break;
					case 0: echo "Pending"; break;
					case 2: echo "Cancelled"; break;
				} 
			?>
			</td>
			<td><?= $as->as_message ?></td>
			<td class="text-center">
			<?php
				$u = users::getBy(["u_id" => $as->as_user]);
				
				if(count($u) > 0){
					$u = $u[0];
					echo $u->u_name;
				}else{
					echo "-";
				}
			?>
			</td>
		</tr>
		<?php
		}
	?>
	</tbody>
</table>
<?php
}else{
	new Alert("error", "Selected appointment is not exists.");
}
?>
<script>
		$(document).ready(function () {
    // Populate hours from 1 to 12
    for (let i = 1; i <= 12; i++) {
        $("#hour").append(`<option value="${i}">${i}</option>`);
    }

    // Update selected time
    function updateTime() {
        let hour = $('#hour').val();
        let minute = $('#minute').val();
        let ampm = $('#ampm').val();
        $("#selectedTime").text(`${hour}:${minute} ${ampm}`);
    }
    $("select").change(updateTime);

    // Set to current time
    $('#now').click(function (event) {
        event.preventDefault(); // Prevents form submission if inside a form

        let now = new Date();
        let hours = now.getHours();
        let minutes = now.getMinutes() >= 30 ? '30' : '00';
        let ampm = hours >= 12 ? 'PM' : 'AM';

        hours = hours % 12 || 12; // Convert 24-hour format to 12-hour format

        $('#hour').val(hours);
        $('#minute').val(minutes);
        $('#ampm').val(ampm);

        $("#selectedTime").text(`${hours}:${minutes} ${ampm}`);
    });

    // Clear selection
    $('#clear').click(function (event) {
        event.preventDefault(); // Prevents unintended navigation

        $('#hour').prop('selectedIndex', 0);
        $('#minute').prop('selectedIndex', 0);
        $('#ampm').prop('selectedIndex', 0);

        $('#selectedTime').text('--:-- --');
    });
});
</script>