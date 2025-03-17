<?php

switch(Url::get(2)){
	case "date":
		$as = DB::conn()->query("SELECT a_ukey as id, a_bookedDate as bookedDate, a_bookedTime as bookedTime, a_attendee as attendee, a_date, a_customer as customer, a_status as status FROM appointments WHERE a_clinic = ? AND a_bookedDate = ?", [Session::get("clinic")->c_id, Input::post("date")])->results();
		
		$data = [];
		
		foreach($as as $a){
			$dr = users::getBy(["u_id" => $a->attendee]);
			
			if(count($dr) > 0){
				$a->attendee = $dr[0]->u_name;
			}else{
				$a->attendee = "Unset";
			}
			
			$c = customers::getBy(["c_id" => $a->customer]);
			
			if(count($c) > 0){
				$a->customer = $c[0]->c_name;
			}else{
				$a->customer = "<i>Unknown</i>";
			}
			
			$data[] = $a;
		}
		
		die(json_encode([
			"status"	=> "success",
			"message"	=> "List of appointment on selected date. ",
			"data"		=> $data
		]));
	break;

	case "search":

		$x = Input::post("keyword");

		$c = DB::conn()->query("SELECT c_name as name, c_ic as ic, c_phone as phone, c_ukey as id FROM customers WHERE (c_name LIKE ? OR c_ic LIKE ? OR c_phone LIKE ? OR c_email LIKE ?) AND c_id IN (SELECT cc_customer FROM clinic_customer WHERE cc_clinic = ?)",
		[
			"%" . $x . "%",
			"%" . $x . "%",
			"%" . $x . "%",
			"%" . $x . "%",
			Session::get("clinic")->c_id
		])->results();

		die(json_encode([
			"status"		=> "success",
			"data"			=> $c
		]));
	break;
}