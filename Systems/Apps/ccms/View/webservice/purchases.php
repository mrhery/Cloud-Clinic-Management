<?php

switch(url::get(2)){
	case "create":
		$data = Input::post("data");
		
		try {
			$obj = json_decode($data);
			/*
			client: $("#client").val(),
			no: $("#doc-no").val(),
			remark: $("#remark").val(),
			date: $("#date").val(),
			total: $("#total").val(),
			paid: $("#paid").val(),
			type: $("#type").val(),
			*/
			if(isset(
				$obj->client,
				$obj->no,
				$obj->remark,
				$obj->date,
				$obj->total,
				$obj->paid,
				$obj->type,
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
						
						purchases::insertInto([
							"p_client"	=> $c->c_id,
							"p_doc"		=> $obj->no,
							"p_date"	=> date("d-M-Y", strtotime($obj->date)),
							"p_time"	=> F::GetTime(),
							"p_key"		=> $pkey,
							"p_clinic"	=> Session::get("clinic")->c_id,
							"p_user"	=> Session::get("user")->u_id,
							"p_paid"	=> (double)$obj->paid
							"p_total"	=> (double)$obj->total,
							"p_remark"	=> $obj->remark,
							"p_status"	=> $status,
							"p_summary"	=> ""
						]);
						
						$p = purchases::getBy(["p_key" => $pkey, "p_clinic" => Session::get("clinic")->c_id]);
						
						if(count($p) > 0){
							$p = $p[0];
							
							
							foreach($obj->items as $item){
								$i = items::getBy(["i_key" => $item->id, "i_clinic" => Session::get("clinic")->c_id]);
								
								if(count($i) > 0){
									
								}else{
									
								}
							}
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