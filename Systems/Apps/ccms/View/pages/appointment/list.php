<?php
$show = Input::get("show");
$search = Input::get("search");
$page = (int)Input::get("page");
$npage = 1;

if ($page < 1) {
    $page = 1;
}

if (empty($show)) {
	$show = "today";
}
?>

<a href="<?= PORTAL ?>print-list-appointments?show=<?= $show ?>" target="_blank" class="fab bg-warning text-dark fab-right-bottom" style="bottom: 180px; width: 60px; height: 60px; right: 30px;">
	<span class="fa fa-print"></span>
</a>

<a href="<?= PORTAL ?>appointments/calendar" class="fab bg-info text-light fab-right-bottom usp-right-sheet" style="bottom: 110px; width: 60px; height: 60px; right: 30px;">
	<span class="fa fa-calendar"></span>
</a>

<a href="<?= PORTAL ?>appointments/create" class="fab bg-primary text-light fab-right-bottom usp-right-sheet">
	<span class="fa fa-plus"></span>
</a>

<div class="mb-3">
	<a class="btn btn-sm btn-<?= $show == "today" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>appointments?show=today">
		Today
	</a>

	<a class="btn btn-sm btn-<?= $show == "now" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>appointments?show=now">
		Now
	</a>

	<a class="btn btn-sm btn-<?= $show == "tomorrow" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>appointments?show=tomorrow">
		Tomorrow
	</a>

	<a class="btn btn-sm btn-<?= $show == "week" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>appointments?show=week">
		This Week
	</a>

	<a class="btn btn-sm btn-<?= $show == "month" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>appointments?show=month">
		This Month
	</a>

	<a class="btn btn-sm btn-<?= $show == "year" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>appointments?show=year">
		This Year
	</a>

	<a class="btn btn-sm btn-<?= $show == "pending" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>appointments?show=pending">
		Pending
	</a>

	<a class="btn btn-sm btn-<?= $show == "all" ? "dark" : "outline-dark" ?>" href="<?= PORTAL ?>appointments?show=all">
		All
	</a>
</div>

<div class="row mb-3">
	<div class="col-md-4">
		<div class="input-group mb-3">
			<input type="text" class="form-control" name="search" placeholder="Search">
			<div class="input-group-append">
				<button class="btn btn-success" type="submit"><span class="fa fa-search"></span></button>
			</div>
		</div>
	</div>
	
	<div class="col-md-8">
		<form action="" method="GET" class="text-right">
			<a href="<?= PORTAL ?>appointments?page=<?= $page - 1 ?>&show=<?= $show ?>&search=<?= $search ?>" class="btn btn-sm btn-primary">
				<span class="fa fa-arrow-left"></span>
			</a>
			
			<input type="number" name="page" class="form-control text-center pagination-input" value="<?= $page ?>" /> / <?= $npage ?>
			<input type="hidden" value="<?= $show ?>" name="show" />
			<input type="hidden" value="<?= $search ?>" name="search" />
			
			<a href="<?= PORTAL ?>appointments?page=<?= $page + 1 ?>&show=<?= $show ?>&search=<?= $search ?>" class="btn btn-sm btn-primary">
				<span class="fa fa-arrow-right"></span>
			</a>
		</form>
	</div>
</div>

<div style="height: calc(100% - 200px); overflow-y: auto; position: fixed; width: calc(100% - 240px); box-sizing: border-box;">

<?php
$no = 1;

switch ($show) {
	case "today":
		$r = (Session::get("admin") ? appointments::getBy(["a_bookedDate" => date("Y-m-d")]) : appointments::getBy(["a_bookedDate" => date("Y-m-d"), "a_clinic" => Session::get("clinic")->c_id]));
		break;

	case "now":
		$b = strtotime("-2 hours");
		$a = strtotime("+2 hours");

		if (Session::get("admin")) {
			$r = DB::conn()->query("SELECT * FROM appointments WHERE a_time > ? AND a_time < ?", [$b, $a])->results();
		} else {
			$r = DB::conn()->query("SELECT * FROM appointments WHERE a_time > ? AND a_time < ? AND a_clinic = ?", [$b, $a, Session::get("clinic")->c_id])->results();
		}
		break;

	case "tomorrow":
		if (Session::get("admin")) {
			$r = appointments::getBy(["a_bookedDate" => date("Y-m-d", strtotime("+1 day"))]);
		} else {
			$r = appointments::getBy(["a_bookedDate" => date("Y-m-d", strtotime("+1 day")), "a_clinic" => Session::get("clinic")->c_id]);
		}

		break;

	case "week":
		$b = strtotime("-3 days");
		$a = strtotime("+3 days");

		if (Session::get("admin")) {
			$r = DB::conn()->query("SELECT * FROM appointments WHERE a_time > ? AND a_time < ?", [$b, $a])->results();
		} else {
			$r = DB::conn()->query("SELECT * FROM appointments WHERE a_time > ? AND a_time < ? AND a_clinic = ?", [$b, $a, Session::get("clinic")->c_id])->results();
		}
		break;

	case "month":
		if (Session::get("admin")) {
			$r = DB::conn()->query("SELECT * FROM appointments WHERE a_bookedDate LIKE ?", ["%" . date("Y-m") . "%"])->results();
		} else {
			$r = DB::conn()->query("SELECT * FROM appointments WHERE a_bookedDate LIKE ? AND a_clinic = ?", ["%" . date("Y-m") . "%", Session::get("clinic")->c_id])->results();
		}
		break;

	case "year":
		if (Session::get("admin")) {
			$r = DB::conn()->query("SELECT * FROM appointments WHERE a_bookedDate LIKE ?", ["%" . date("Y") . "%"])->results();
		} else {
			$r = DB::conn()->query("SELECT * FROM appointments WHERE a_bookedDate LIKE ? AND a_clinic = ?", ["%" . date("Y") . "%", Session::get("clinic")->c_id])->results();
		}
		break;

	case "all":
		if (Session::get("admin")) {
			$r = DB::conn()->query("SELECT * FROM appointments")->results();
		} else {
			$r = DB::conn()->query("SELECT * FROM appointments WHERE a_clinic = ?", [Session::get("clinic")->c_id])->results();
		}
		break;

	case "pending":
		if (Session::get("admin")) {
			$r = appointments::getBy(["a_status" => 0]);
		} else {
			$r = appointments::getBy(["a_status" => 0, "a_clinic" => Session::get("clinic")->c_id]);
		}
		break;
}

if(count($r) < 1){
?>
<div class="text-center">
	<i>No records</i>
</div>
<?php
}

foreach ($r as $a) {
	$c = customers::getBy(["c_id" => $a->a_customer])[0];
	$u = users::getBy(["u_id" => $a->a_attendee]);
?>
	<div class="card mb-3 shadow usp-right-sheet" href="<?= PORTAL ?>appointments/edit/<?= $a->a_ukey ?>">
		<div class="card-body">
			<b><?= $c->c_name ?> (<?= $c->c_ic ?>)</b><br />
			
			<?= $a->a_reason ?>
			<hr />
			<span class="badge badge-primary"><?= (count($u) > 0 ? $u[0]->u_name : "Unset") ?></span>
			<?php
				switch ($a->a_status) {
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
			?> | <?= date("d M Y H:i:s\ ", strtotime($a->a_bookedDate . " " . $a->a_bookedTime)) ?>
		</div>
	</div>
<?php
}
?>
<br /><br /><br />
</div>
<?php
		
Page::append(<<<HTML
<script>
$(document).on("keyup", "#search-ic", function(){
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
		// console.log(res);
		var o = JSON.parse(res);
		
		if(o.status == "success"){
			$("#ic-search-list").html("");
			
			o.data.forEach(function(c){
				$("#ic-search-list").append('\
					<div class="ic-list-item" data-id="'+ c.id +'">\
						<strong>'+ c.name +' ('+ c.ic +')</strong><br />\
						'+ c.phone +' <br /> '+ c.email +'\
					</div>\
				');
			});
		}
	});
});

$(document).on("click", ".ic-list-item", function(){
	let c_id = $(this).data("id");
	
	$("#ic-search-list").html("");
	$("#ic-search-list").hide();
	
	$.ajax({
		url: PORTAL + "webservice/customers",
		method: "POST",
		data: {
			action: "get",
			c_id: c_id
		},
		dataType: "text"
	}).done(function(res){
		// console.log(res);
		
		var o = JSON.parse(res);
		
		$("#visit-history").html('');
		$("#billing-history").html('');
		
		if(o.status == "success"){
			$("[name=name]").val(o.data.name);
			$("[name=ic]").val(o.data.ic);
			$("[name=phone]").val(o.data.phone);
			$("[name=email]").val(o.data.email);
			$("[name=c_id]").val(o.data.id);
			
			$("[name=name]").prop("readonly", true);
			$("[name=ic]").prop("readonly", true);
			$("[name=phone]").prop("readonly", true);
			$("[name=email]").prop("readonly", true);
			
			$("#btn-customer-search").hide();
			$("#btn-customer-reset").show();
			
			if(o.data.appointments.length < 1){
				$("#visit-history").html('\
					<tr>\
						<td class="text-center"><i>No Record</i></td>\
					</tr>\
				');
			}
			
			o.data.appointments.forEach(function(a){
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
						
				$("#visit-history").append('\
					<tr>\
						<td class="">\
							<b>'+ a.bookedDate +'</b> '+ a.reason +'<br />\
							<span class="badge badge-'+ badgeStatus +'">'+ statusText +'</span>\
						</td>\
					</tr>\
				');
			});
			
			if(o.data.sales.length < 1){
				$("#billing-history").html('\
					<tr>\
						<td class="text-center"><i>No Record</i></td>\
					</tr>\
				');
			}
			
			o.data.sales.forEach(function(s){
				$("#billing-history").append('\
					<tr>\
						<td class="">\
							<b>'+ a.invoiceDate +'</b> '+ a.no +'<br />\
							Paid RM '+ a.paid +' / '+ a.total +'\
						</td>\
					</tr>\
				');
			});
		}else{
			$("#visit-history").html('\
				<tr>\
					<td class="text-center"><i>No Record</i></td>\
				</tr>\
			');
		}
	});
});

$(document).on("click", "#btn-customer-reset", function(){
	$("[name=name]").val("");
	$("[name=ic]").val("");
	$("[name=phone]").val("");
	$("[name=email]").val("");
	$("[name=c_id]").val("");
	
	$("[name=name]").prop("readonly", false);
	$("[name=ic]").prop("readonly", false);
	$("[name=phone]").prop("readonly", false);
	$("[name=email]").prop("readonly", false);
	
	$("#btn-customer-search").show();
	$("#btn-customer-reset").hide();
	
	$("#search-ic").val("");
	
	$("#visit-history").html('\
		<tr>\
			<td class="text-center"><i>No Record</i></td>\
		</tr>\
	');
	
	$("#billing-history").html('\
		<tr>\
			<td class="text-center"><i>No Record</i></td>\
		</tr>\
	');
});

$(document).on("click", ".select-vehicle", function(){
	let sFor = $(this).data("for");
	
	if($("#" + sFor).is(":checked")){
		$("#" + sFor).prop("checked", false);
		$(this).removeClass("bg-info text-light");
	}else{
		$("#" + sFor).prop("checked", true);
		$(this).addClass("bg-info text-light");	
	}
});
</script>
HTML
);