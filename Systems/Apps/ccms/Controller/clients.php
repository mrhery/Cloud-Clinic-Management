<?php

switch (Input::post("action")) {
	case "add":
		if (!empty(Input::post("c_name")) || true) {
			$c_key = F::Hashing(F::UniqId(24));

			// Insert client data with c_key
			clients::insertInto([
				"c_name"		=> Input::post("c_name"),
				"c_email"		=> Input::post("c_email"),
				"c_clinic"		=> Session::get("clinic")->c_id,
				"c_phone"		=> Input::post("c_phone"),
				"c_regno"		=> Input::post("c_regno"),
				"c_address"		=> Input::post("c_address"),
				"c_key"			=> $c_key // Assign the generated c_key
			]);

			Alert::set("success", "Client information has been saved.");
		} else {
			Alert::set("error", "Client name is required.");
		}
		break;

	case "edit":
		/* $c_key = F::Hashing(F::UniqId(24)); */
		$data = [
			"c_name"		=> Input::post("c_name"),
			"c_email"		=> Input::post("c_email"),
			"c_phone"		=> Input::post("c_phone"),
			"c_regno"		=> Input::post("c_regno"),
			"c_address"		=> Input::post("c_address"),
			/* "c_key"			=> $c_key // Assign the generated c_key */
		];

		$c = clients::updateBy(["c_key" => url::get(3)], $data);
		if ($c) {
			Alert::set("success", "Maklumat berjaya dikemaskini.");
		} else {
			Alert::set("error", "Sila Lengkapkan Maklumat yang Diperlukan!");
		}

		break;

	case "delete":
		$a = clients::deleteBy(["c_key" => url::get(3)]);
		if ($a) {
			new Alert("success", "supplier deleted");
		} else {
			new Alert("error", "Failed to delete supplier.");
		}
		break;
}