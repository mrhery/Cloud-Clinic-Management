<?php

switch(Input::post("action")){
	case "search":
		$c = DB::conn()->query("SELECT c_name as name, c_ic as ic, c_phone as phone, c_email as email FROM customers WHERE (c_name LIKE ? OR c_ic LIKE ? OR c_phone LIKE ? OR c_email LIKE ?) AND c_id IN (SELECT cc_customer FROM clinic_customer WHERE cc_clinic = ?)", // AND c_id IN (SELECT cc_customer FROM clinic_customer WHERE cc_clinic = ?)
		[
			"%" . Input::post("skey") . "%",
			"%" . Input::post("skey") . "%",
			"%" . Input::post("skey") . "%",
			"%" . Input::post("skey") . "%",
			Session::get("clinic")->c_id
		])->results();
		
		die(json_encode([
			"status"		=> "success",
			"data"			=> $c
		]));
	break;
}