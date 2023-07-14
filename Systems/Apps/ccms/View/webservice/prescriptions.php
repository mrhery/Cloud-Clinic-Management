<?php

switch(Input::post("action")){
	case "search":
		$x = Input::post("skey");
		
		$p = DB::conn()->query("SELECT i_name as name, i_quantity as quantity FROM items WHERE i_type = 'product' AND (i_name LIKE ? OR i_description LIKE ? OR i_code = ?) AND i_clinic = ? LIMIT 30", // AND i_clinic = ?
			[
				"%" . $x . "%",
				"%" . $x . "%",
				"%" . $x . "%",
				Session::get("clinic")->c_id
			]
		)->results();
		
		die(json_encode([
			"status"	=> "success",
			"data"		=> $p
		]));
	break;
}

die();