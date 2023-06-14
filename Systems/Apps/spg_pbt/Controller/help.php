<?php

switch (input::post("action")) {
	
	case "add":
		if (!empty(Input::post("name"))) {
			
            help::insertInto([
                "h_name" => Input::post("name"),
                "h_email" => Input::post("email"),
                "h_subjek" => Input::post("subject"),
                "h_mesej" => Input::post("message"),
                
            ]);
			

		Alert::set(
			"success",
			"Masalah atau Pertanyaan telah dihantar",
			[
				"redirect"    => PORTAL . "help"
			]
		);
		break;
    }
}