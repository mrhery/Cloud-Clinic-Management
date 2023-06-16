<?php

switch(input::post("action")){
	case "create":
		if(Session::get("admin")){
			if(!empty(Input::post("name"))){
				$ckey = F::Hashing(F::UniqId(24));
				
				clinics::insertInto([
					"c_ukey"		=> $ckey,
					"c_name"		=> Input::post("name"),
					"c_address"		=> Input::post("address"),
					"c_email"		=> Input::post("email"),
					"c_phone"		=> Input::post("phone"),
					"c_regno"		=> Input::post("regno"),
					"c_owner"		=> Input::post("owner"),
					"c_user"		=> Session::get("user")->u_id
				]);
				
				$c = clinics::getBy(["c_ukey" => $ckey]);
				
				if(count($c) > 0){
					$c = $c[0];
					
					clinic_user::insertInto([
						"cu_clinic"	=> $c->c_id,
						"cu_user"	=> Input::post("owner"),
						"cu_role"	=> "owner"
					]);
					
					clinic_user::insertInto([
						"cu_clinic"	=> $c->c_id,
						"cu_user"	=> Session::get("user")->u_id,
						"cu_role"	=> "admin"
					]);
					
					Alert::set("success", "Clinic information has been added.");
				}else{
					Alert::set("error", "Fail creating clinic record.");
				}
			}else{
				Alert::set("error", "Business name is required.");
			}
		}else{
			new Alert("error", "Not allowed");
		}
	break;
	
	case "update":
		$c = clinics::getBy(["c_ukey" => url::get(2)]);
		
		if(count($c) > 0){
			$c = $c[0];
			
			if(Session::get("admin") || $c->c_owner == Session::get("user")->u_id){
				$data = [
					"c_name"		=> Input::post("name"),
					"c_address"		=> Input::post("address"),
					"c_email"		=> Input::post("email"),
					"c_phone"		=> Input::post("phone"),
					"c_regno"		=> Input::post("regno"),
					"c_user"		=> Session::get("user")->u_id
				];
				
				if(Session::get("admin")){
					clinics::updateBy(["c_ukey" => url::get(2)], $data);
				}else{
					clinics::updateBy(["c_ukey" => url::get(2), "c_owner" => Session::get("user")->u_id], $data);
				}
				
				Alert::set("success", "Clinic information has been saved.");
			}else{
				Alert::set("error", "Only owner of this clinic can alter this information.");
			}
		}else{
			Alert::set("error", "Clinic information not found.");
		}
	break;
}