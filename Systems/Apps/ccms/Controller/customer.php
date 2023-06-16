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
}