<?php

switch(url::get(2)){
	case "search":
		$x = Input::post("keyword");
		
		$i = DB::conn()->query("SELECT i_name as name, i_code as code, i_key as id FROM items WHERE (i_name LIKE ? OR i_description LIKE ? OR i_code = ? OR i_tag LIKE ?) AND i_clinic = ? LIMIT 30", [
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