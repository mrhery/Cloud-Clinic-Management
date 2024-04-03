<?php

switch(Input::post("action")){
	case "update_image":
		if(!empty(Input::post("doc"))){
			$crs = customer_record::getBy(["cr_key" => Input::post("doc"), "cr_clinic" => Session::get("clinic")->c_id]);
			
			if(count($crs) > 0){
				$cr = $crs[0];
				
				if(strlen(Input::post("data")) > 0){
					$fname = F::UniqKey("record_");
				
					$path = ASSET . "records/" . $cr->cr_key . "/";
					
					if(!is_dir($path)){
						mkdir($path, 0777, true);
					}
					
					$o = fopen($path . $fname, "w+");
					fwrite($o, Input::post("data"));
					fclose($o);
					
					record_file::insertInto([
						"rf_record"	=> $cr->cr_id,
						"rf_file"	=> $fname,
						"rf_fileid"	=> Input::post("ufid"),
						"rf_original_name"	=> Input::post("name"),
					]);
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
						
						if(strlen(Input::post("data")) > 0){
							$fname = F::UniqKey("record_");
						
							$path = ASSET . "records/" . $cr->cr_key . "/";
							
							if(!is_dir($path)){
								mkdir($path, 0777, true);
							}
							
							$o = fopen($path . $fname, "w+");
							fwrite($o, Input::post("data"));
							fclose($o);
							
							record_file::insertInto([
								"rf_record"	=> $cr->cr_id,
								"rf_file"	=> $fname,
								"rf_fileid"	=> Input::post("ufid"),
								"rf_original_name"	=> Input::post("name"),
							]);
						}
					}
					
					die(json_encode([
						"status"	=> "success",
						"data"		=> date("d M Y H:i:s\ "),
						""
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
				Service Notes
				<small>by <?= !is_null($u) ? $u->u_name : "NIL" ?></small>
			</h4>
			
			<small id="saved-status">(not saved yet - <?= $cr->cr_key ?>)</small><br >
			<hr />
			
			Remarks:
			<textarea class="form-control" id="illness" Placeholder="" disabled><?= $cr->cr_illness ?></textarea><br />
			
			<!--History of Presenting Illness / Examination:
			<textarea class="form-control" id="examination" Placeholder="" disabled><?= $cr->cr_examination ?></textarea><br />
			
			Investigations:
			<textarea class="form-control" id="investigation" Placeholder="" disabled><?= $cr->cr_investigation ?></textarea><br />
			
			Diagnosis:
			<textarea class="form-control" id="diagnosis" Placeholder="" disabled><?= $cr->cr_diagnosis ?></textarea><br />
			
			Plans:
			<textarea class="form-control" id="plan" Placeholder="" disabled><?= $cr->cr_plan ?></textarea><br />-->
			
			Items:						
			<table class="table table-hover table-fluid table-bordered mt-2">
				<thead>
					<tr>
						<th>Details</th>
						<th class="text-center" width="10%">Quantity</th>
						<th class="text-right" width="25%">Price (RM)</th>
						<th class="text-right" width="20%">Total (RM)</th>
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
							<?= !is_null($i) ? $i->i_name : "NIL" ?><br />
							<?= $rp->rp_remarks ?>
						</td>
						<td class="text-center"><?= $rp->rp_quantity ?></td>
						<td class="text-center"><?= number_format($rp->rp_frequency, 2) ?></td>
						<td class="text-center"><?= number_format($rp->rp_quantity * $rp->rp_frequency, 2) ?></td>
					</tr>
					<?php
					}
				?>
				</tbody>
			</table>
			
			
			<div style="height: 170px; border: 1px solid #ced4da; margin-bottom: 20px; overflow-y: scroll; padding: 10px; white-space: nowrap;" class="mt-2">				
			<?php
				$path = ASSET . "records/" . $cr->cr_key . "/";
				foreach(record_file::getBy(["rf_record" => $cr->cr_id]) as $rf){
					if(file_exists($path . $rf->rf_file)){
						$bin = file_get_contents($path . $rf->rf_file);
				?>
					<div 
						class="attachment-file" 
						style="margin-bottom: 10px; border: 1px solid #ced4da; height: 115px; width: 150px; cursor: pointer; position: relative; margin-right: 10px; overflow: hidden; float: left;"
					>
						<img src="<?= $bin ?>" style="height: auto; width: 100%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" />
					</div>
				<?php
					}
				}
			?>
			</div>
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