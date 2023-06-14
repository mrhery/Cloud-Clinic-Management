<?php

switch(input::post("action")){
	case "add":

		if(
            !empty(Input::post("name")) &&  
			!empty(Input::post("status"))
		){
			roles::insertInto([
				"r_name"		=> Input::post("name"),
				"r_status"		=> Input::post("status"),
			]);
			
			Alert::set("success", "Maklumat rol telah disimpan.");
		}
		else
		{
			Alert::set("error", "Sila Lengkapkan Maklumat yang Diperlukan!");
		}
		
	break;
	
	case "edit":

		if(
            !empty(Input::post("name")) &&  
			!empty(Input::post("status")) 
		){
			roles::updateBy(["r_id" => url::get(3)], [
				"r_name"		=> Input::post("name"),
				"r_status"		=> Input::post("status"),
			]);
			Alert::set("success", "Maklumat berjaya dikemaskini.");
		}
		else
		{
			Alert::set("error", "Sila Lengkapkan Maklumat yang Diperlukan!");
		}
		
	break;
	
	case "delete":
		roles::deleteBy(["r_id" => url::get(3)]);
		
		Alert::set("success", "Maklumat berjaya dipadam.",
		[
			"redirect"	=> PORTAL . "settings/rols"
		]);
		
	break;
}

