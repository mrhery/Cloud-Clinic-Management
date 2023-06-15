<?php

switch (input::post("action")) {
	case "edit":
		$u_id 		= url::get(2);
		$u_name  	= Input::post("u_name");
		$u_ic  		= Input::post("u_ic");
		$u_alamat  	= Input::post("u_alamat");
		$u_password = Input::post("u_password");
		$u_phone  	= Input::post("u_phone");
		$u_email    = Input::post("u_email");

		$data = [
			"u_name"     => $u_name,
			"u_ic"       => $u_ic,
			"u_alamat"   => $u_alamat,
			"u_password" => $u_password,
			"u_phone"    => $u_phone,
			"u_email"    => $u_email
		];

		$cs = users::updateBy(["u_id" => $u_id], $data);

		if ($cs) {
			Alert::set("success", "Maklumat berjaya dikemaskini.");
		} else {
			Alert::set("error", "Sila Lengkapkan Maklumat yang Diperlukan!");
		}

		break;
}
