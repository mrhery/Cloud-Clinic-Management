<?php
switch(Input::post("action")){
	case "add":
		if(!empty(Input::post("name")) && !empty(Input::post("address"))){
			shop_group::insertInto([
				"sg_name"			=> Input::post("name"),
				"sg_description"	=> Input::post("description"),
				"sg_address"		=> Input::post("address"),
				"sg_main"			=> Input::post("main"),
				"sg_lat"			=> Input::post("lat"),
				"sg_lng"			=> Input::post("lng"),
				"sg_note"			=> Input::post("note"),
				"sg_status"			=> Input::post("status"),
				"sg_key"			=> F::UniqKey("SG_")
			]);
			
			Alert::set("success", "Maklumat kawasan telah disimpan.");
		}else{
			Alert::set("error", "Nama & alamat kawasan adalah wajib!");
		}
	break;
	
	case "edit":
		//perlu handle upload gambar
		if(!empty(Input::post("name")) && !empty(Input::post("address"))){
			shop_group::updateBy(["sg_id" => url::get(3)], [
				"sg_name"			=> Input::post("name"),
				"sg_description"	=> Input::post("description"),
				"sg_address"		=> Input::post("address"),
				"sg_main"			=> Input::post("main"),
				"sg_lat"			=> Input::post("lat"),
				"sg_lng"			=> Input::post("lng"),
				"sg_note"			=> Input::post("note"),
				"sg_status"			=> Input::post("status")
			]);
			
			Controller::set("autoRefresh", false);			
			new Alert("success", "Maklumat kawasan telah disimpan.");
		}else{
			Alert::set("error", "Nama & alamat kawasan adalah wajib!");
		}
	break;
	
	case "delete":
		shop_group::deleteBy(["sg_id" => url::get(3)]);
		
		Alert::set("success", "Maklumat kawasan sudah dipadam.", [
			"redirect"	=> PORTAL . "gerai/kawasan-perniagaan/"
		]);
	break;

	case 'tambah_maklumat':
		if(
			Input::post("group") > 0 && 
			!empty(Input::post("fileno")) && 
			!empty(Input::post("lot")) && 
			!empty(Input::post("road")) && 
			!empty(Input::post("postcode")) 
		){
			
			shops::insertInto([
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
				"s_key"			=> F::UniqKey("SHOP_")
			]);
			
			Alert::set("success", "Maklumat gerai telah disimpan.");
		}else{
			Alert::set("error", "Input Kawasan, No Fail & Alamat (No Lot, Jalan & Poskod) adalah wajib!");
		}

	break;
	
	case "add_complaint":
		if(!empty(Input::post("complaint")))
		{
			complaint::insertInto([
				"cp_sg"				=>	url::get(3),
				"cp_date"			=>	date("Y-m-d h:m:s"),
				"cp_complaint"		=>	Input::post("complaint"),
				"cp_user"			=> 	Session::get('user')->u_id,
			]);
			
			Alert::set("success", "Maklumat aduan telah disimpan.");
		}
		else{
			Alert::set("error", "Wajib isi maklumat aduan!");
		}
		
	break;
}

