<?php

switch(Input::post("action")){
	case "update":
		if(!empty(Input::post("doc"))){
			$crs = customer_record::getBy(["cr_key" => Input::post("doc"), "cr_clinic" => Session::get("clinic")->c_id]);
			
			if(count($crs) > 0){
				$cr = $crs[0];
				
				customer_record::updateBy(["cr_id" => $cr->cr_id], [
					"cr_illness"		=> Input::post("illness"),
					"cr_examination"	=> Input::post("examination"),
					"cr_investigation"	=> Input::post("investigation"),
					"cr_diagnosis"		=> Input::post("diagnosis"),
					"cr_plan"			=> Input::post("plan"),
					"cr_time"			=> F::GetTime(),
					"cr_user"			=> Session::get("user")->u_id,
					"cr_clinic"			=> Session::get("clinic")->c_id,
					"cr_date"			=> F::GetDate()
				]);
				
				record_prescription::deleteBy(["rp_record" => $cr->cr_id]);
				
				if(!empty(Input::post("prescription"))){
					$o = json_decode(Input::post("prescription", false));
					
					if(count($o) > 0){
						foreach($o as $x){
							if(isset($x->item)){
								$i = items::getBy(["i_key" => $x->item]);
							
								if(count($i) > 0){
									$i = $i[0];
									
									record_prescription::insertInto([
										"rp_item"			=> $i->i_id,
										"rp_quantity"		=> $x->quantity,
										"rp_remarks"		=> $x->remarks,
										"rp_record"			=> $cr->cr_id,
										"rp_frequency"		=> $x->freq,
										"rp_time"			=> F::GetTime()
									]);
								}
							}
						}
					}
				}
				
				die(json_encode([
					"status"	=> "success",
					"data"		=> date("d M Y H:i:s\ ")
				]));
			}else{
				$c = customers::getBy(["c_ukey" => Input::post("customer")]);
				
				if(count($c) > 0){
					$c = $c[0];
					customer_record::insertInto([
						"cr_key"			=> Input::post("doc"),
						"cr_illness"		=> Input::post("illness"),
						"cr_examination"	=> Input::post("examination"),
						"cr_investigation"	=> Input::post("investigation"),
						"cr_diagnosis"		=> Input::post("diagnosis"),
						"cr_plan"			=> Input::post("plan"),
						"cr_time"			=> F::GetTime(),
						"cr_user"			=> Session::get("user")->u_id,
						"cr_clinic"			=> Session::get("clinic")->c_id,
						"cr_date"			=> F::GetDate(),
						"cr_customer"		=> $c->c_id
					]);
					
					$cr = customer_record::getBy(["cr_key" => Input::post("doc"), "cr_clinic" => Session::get("clinic")->c_id]);
					
					if(count($cr) > 0){
						$cr = $cr[0];
						
						if(!empty(Input::post("prescription"))){
							$o = json_decode(Input::post("prescription", false));
							
							if(count($o) > 0){
								foreach($o as $x){
									$i = items::getBy(["i_key" => $x->item]);
									
									if(count($i) > 0){
										$i = $i[0];
										
										record_prescription::insertInto([
											"rp_item"			=> $i->i_id,
											"rp_quantity"		=> $x->quantity,
											"rp_remarks"		=> $x->remarks,
											"rp_record"			=> $cr->cr_id,
											"rp_frequency"		=> $x->freq,
											"rp_time"			=> F::GetTime()
										]);
									}
								}
							}
						}
					}
					
					die(json_encode([
						"status"	=> "success",
						"data"		=> date("d M Y H:i:s\ ")
					]));
				}
			}
			
			die(json_encode([
				"status"	=> "error",
				"data"		=> date("d M Y H:i:s\ ")
			]));
		}else{
			die(json_encode([
				"status"	=> "error",
				"message"	=> "Doc number is not available."
			]));
		}
	break;
}