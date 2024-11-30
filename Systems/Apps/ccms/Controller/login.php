<?php

switch (input::post("action")) {
	case "login":
		$u = users::getBy([
			"u_email" => Input::post("email"),
			"u_password" => Password::get(Input::post("password"))
		]);

		if (count($u) > 0) {
			$u = $u[0];
			
			if($u->u_admin){
				$b = clinics::list(["limit" => "1"])[0];
				Session::set("clinic", $b);
				Session::set("admin", true);
				Session::set("user", $u);
				Session::set("role", "admin");
			}else{
				$cu = clinic_user::getBy(["cu_user" => $u->u_id]);
				
				if(count($cu) > 0){
					$cu = $cu[0];
					$c = clinics::getBy(["c_id" => $cu->cu_clinic]);
					
					if(count($c) > 0){
						$c = $c[0];
						
						Session::set("user", $u);
						Session::set("clinic", $c);
						Session::set("role", $cu->cu_role); //owner, staff, billing, account
						Session::set("admin", 0);
					}else{
						Alert::set("error", "Clinic information might be corrupted. Please contact our techncal team.");
					}
				}else{
					Alert::set("error", "Clinic information not found.");
				}
			}
		} else {
			// Controller::set("autoRefresh", false);

			Alert::set("error", "No user information found.");
		}
		break;
}
