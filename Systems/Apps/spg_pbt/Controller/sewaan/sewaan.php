<?php

switch(input::post("action")){
	case "add":

		/* die(var_dump(Input::post("shop_picked")[0])); */

		if(
			Input::post("shop_picked") > 0 && 
			(
				!empty(Input::post("su_user")) OR
				(
					!empty(Input::post("name")) &&
					!empty(Input::post("email")) &&
					!empty(Input::post("ic")) &&
					!empty(Input::post("phone")) &&
					!empty(Input::post("alamat"))
				)
			)
		)
		{
			if(is_array(Input::post("shop_picked"))){
				foreach(Input::post("shop_picked") as $sid){
					$ss = shops::getBy(["s_id" => $sid]);

					if(count($ss) > 0){
						$s = $ss[0];
						
						$cs = contracts::getBy([
							"c_shop"	=> $s->s_id
						]);

						rentals::insertInto([
							"r_shop"	=> 	Input::post("shop_picked")[0],
							"r_tenant"	=> 	0,
							"r_month"	=> 	date('F'),
							"r_year"	=> 	date("Y"),
							"r_amount"	=> 	Input::post("amaun"),
							"r_time"	=> 	F::GetTime(),
							"r_user"	=> 	0,
							"r_status"	=> 	0,
							"r_name"	=> 	Input::post("name"),
							"r_address"	=> 	Input::post("alamat"),
							"r_phone"	=> 	Input::post("phone"),
							"r_email"	=> 	Input::post("email"),
							"r_ic"		=> 	Input::post("ic"),
							"r_no"		=> 	"test",
							"r_key"		=> 	F::UniqKey("R_"),

						]);
					}
				}
			 
			}else{
				Alert::set("error", "Tiada data gerai dipilih untuk membuat bayaran.");
			}
			Alert::set("success", "Maklumat gerai telah disimpan.", [
				"redirect"    => PORTAL . "sewaan"
			]);
		}else{
			Alert::set("error", "Sila pilih pengguna dan gerai!");
		}
	break;
	
	case "edit":
		if(
			Input::post("group") > 0 && 
			!empty(Input::post("fileno")) && 
			!empty(Input::post("lot")) && 
			!empty(Input::post("road")) && 
			!empty(Input::post("postcode")) 
		){
			shops::updateBy(["s_id" => url::get(3)], [
				"s_group"		=> Input::post("group"),
				"s_fileno"		=> Input::post("fileno"),
				"s_lotno"		=> Input::post("lotno"),
				"s_hsd"			=> Input::post("hsd"),
				"s_ref1"		=> Input::post("ref1"),
				"s_ref2"		=> Input::post("ref2"),
				"s_price"		=> Input::post("price"),
				"s_status"		=> Input::post("status"),
				"s_lot"			=> Input::post("lot"),
				"s_level"		=> Input::post("level"),
				"s_block"		=> Input::post("block"),
				"s_road"		=> Input::post("road"),
				"s_residential"	=> Input::post("residential"),
				"s_postcode"	=> Input::post("postcode"),
				"s_area"		=> Input::post("area"),
				"s_state"		=> Input::post("state"),
				"s_latitude"	=> Input::post("lat"),
				"s_longitude"	=> Input::post("lng"),
			]);
			
			Alert::set("success", "Maklumat gerai telah disimpan.",
			[
				"redirect"	=> PORTAL . "sewaan"
			]);
		}else{
			Alert::set("error", "Input Kawasan, No Fail & Alamat (No Lot, Jalan & Poskod) adalah wajib!");
		}
	break;
	
	case "delete":
		shop_user::deleteBy(["su_id" => url::get(3)]);
		
		Alert::set("success", "Maklumat gerai telah dipadam.", [
			"redirect"	=> PORTAL . "sewaan"
		]);
	break;
}

