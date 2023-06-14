<?php

switch (input::post("action")) {
	case "login":
		$u = users::getBy([
			"u_email" => Input::post("email"),
			"u_password" => Password::get(Input::post("password"))
		]);

		if (count($u) > 0) {
			$u = $u[0];

			Session::set("user", $u);
		} else {
			// Controller::set("autoRefresh", false);

			Alert::set("error", "No user information found.");
		}
		break;
}
