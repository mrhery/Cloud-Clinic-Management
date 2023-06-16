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
				
				if(count($c) > 0){
					$c = $c[0];
					
					if(!Session::get("admin")){
						clinic_customer::insertInto([
							"cc_clinic"		=> Session::get("clinic")->c_id,
							"cc_customer"	=> $c->c_id
						]);
					}
					
					Alert::set("success", "Customer information has been added.");
				}else{
					Alert::set("error", "Fail creating customer information. Please try again later.");
				}
			}else{
				Alert::set("error", "Customer IC has been registered before.");
			}
		}
	break;
	
	case "update":
		if(!empty(Input::post("name")) && !empty(Input::post("ic"))){
			if(Session::get("admin")){
				$c = customers::getBy(["c_ukey" => url::get(2)]);
			}else{
				$c = DB::conn()->query("SELECT * FROM customers WHERE c_id IN (SELECT cc_customer FROM clinic_customer WHERE cc_clinic = ?) AND c_ukey = ?", [Session::get("clinic")->c_id, url::get(2)])->results();
			}
			
			if(count($c) > 0){
				$c = $c[0];
				
				customers::updateBy(["c_id" => $c->c_id], [
					"c_name"		=> Input::post("name"),
					"c_ic"			=> Input::post("ic"),
					"c_email"		=> Input::post("email"),
					"c_phone"		=> Input::post("phone"),
					"c_address"		=> Input::post("address"),
					"c_email"		=> Input::post("email")
				]);
				
				Alert::set("success", "Customer information has been added.");
			}else{
				Alert::set("error", "Customer IC has been registered before.");
			}
		}
	break;
}