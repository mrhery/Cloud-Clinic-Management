<?php

switch(url::get(2)){
	case "create":
		$data = Input::post("data", false);
		
		try {
			$obj = json_decode($data);
			
			if(isset(
				$obj->client,
				$obj->no,
				$obj->remark,
				$obj->date,
				$obj->total,
				$obj->paid,
				$obj->doc_type,
				$obj->items
			)){
				$c = clients::getBy(["c_key" => $obj->client, "c_clinic" => Session::get("clinic")->c_id]);
				
				if(count($c)){
					$c = $c[0];
					
					if(is_array($obj->items) && count($obj->items) > 0){
						$pkey = F::uniqKey("purchase_");
						
						$status = "nil";
						
						if((double)$obj->paid < (double)$obj->total){
							$status = "partial";
						}
						
						if((double)$obj->paid >= (double)$obj->total){
							$status = "paid";
						}
						
						if((double)$obj->paid < 1 && (double)$obj->total > 0){
							$status = "unpaid";
						}
						
						$summary = "";
						$type = "";
						
						switch($obj->doc_type){
							default:
							case "invoice":
								$type = "in";
								$obj->doc_type = "invoice";
							break;
							
							case "credit_note":
								$type = "in";
								$obj->doc_type = "credit_note";
							break;
							
							case "debit_note":
								$type = "out";
								$obj->doc_type = "debit_note";
							break;
						}
						
						purchases::insertInto([
							"p_client"	=> $c->c_id,
							"p_doc"		=> $obj->no,
							"p_date"	=> date("d-M-Y", strtotime($obj->date)),
							"p_time"	=> F::GetTime(),
							"p_key"		=> $pkey,
							"p_clinic"	=> Session::get("clinic")->c_id,
							"p_user"	=> Session::get("user")->u_id,
							"p_paid"	=> (double)$obj->paid,
							"p_total"	=> (double)$obj->total,
							"p_remark"	=> $obj->remark,
							"p_status"	=> $status,
							"p_summary"	=> $summary,
							"p_type"	=> $obj->doc_type
						]);
						
						$p = purchases::getBy(["p_key" => $pkey, "p_clinic" => Session::get("clinic")->c_id]);
						
						if(count($p) > 0){
							$p = $p[0];
							
							foreach($obj->items as $item){
								$i = items::getBy(["i_key" => $item->id, "i_clinic" => Session::get("clinic")->c_id]);
								
								if(count($i) > 0){
									$i = $i[0];
								}else{
									$ikey = F::uniqKey("item_");
									$type = "product";
									
									if($item->qty <= 1){
										$type = "service";
									}
									
									items::insertInto([
										"i_key"			=> $ikey,
										"i_name"		=> $item->item_name,
										"i_cost"		=> (double)$item->cost,
										"i_quantity"	=> $item->qty,
										"i_clinic"		=> Session::get("clinic")->c_id,
										"i_user"		=> Session::get("user")->u_id,
										"i_type"		=> $type
									]);
									
									$i = items::getBy(["i_key" => $ikey]);
									
									if(count($i) > 0){
										$i = $i[0];
										define("NEW", true);
									}else{
										unset($i);
									}
								}
								
								if(isset($i)){
									$summary .= $i->i_name . " x" . $item->qty . "<br />";
									
									if($type == "in"){
										item_inventory::insertInto([
											"ii_item"		=> $i->i_id,
											"ii_date"		=> date("d-M-Y", strtotime($obj->date)),
											"ii_time"		=> F::GetTime(),
											"ii_quantity"	=> $item->qty,
											"ii_description"=> $item->remark,
											"ii_cost"		=> $item->cost,
											"ii_user"		=> Session::get("user")->u_id,
											"ii_clinic"		=> Session::get("clinic")->c_id
										]);
										
										if(!defined("NEW")){
											$ntotal = $i->i_quantity + $item->qty;
											
											items::updateBy(["i_key" => $i->i_key], ["i_quantity" => $ntotal]);
										}
									}else{
										item_inventory::insertInto([
											"ii_item"		=> $i->i_id,
											"ii_date"		=> date("d-M-Y", strtotime($obj->date)),
											"ii_time"		=> F::GetTime(),
											"ii_quantity"	=> (-1 * $item->qty),
											"ii_description"=> $item->remark,
											"ii_cost"		=> $item->cost,
											"ii_user"		=> Session::get("user")->u_id,
											"ii_clinic"		=> Session::get("clinic")->c_id
										]);
										
										if(!defined("NEW")){
											$ntotal = $i->i_quantity - $item->qty;
											
											items::updateBy(["i_key" => $i->i_key], ["i_quantity" => $ntotal]);
										}
									}
									
									purchase_item::insertInto([
										"pi_purchase"		=> $p->p_id,
										"pi_clinic"			=> Session::get("clinic")->c_id,
										"pi_item"			=> $i->i_id,
										"pi_quantity"		=> $item->qty,
										"pi_cost"			=> (double)$item->cost,
										"pi_total_cost"		=> (double)$item->total,
										"pi_remark"			=> $item->remark
									]);
								}
							}
							
							purchases::updateBy(["p_key" => $p->p_key], ["p_summary" => $summary]);
							
							die(json_encode([
								"status"	=> "success",
								"message"	=> "Purchase record has been created.",
								"data"		=> [
									"pid"	=> $p->p_key
								]
							]));
						}else{
							die(json_encode([
								"status" 	=> "error",
								"message"	=> "Fail creating purchase records."
							]));
						}
					}else{
						die(json_encode([
							"status" 	=> "error",
							"message"	=> "Purchase items is not valid."
						]));
					}
				}else{
					die(json_encode([
						"status" 	=> "error",
						"message"	=> "Client information is not valid."
					]));
				}
			}else{
				die(json_encode([
					"status"	=> "error",
					"message"	=> "Insufficient request parameters."
				]));
			}
		} catch(Exception $ex) {
			die(json_encode([
				"status"	=> "error",
				"message"	=> "Failed processing request from server."
			]));
		}
	break;
}