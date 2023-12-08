<?php

switch(url::get(2)){
	case "search":
		$x = Input::post("keyword");
		
		$i = DB::conn()->query("SELECT c_name as name, c_key as id, c_regno as regno FROM clients WHERE (c_name LIKE ? OR c_regno LIKE ? OR c_address LIKE ? OR c_phone LIKE ? OR c_email LIKE ?) AND c_clinic = ? LIMIT 30", [
				"%" . $x . "%",
				"%" . $x . "%",
				"%" . $x . "%",
				"%" . $x . "%",
				"%" . $x . "%",
				Session::get("clinic")->c_id
			]
		)->results();
		
		die(json_encode([
			"status"	=> "success",
			"data"		=> $i
		]));
	break;
}