<?php

switch(url::get(2)){
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