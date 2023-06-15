<?php

switch(Input::post("action")){
	case "create":
		if(!empty(Input::post("name")) && !empty(Input::post("ic"))){
			
			$c = customers::getBy(["c_ic" => Input::post("ic")]);
			
			if(count($c) < 1){
				$ukey = hash("sha256", uniqid());
				customers::insertInto([
					"c_name"		=> Input::post("name"),
					"c_ic"			=> Input::post("ic"),
					"c_email"		=> Input::post("email"),
					"c_phone"		=> Input::post("phone"),
					"c_address"		=> Input::post("address"),
					"c_email"		=> Input::post("email"),
					"c_ukey"		=> $ukey
				]);
				
				$c = customers::getBy(["c_ukey" => $ukey]);
			}
			
			if(count($c) > 0){
				$c = $c[0];
				$akey = hash("sha256", uniqid() . $c->c_ukey);
				
				appointments::insertInto([
					"a_customer" 	=> $c->c_id,
					"a_date"		=> date("d-M-Y", strtotime(Input::post("date"))),
					"a_time"		=> strtotime(Input::post("date") . " " . Input::post("time")),
					"a_ukey"		=> $akey,
					"a_status"		=> Input::post("status"),
					"a_reason"		=> Input::post("reason")
				]);
				
				Alert::set("success", "Appointment record has been added.");
			}else{
				Alert::set("error", "Fail registering customer's information.");
			}
		}else{
			Alert::set("error", "Customer name and IC Number is required.");
		}
	break;
	
	case "update":
		appointments::updateBy(["a_ukey" => url::get(2)], [
			"a_date"		=> date("d-M-Y", strtotime(Input::post("date"))),
			"a_time"		=> strtotime(Input::post("date") . " " . Input::post("time")),
			"a_status"		=> Input::post("status"),
			"a_reason"		=> Input::post("reason")
		]);
		
		Alert::set("success", "Appointment record has been saved.");
	break;
}

// die();
