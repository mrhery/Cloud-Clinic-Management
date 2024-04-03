<?php
$now = time();

$a = DB::conn()->query("SELECT COUNT(*) as total FROM appointments WHERE a_customer = ? AND a_time > ?", [$c->c_id, $now])->results();

if(count($a) > 0){
	$a = $a[0]->total;
}else{
	$a = 0;
}

$r = count(customer_record::getBy(["cr_customer" => $c->c_id]));

$dtc = DB::conn()->query("SELECT * FROM appointments WHERE a_customer = ? AND a_time > ? ORDER BY a_time ASC LIMIT 1", [$c->c_id, $now])->results();

if(count($dtc) > 0){
	$dtc = $dtc[0];
	
	$bal = ceil(($dtc->a_time - $now) / (60 * 60 * 24));
	
	$dtc = $bal;
}else{
	$dtc = "-";
}

$total = DB::conn()->query("SELECT SUM(s_total) as total FROM sales WHERE s_client = ? AND s_date LIKE ?", [$c->c_id, "%" . date("-Y") ."%"])->results();

if(count($total) > 0){
	$total = $total[0]->total ?? 0;
	$total = number_format($total, 2);
}else{
	$total = "0.00";
}

$apps = [];
$aps = DB::conn()->query("SELECT * FROM appointments WHERE a_customer = ? AND a_time > ? LIMIT 10", [$c->c_id, $now])->results();

foreach($aps as $ap){
	$cl = clinics::getBy(["c_id" => $ap->a_clinic]);
	
	$apps[] = [
		"id"		=> $ap->a_ukey,
		"clinic"	=> [
			"name"		=> (count($cl) > 0 ? $cl->c_name : null)
		],
		"date"		=> $ap->a_date,
		"time"		=> date("H:i:s\ ", $ap->a_time),
		"reason"	=> $ap->a_reason
	];
}

die(json_encode([
	"status"	=> "success",
	"message"	=> "Data for " . str_replace(".php", "", basename(__FILE__)),
	"data"		=> [
		"name"			=> $c->c_name,
		"appointments"	=> $a,
		"records"		=> $r,
		"daysToCheck"	=> $dtc,
		"total"			=> $total,
		"upcoming"		=> $apps
	]
]));

