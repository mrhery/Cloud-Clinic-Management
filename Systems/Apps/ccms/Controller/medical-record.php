<?php

switch(Input::post("action")){
	case "create":
		if(!empty(Input::post("name")) && !empty(Input::post("ic"))){
			$c = customers::getBy(["c_ic" => Input::post("ic")]);
			
			if(count($c) > 0){
				$c = $c[0];
				$cc = clinic_customer::getBy(["cc_clinic" => Session::get("clinic")->c_id, "cc_customer" => $c->c_id]);
				
				if(count($cc) < 1){
					clinic_customer::insertInto(["cc_clinic" => Session::get("clinic")->c_id, "cc_customer" => $c->c_id]);					
				}
				
				HTML::script('
					window.location = "'. PORTAL .'medical-record/create?ic='. $c->c_ic .'"
				');
			}else{
				$ukey = hash("sha256", uniqid() . "-" . uniqid());
				
				customers::insertInto([
					"c_name"	=> Input::post("name"),
					"c_ic"		=> Input::post("ic"),
					"c_phone"	=> Input::post("phone"),
					"c_email"	=> Input::post("email"),
					"c_ukey"	=> $ukey,
					"c_address"	=> Input::post("address")
				]);
				
				$c = customers::getBy(["c_ukey" => $ukey]);
				
				if(count($c) > 0){
					$c = $c[0];
					
					clinic_customer::insertInto([
						"cc_clinic"		=> Session::get("clinic")->c_id,
						"cc_customer"	=> $c->c_id
					]);
					
					HTML::script('
						window.location = "'. PORTAL .'medical-record/create?ic='. $c->c_ic .'"
					');
				}else{
					Alert::set("error", "Customer name and IC Number is required.");
				}
			}
		}else{
			Alert::set("error", "Customer name and IC Number is required.");
		}
	break;
}