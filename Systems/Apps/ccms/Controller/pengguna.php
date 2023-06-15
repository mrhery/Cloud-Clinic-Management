<?php

switch (input::post("action")) {
	case "add":


		$data = [
			"u_name"		=> Input::post("u_name"),
			"u_password"    => Password::get("1234"),
			"u_email"		=> Input::post("u_email"),
			"u_phone"		=> Input::post("u_phone"),
			"u_ic"			=> Input::post("u_ic"),
			"u_alamat"		=> Input::post("u_alamat"),
			"u_area"		=> Input::post("u_area"),
			"u_state"		=> Input::post("u_state"),
			"u_country"		=> Input::post("u_country"),
			"u_postcode"	=> Input::post("u_postcode"),
			"u_role"		=> Input::post("u_role")
		];

		if (!empty(Input::post("u_password"))) {
			$data["u_password"] = Password::get(Input::post("u_password"));
		}

		if (file_exists($_FILES["u_picture"]["tmp_name"]) && is_uploaded_file($_FILES["u_picture"]["tmp_name"])) {
			$fname = F::UniqKey() . "-" . F::URLSlugEncode($_FILES["u_picture"]["name"]);
			if (move_uploaded_file($_FILES["u_picture"]["tmp_name"], ASSET . "images/profile/" . $fname)) {
				$data["u_picture"] = $fname;
			}
		}

		$a = users::insertInto($data);
		if ($a) {
			Alert::set("success", "Maklumat berjaya dikemaskini.");
		} else {
			Alert::set("error", "Sila Lengkapkan Maklumat yang Diperlukan!");
		}


		break;

	case "edit":


		$data = [
			"u_name"		=> Input::post("u_name"),
			"u_email"		=> Input::post("u_email"),
			"u_phone"		=> Input::post("u_phone"),
			"u_ic"			=> Input::post("u_ic"),
			"u_alamat"		=> Input::post("u_alamat"),
			"u_area"		=> Input::post("u_area"),
			"u_state"		=> Input::post("u_state"),
			"u_country"		=> Input::post("u_country"),
			"u_postcode"	=> Input::post("u_postcode"),
			"u_role"		=> Input::post("u_role")
		];

		if (!empty(Input::post("u_password"))) {
			$data["u_password"] = Password::get(Input::post("u_password"));
		}

		if (file_exists($_FILES["u_picture"]["tmp_name"]) && is_uploaded_file($_FILES["u_picture"]["tmp_name"])) {
			$fname = F::UniqKey() . "-" . F::URLSlugEncode($_FILES["u_picture"]["name"]);
			if (move_uploaded_file($_FILES["u_picture"]["tmp_name"], ASSET . "images/profile/" . $fname)) {
				$data["u_picture"] = $fname;
			}
		}

		$a = users::updateBy(["u_id" => url::get(2)], $data);
		if ($a) {
			Alert::set("success", "Maklumat berjaya dikemaskini.");
		} else {
			Alert::set("error", "Sila Lengkapkan Maklumat yang Diperlukan!");
		}

		break;
}
