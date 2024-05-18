<?php

switch (input::post("action")) {
	case "add":
		if(!empty(Input::post("email")) && !empty(Input::post("password"))){
			$ukey = F::Hashing(F::UniqId(24) . time());
			
			$data = [
				"u_name"		=> Input::post("name"),
				"u_password"    => Password::get(Input::post("password")),
				"u_email"		=> Input::post("email"),
				"u_phone"		=> Input::post("phone"),
				"u_ic"			=> Input::post("ic"),
				"u_alamat"		=> Input::post("alamat"),
				"u_ukey"		=> $ukey
			];

			if (!empty(Input::post("password"))) {
				$data["u_password"] = Password::get(Input::post("password"));
			}

			if (file_exists($_FILES["picture"]["tmp_name"]) && is_uploaded_file($_FILES["picture"]["tmp_name"])) {
				$fname = F::UniqKey() . "-" . F::URLSlugEncode($_FILES["picture"]["name"]);
				if (move_uploaded_file($_FILES["picture"]["tmp_name"], ASSET . "images/profile/" . $fname)) {
					$data["u_picture"] = $fname;
				}
			}

			if(!Session::get("admin")){
				$data["u_role"] = 4;
			}else{
				$data["u_role"] = Input::post("role");
			}
			
			users::insertInto($data);
			
			$u = users::getBy(["u_ukey" => $ukey]);
			
			if(count($u) > 0){
				$u = $u[0];
				
				$role = Input::post("role");
				
				if(!Session::get("admin")){
					$role = "staff";
					
					clinic_user::insertInto([
						"cu_user"	=> $u->u_id,
						"cu_clinic"	=> Session::get("clinic")->c_id,
						"cu_role"	=> $role
					]);
				}
				
				Alert::set("success", "User has been added.");
			}else{
				Alert::set("error", "Fail adding user information.");
			}
		}else{
			new Alert("error", "Email and password is required.");
		}
	break;

	case "edit":
		$data = [
			"u_name"		=> Input::post("name"),
			"u_email"		=> Input::post("email"),
			"u_phone"		=> Input::post("phone"),
			"u_ic"			=> Input::post("ic"),
			"u_alamat"		=> Input::post("alamat")
		];
		
		if(Session::get("admin")){
			$data["u_role"] = Input::post("role");
		}

		if (!empty(Input::post("password"))) {
			$data["u_password"] = Password::get(Input::post("password"));
		}

		if (file_exists($_FILES["picture"]["tmp_name"]) && is_uploaded_file($_FILES["picture"]["tmp_name"])) {
			$fname = F::UniqKey() . "-" . F::URLSlugEncode($_FILES["picture"]["name"]);
			if (move_uploaded_file($_FILES["picture"]["tmp_name"], ASSET . "images/profile/" . $fname)) {
				$data["u_picture"] = $fname;
			}
		}

		users::updateBy(["u_ukey" => url::get(3)], $data);
		
		Alert::set("success", "User information has been saved successfully.");

	break;
}
