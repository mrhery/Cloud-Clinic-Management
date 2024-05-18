<?php

switch(url::get(2)){
	case "search":
		$x = Input::post("keyword");
		
		$i = DB::conn()->query("SELECT i_name as name, i_code as code, i_key as id FROM items WHERE (i_name LIKE ? OR i_description LIKE ? OR i_code = ? OR i_tag LIKE ?) AND i_clinic = ? LIMIT 30", [
				"%" . $x . "%",
				"%" . $x . "%",
				"%" . $x . "%",
				"%" . $x . "%",
				Session::get("clinic")->c_id
			]
		)->results();
		
		die(json_encode([
			"status"	=> "success",
			"data"		=> $i
		]));
	break;
	
	case "create-package":
		if(isset($_POST["json"])){
			$obj = json_decode($_POST["json"]);
			
			if(
				(isset($obj->name) && !empty($obj->name)) && 
				(isset($obj->code) && !empty($obj->code))
			){
				$i = items::getBy(["i_code" => $obj->code, "i_clinic" => Session::get("clinic")->c_id]);
				
				if(count($i) > 0){
					die(json_encode([
						"status"	=> "error",
						"code"		=> "PACKAGE_CODE_DUPLICATE",
						"message"	=> "Package code already exists."
					]));
				}else{
					$ikey = F::UniqKey("package_");
					
					items::insertInto([
						"i_name"		=> $obj->name,
						"i_clinic"		=> Session::get("clinic")->c_id,
						"i_user"		=> Session::get("user")->u_id,
						"i_description"	=> $obj->description,
						"i_code"		=> $obj->code,
						"i_sku"			=> $obj->sku,
						"i_type"		=> "package",
						"i_price"		=> $obj->price,
						"i_key"			=> $ikey,
						"i_cost"		=> 0
					]);
					
					$i = items::getBy(["i_key" => $ikey, "i_clinic" => Session::get("clinic")->c_id]);
					
					if(count($i) > 0){
						$i = $i[0];
						
						if(isset($obj->items) && is_array($obj->items)){
							foreach($obj->items as $item){
								$ix = items::getBy(["i_key" => $item->id, "i_clinic" => Session::get("clinic")->c_id]);
								
								if(count($ix) > 0){
									$ix = $ix[0];
									
									package_item::insertInto([
										"pi_item"  		=> $ix->i_id,
										"pi_package"	=> $i->i_id,
										"pi_name"		=> $item->name,
										"pi_price"		=> $item->price,
										"pi_quantity"	=> $item->quantity
									]);
								}else{
									$ixkey = F::UniqKey("item_");
									
									items::insertInto([
										"i_key"			=> $ixkey,
										"i_name"		=> $item->name,
										"i_price"		=> $item->price,
										"i_cost"		=> $item->price,
										"i_quantity"	=> $item->quantity,
										"i_type"		=> "product",
										"i_clinic"		=> Session::get("clinic")->c_id,
										"i_user"		=> Session::get("user")->u_id
									]);
									
									$ik = items::getBy(["i_key" => $ixkey, "i_clinic" => Session::get("clinic")->c_id]);
									
									if(count($ik) > 0){
										$ik = $ik[0];
										
										package_item::insertInto([
											"pi_item"  		=> $ik->i_id,
											"pi_package"	=> $i->i_id,
											"pi_name"		=> $item->name,
											"pi_price"		=> $item->price,
											"pi_quantity"	=> $item->quantity
										]);
									}
								}
							}
						}
						
						die(json_encode([
							"status"	=> "success",
							"message"	=> "Package has been created successfully.",
							"code"		=> "PACKAGE_CREATED",
							"data"		=> [
								"id"		=> $i->i_key
							]
						]));
					}else{
						die(json_encode([
							"status"	=> "error",
							"message"	=> "Package cannot be created at this moment.",
							"code"		=> "PACKAGE_NOT_CREATED"
						]));
					}
				}
			}else{
				die(json_encode([
					"status"	=> "error",
					"code"		=> "PACKAGE_CODE_NAME_ERROR",
					"message"	=> "Package name and code is required."
				]));
			}
		}
	break;
	
	case "update-package":
		if(isset($_POST["json"])){
			$obj = json_decode($_POST["json"]);
			
			if(
				(isset($obj->name) && !empty($obj->name)) && 
				(isset($obj->code) && !empty($obj->code))
			){
				$i = items::getBy(["i_key" => url::get(3), "i_clinic" => Session::get("clinic")->c_id]);
				
				if(count($i) > 0){
					$i = $i[0];
					
					items::updateBy(["i_id" => $i->i_id], [
						"i_name"		=> $obj->name,
						"i_user"		=> Session::get("user")->u_id,
						"i_description"	=> $obj->description,
						"i_code"		=> $obj->code,
						"i_sku"			=> $obj->sku,
						"i_price"		=> $obj->price,
						"i_cost"		=> 0
					]);
					
					package_item::deleteBy(["pi_package" => $i->i_id]);
					
					if(isset($obj->items) && is_array($obj->items)){
						foreach($obj->items as $item){
							$ix = items::getBy(["i_key" => $item->id, "i_clinic" => Session::get("clinic")->c_id]);
							
							if(count($ix) > 0){
								$ix = $ix[0];
								
								package_item::insertInto([
									"pi_item"  		=> $ix->i_id,
									"pi_package"	=> $i->i_id,
									"pi_name"		=> $item->name,
									"pi_price"		=> $item->price,
									"pi_quantity"	=> $item->quantity
								]);
							}
						}
					}
					
					die(json_encode([
						"status"	=> "success",
						"message"	=> "Package has been updated successfully.",
						"code"		=> "PACKAGE_UPDATED",
						"data"		=> [
							"id"		=> $i->i_key
						]
					]));
				}
			}else{
				die(json_encode([
					"status"	=> "error",
					"code"		=> "PACKAGE_CODE_NAME_ERROR",
					"message"	=> "Package name and code is required."
				]));
			}
		}
	break;
}