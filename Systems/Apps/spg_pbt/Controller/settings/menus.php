<?php 

switch (input::post("action")) {
    case "add":
	
        if (!empty(Input::post("name")) &&
			!empty(Input::post("route")) &&
			!empty(Input::post("url")) &&
			!empty(Input::post("sort"))) 
		{
			
			$r = is_array(Input::post("role")) ? Input::post("role") : [];
			$role = implode(",", $r);
			
            $m = menus::insertInto([
				"m_name"			=> 	Input::post("name"),
                "m_route"			=> 	Input::post("route"),
                "m_main"			=> 	Input::post("main"),
                "m_url"				=> 	Input::post("url"),
                "m_status"			=> 	Input::post("status"),
                "m_short"			=> 	Input::post("short"),
                "m_sort"			=> 	Input::post("sort"),
                "m_description"		=> 	Input::post("description"),
                "m_icon"			=> 	Input::post("icon"), 
				"m_role"			=>	$role
            ]);
			// die();
			
            Alert::set("success", "Maklumat menu telah disimpan.");
        } 
		else 
		{
            Alert::set("error", "Data Tidak Lengkap");
        }
        
		break;

    case "edit":
	
        if (!empty(Input::post("name")) &&
			!empty(Input::post("route")) &&
			!empty(Input::post("url")) &&
			!empty(Input::post("sort"))) 
		{
			
			$r = Input::post("role");
			$role = implode(",", $r);
			
            menus::updateBy(
				["m_id" => url::get(3)], 
				[
					"m_name"			=> 	Input::post("name"),
					"m_route"			=> 	Input::post("route"),
					"m_main"			=> 	Input::post("main"),
					"m_url"				=> 	Input::post("url"),
					"m_status"			=> 	Input::post("status"),
					"m_short"			=> 	Input::post("short"),
					"m_sort"			=> 	Input::post("sort"),
					"m_description"		=> 	Input::post("description"),
					"m_icon"			=> 	Input::post("icon"), 
					"m_role"			=>	$role    
            ]);

            Alert::set("success", "Maklumat menu telah disimpan.");
        } 
		else 
		{
            Alert::set("error", "Nama, Maklumat(route, url and sort) adalah wajib!");
        }
        
		break;

    case "delete":
	
        menus::deleteBy(["m_id" => url::get(3)]);

        Alert::set("success", "Maklumat menu telah dipadam.", 
		[
            "redirect"    => PORTAL . "settings/menus"
        ]);
		
        break;
		
}
