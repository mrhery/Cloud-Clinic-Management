<div class="card">
	<div class="card-header">
		<a href="<?= PORTAL ?>medical-record/view/<?= url::get(2) ?>" class="btn btn-sm btn-primary">
			<span class="fa fa-arrow-left"></span> Back
		</a> 
		View Records
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
						<a class="nav-link active" data-toggle="tab" href="#menu1"><span class="fa fa-file"></span> Medical Remarks</a>
					</li>
				</ul>
				
				<div class="tab-content">
					<div class="tab-pane active mt-2" id="menu1">
						<h4>
							Medical Notes
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
						
						Prescription:						
						<table class="table table-hover table-fluid table-bordered mt-2">
							<thead>
								<tr>
									<th>Details</th>
									<th class="text-center" width="10%">Quantity</th>
									<th class="text-center" width="25%">Price</th>
									<th class="text-center" width="20%">Total</th>
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
									<td class="text-center"><?= number_format($rp->rp_frequency * $rp->rp_quantity, 2) ?></td>
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

<div id="image-viewer" style="display: none; position:fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1050; background-color: rgba(0, 0, 0, 0.8)">
	<img id="image-viewer-image" src="" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); height: auto; max-height: 100%; width: auto; max-width: 100%;" />
</div>

<button id="image-viewer-close" style="display: none; position:fixed; top: 10px; right: 10px; z-index: 1051;" class="btn btn-outline-danger">
	<span class="fa fa-close"></span> Close
</button>

<?php
Page::append(<<<HTML
<script>
$(document).on("click", ".attachment-file", function(){
	var src = $(this).children("img").attr("src");
	$("#image-viewer").show();
	$("#image-viewer-image").prop("src", src);
	$("#image-viewer-close").show();
});

$(document).on("click", "#image-viewer-close", function(){
	$("#image-viewer").hide();
	$("#image-viewer-image").prop("src", null);
	$("#image-viewer-close").hide();
});
</script>
HTML
);