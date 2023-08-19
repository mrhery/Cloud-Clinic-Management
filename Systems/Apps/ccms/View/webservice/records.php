<?php

switch(Input::post("action")){
	case "view":
		$doc = Input::post("doc");
		$customer = Input::post("customer");
		
		$c = customers::getBy(["c_ukey" => $customer]);
		
		if(count($c) > 0){
			$c = $c[0];
			
			$cr = customer_record::getBy(["cr_customer" => $c->c_id, "cr_key" => $doc, "cr_clinic" => Session::get("clinic")->c_id]);
			
			if(count($cr) > 0){
				$cr = $cr[0];
				
				$u = users::getBy(["u_id" => $cr->cr_user]);			

				if(count($u) > 0){
					$u = $u[0];
				}else{
					$u = null;
				}
			?>
			<h4>
				Clinical Notes
				<small>by <?= !is_null($u) ? $u->u_name : "NIL" ?></small>
			</h4>
			
			<small id="saved-status">(not saved yet - <?= $cr->cr_key ?>)</small><br >
			<hr />
			
			Underlying Illness / Remarks:
			<textarea class="form-control" id="illness" Placeholder="" disabled><?= $cr->cr_illness ?></textarea><br />
			
			History of Presenting Illness / Examination:
			<textarea class="form-control" id="examination" Placeholder="" disabled><?= $cr->cr_examination ?></textarea><br />
			
			Investigations:
			<textarea class="form-control" id="investigation" Placeholder="" disabled><?= $cr->cr_investigation ?></textarea><br />
			
			Diagnosis:
			<textarea class="form-control" id="diagnosis" Placeholder="" disabled><?= $cr->cr_diagnosis ?></textarea><br />
			
			Plans:
			<textarea class="form-control" id="plan" Placeholder="" disabled><?= $cr->cr_plan ?></textarea><br />
			
			Prescriptions:						
			<table class="table table-hover table-fluid table-bordered mt-2">
				<thead>
					<tr>
						<th>Details</th>
						<th class="text-center" width="10%">Quantity</th>
						<th class="text-center" width="25%">Frequency / Duration</th>
						<th class="text-center" width="20%">Remarks</th>
					</tr>
				</thead>
				
				<tbody id="list-pres">
				<?php
					foreach(record_prescription::getBy(["rp_record" => $cr->cr_id]) as $rp){
						$i = items::getBy(["i_id" => $rp->rp_item]);
						
						if(count($i) > 0){
							$i = $i[0];
						}else{
							$i = null;
						}
					?>
					<tr id="pres-'+ rid +'" data-id="'+ rid +'">
						<td>
							<?= !is_null($i) ? $i->i_name : "NIL" ?>
						</td>
						<td class="text-center"><?= $rp->rp_quantity ?></td>
						<td class="text-center"><?= $rp->rp_frequency ?></td>
						<td class="text-center"><?= $rp->rp_remarks ?></td>
					</tr>
					<?php
					}
				?>
				</tbody>
			</table>
			<?php
			}else{
				die("No record found");
			}
		}else{
			die("No customer found.");
		}
	break;
	
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