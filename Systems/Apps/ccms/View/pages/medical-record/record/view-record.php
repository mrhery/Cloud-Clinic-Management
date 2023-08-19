<div class="card">
	<div class="card-header">
		<a href="<?= PORTAL ?>medical-record/view/<?= url::get(2) ?>" class="btn btn-sm btn-primary">
			<span class="fa fa-arrow-left"></span> Back
		</a> 
		View Medical Records
	</div>
	
	<div class="card-body">
	<?php
		if(Session::get("admin")){
			$c = customers::getBy(["c_ukey" => url::get(2)]);
		}else{
			$c = customers::getBy(["c_ukey" => url::get(2), "c_id" => function($column){
				return "$column IN (SELECT cc_customer FROM clinic_customer WHERE cc_clinic = '". Session::get("clinic")->c_id ."')";
			}]);
		}
		
		if(count($c) > 0){
			$c = $c[0];
			
			if(Session::get("admin")){
				$q = customer_record::getBy(["cr_customer" => $c->c_id, "cr_key" => url::get(3)]);
			}else{
				$q = customer_record::getBy(["cr_customer" => $c->c_id, "cr_key" => url::get(3), "cr_clinic" => Session::get("clinic")->c_id]);
			}
			
			if(count($q) > 0){
				$cr = $q[0];
				
				$u = users::getBy(["u_id" => $cr->cr_user]);			

				if(count($u) > 0){
					$u = $u[0];
				}else{
					$u = null;
				}
			?>
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#menu1"><span class="fa fa-file"></span> Clinical Notes</a>
					</li>
				</ul>
				
				<div class="tab-content">
					<div class="tab-pane active mt-2" id="menu1">
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
					</div>
				</div>
			<?php
			}else{
				new Alert("info", "No medical record found. Please make sure you select a correct medical record.");
			}
				
		}
	?>
	</div>
</div>