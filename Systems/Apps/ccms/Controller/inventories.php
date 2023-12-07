<?php

switch(Input::post("action")){
	case "add":
		if(!empty(Input::post("name"))){
			$type = Input::post("type") == "product" ? "product" : "service";
			
			items::insertInto([
				"i_name"		=> Input::post("name"),
				"i_clinic"		=> Session::get("clinic")->c_id,
				"i_user"		=> Session::get("user")->u_id,
				"i_description"	=> Input::post("description"),
				"i_code"		=> Input::post("code"),
				"i_sku"			=> Input::post("sku"),
				"i_type"		=> $type,
				"i_price"		=> Input::post("price"),
				"i_key"			=> F::uniqKey("item_"),
				"i_cost"		=> Input::post("cost")
			]);
			
			Alert::set("success", "Item information has beed saved.");
		}else{
			Alert::set("error", "Item name is required.");
		}
	break;
	
	case "edit":
		if(!empty(Input::post("name"))){
			$type = Input::post("type") == "product" ? "product" : "service";
			
			items::updateBy(["i_key" => url::get(2), "i_clinic" => Session::get("clinic")->c_id], [
				"i_name"		=> Input::post("name"),
				"i_user"		=> Session::get("user")->u_id,
				"i_description"	=> Input::post("description"),
				"i_code"		=> Input::post("code"),
				"i_sku"			=> Input::post("sku"),
				"i_type"		=> $type,
				"i_price"		=> Input::post("price"),
				"i_cost"		=> Input::post("cost")
			]);
			
			Alert::set("success", "Item information has beed saved.");
		}else{
			Alert::set("error", "Item name is required.");
		}
	break;
}
