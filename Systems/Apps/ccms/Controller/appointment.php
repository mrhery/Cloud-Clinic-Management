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
				
				if(!Session::get("admin")){
					clinic_customer::insertInto([
						"cc_clinic"		=> Session::get("clinic")->c_id,
						"cc_customer"	=> $c->c_id
					]);
				}
				
				$akey = hash("sha256", uniqid() . $c->c_ukey);
				
				appointments::insertInto([
					"a_customer" 	=> $c->c_id,
					"a_date"		=> date("d-M-Y", strtotime(Input::post("date"))),
					"a_time"		=> strtotime(Input::post("date") . " " . Input::post("time")),
					"a_ukey"		=> $akey,
					"a_status"		=> Input::post("status"),
					"a_reason"		=> Input::post("reason"),
					"a_createdDate"	=> F::GetDate(),
					"a_user"		=> Session::get("user")->u_id
				]);
				
				$a = appointments::getBy(["a_ukey" => $akey]);
	
				if(count($a) > 0){
					$a = $a[0];
					
					appointment_status::insertInto([
						"as_appointment"	=> $a->a_id,
						"as_status"			=> Input::post("status"),
						"as_message"		=> Input::post("note"),
						"as_date"			=> date("d-M-Y"),
						"as_time"			=> F::GetTime(),
						"as_user"			=> Session::get("user")->u_id
					]);
				
					Alert::set("success", "Appointment record has been created.");
				}else{
					Alert::set("error", "Fail creating your appointment record. Please try again later.");
				}
			}else{
				Alert::set("error", "Fail registering customer's information.");
			}
		}else{
			Alert::set("error", "Customer name and IC Number is required.");
		}
	break;
	
	case "update":
		$a = appointments::getBy(["a_ukey" => url::get(2)]);
		
		if(count($a) > 0){
			$a = $a[0];
			
			appointments::updateBy(["a_ukey" => url::get(2)], [
				"a_date"		=> date("d-M-Y", strtotime(Input::post("date"))),
				"a_time"		=> strtotime(Input::post("date") . " " . Input::post("time")),
				"a_status"		=> Input::post("status"),
				"a_reason"		=> Input::post("reason")
			]);
			
			appointment_status::insertInto([
				"as_appointment"	=> $a->a_id,
				"as_status"			=> Input::post("status"),
				"as_message"		=> Input::post("note"),
				"as_date"			=> date("d-M-Y"),
				"as_time"			=> F::GetTime(),
				"as_user"			=> Session::get("user")->u_id
			]);
			
			Alert::set("success", "Appointment record has been saved.");
		}else{
			Alert::set("success", "Cannot update appointment information because no appointment found.");
		}
	break;
}

// die();
