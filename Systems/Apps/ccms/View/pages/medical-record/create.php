

<?php
$c = customers::getBy(["c_ic" => Input::get("ic")]);

if(count($c) > 0){
	$c = $c[0];
	
	$doc = Input::get("doc");
	
	if(empty($doc)){
		$doc = "doc-" . date("Ymd") . Session::get("clinic")->c_id . "-" . F::UniqId(6);
	}
	
	$d = customer_record::getBy(["cr_key" => $doc, "cr_clinic" => Session::get("clinic")->c_id, "cr_customer" => $c->c_id]);
	
	if(count($d) > 0){
		$d = $d[0];
	}else{
		$d = null;
	}
}else{
	$c = null;
}
?>

<div class="row">
	<div class="col-md-12">
		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#home"><span class="fa fa-user"></span> 
					Patient Information
				</a>
			</li>
		
		<?php
			if(!is_null($c)){
		?>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#menu1"><span class="fa fa-file"></span> Medical Remarks</a>
			</li>
			
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#menu2"><span class="fa fa-folder"></span> History</a>
			</li>
		<?php
			}
		?>
		</ul>
		
		<div class="tab-content">
			<div class="tab-pane active mt-2" id="home">
				<div class="row">
					<div class="col-md-7">
						<?php
							if(!is_null($c)){
						?>
							Name:
							<input type="text" class="form-control" name="name" placeholder="Name" value="<?= $c->c_name ?>" disabled /><br />	
							
							Phone:
							<input type="tel" class="form-control" name="phone" placeholder="+60 1..." value="<?= $c->c_phone ?>" disabled /><br />
							
							Email:
							<input type="email" class="form-control" name="email" placeholder="example@abc.com" value="<?= $c->c_email ?>" disabled /><br />

							IC:
							<input type="ic" class="form-control" name="ic" placeholder="Enter Identification Card No" value="<?= $c->c_ic ?>" disabled /><br />

						<?php
							}else{
								// do nothing
							}
						?>
					</div>
				</div>
			</div>
		
		<?php
			if(!is_null($c)){
		?>
			<div class="tab-pane fade mt-2" id="menu1">
			<?php
				if(!is_null($d)){
				?>
				<h4>
					Medical Notes
				</h4>
				
				<small id="saved-status">(last saved at <?= date("d M Y H:i:s\ ", $d->cr_time) ?>)</small><br >
				<hr />
				
				Remarks:
				<textarea class="form-control" id="illness" Placeholder="Underlying Illness..."><?= $d->cr_illness ?></textarea><br />
				
				<!---->
				History of Presenting Illness / Examination:
				<textarea class="form-control" id="examination" Placeholder="History of Presenting Illness..."><?= $d->cr_examination ?></textarea><br />
				
				Investigations:
				<textarea class="form-control" id="investigation" Placeholder="Investigations..."><?= $d->cr_investigation ?></textarea><br />
				
				Diagnosis:
				<textarea class="form-control" id="diagnosis" Placeholder="Diagnosis..."><?= $d->cr_diagnosis ?></textarea><br />
				
				Plans:
				<textarea class="form-control" id="plan" Placeholder="Plans..."><?= $d->cr_plan ?></textarea><br />
				
				Prescriptions: 
				<button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#add-prescription">
					<span class="fa fa-plus"></span> Add Prescription
				</button>
				
				<table class="table table-hover table-fluid table-bordered mt-2">
					<thead>
						<tr>
							<th>Details</th>
							<th class="text-center" width="10%">Quantity</th>
							<th class="text-right" width="25%">Price (RM)</th>
							<th class="text-right" width="20%">Total (RM)</th>
							<th class="text-right" width="5%">::</th>
						</tr>
					</thead>
					
					<tbody id="list-pres">
					<?php
						$rps = record_prescription::getBy(["rp_record" => $d->cr_id]);
						
						foreach($rps as $rp){
							$i = items::getBy(["i_id" => $rp->rp_item]);
							
							if(count($i) > 0){
								$i = $i[0];
							}else{
								$i = null;
							}
						?>
						<tr id="pres-<?= $rp->rp_id ?>" data-id="<?= $rp->rp_id ?>">
							<td>
								<?= is_null($i) ? "<i>Item not found</i>" : $i->i_name ?><br />
								<?= $rp->rp_remarks ?>
								<input type="hidden" value="<?= is_null($i) ? "" : $i->i_key ?>" class="pres-<?= $rp->rp_id ?>-id" />
							</td>
							
							<td class="text-center pres-<?= $rp->rp_id ?>-quantity" contenteditable="true">
								<?= $rp->rp_quantity ?>
							</td>
							
							<td class="text-center pres-<?= $rp->rp_id ?>-freq" contenteditable="true">
								<?= $rp->rp_frequency ?>
							</td>
							
							<td class="text-center pres-<?= $rp->rp_id ?>-remarks" contenteditable="true">
								<?= $rp->rp_quantity * $rp->rp_frequency  ?>
							</td>
							
							<td class="text-center">
								<button class="btn btn-sm btn-danger del-prescription" type="button">
									<span class="fa fa-trash"></span>
								</button>
							</td>
						</tr>
						<?php
						}
					?>
					</tbody>
				</table>
				<?php
				}else{
				?>
				<h4>
					Medical Notes
				</h4>
				
				<small id="saved-status">(not saved yet - <?= $doc ?>)</small><br >
				<hr />
				
				Description:
				<textarea class="form-control" id="illness" Placeholder="Description"></textarea><br />
				
				<!---->
				History of Presenting Illness / Examination:
				<textarea class="form-control" id="examination" Placeholder="History of Presenting Illness..."></textarea><br />
				
				Investigations:
				<textarea class="form-control" id="investigation" Placeholder="Investigations..."></textarea><br />
				
				Diagnosis:
				<textarea class="form-control" id="diagnosis" Placeholder="Diagnosis..."></textarea><br />
				
				Plans:
				<textarea class="form-control" id="plan" Placeholder="Plans..."></textarea><br />
				
				Service Item: 
				<button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#add-prescription">
					<span class="fa fa-plus"></span> Item
				</button>
				
				<table class="table table-hover table-fluid table-bordered mt-2">
					<thead>
						<tr>
							<th>Details</th>
							<th class="text-center" width="10%">Quantity</th>
							<th class="text-right" width="25%">Price (RM)</th>
							<th class="text-right" width="20%">Total (RM)</th>
							<th class="text-right" width="5%">::</th>
						</tr>
					</thead>
					
					<tbody id="list-pres">
					</tbody>
				</table>
				<?php
				}
			?>
				<div style="height: 140px; border: 1px solid #ced4da; margin-bottom: 20px; overflow-y: scroll; padding: 10px; white-space: nowrap;" id="list-attachment">							
					<div style="border: 1px solid #ced4da; height: 115px; width: 150px; cursor: pointer; position: relative; margin-right: 10px; margin-bottom: 10px; float: left;">
						<label for="upload-attachment" style="width: 100%; height: 100%; position: absolute; text-align: center; top: 50%; left: 50%;  transform: translate(-50%, -50%); cursor: pointer;">	
							<input id="upload-attachment" onchange="upload_attachment()" type="file" name="attachment[]" accept="image/*,application/pdf" multiple style="visibility: hidden;" />
							
							<div style="">
								<span class="fa fa-plus"></span><br />
								Upload File(s)
							</div>
						</label>
					</div>							
				</div>
				
				<div class="text-center">
					<button type="button" class="btn btn-success usp-popup-window-close-this">
						<span class="fa fa-save"></span> Save & Close
					</button>
				</div>
			</div>
			
			<div class="tab-pane fade mt-2" id="menu2">
				<h4>History</h4>
				<?php
					$crs = customer_record::getBy(["cr_customer" => $c->c_id, "cr_clinic" => Session::get("clinic")->c_id], ["order" => "cr_id DESC", "limit" => 10]);
					
					foreach($crs as $cr){
						$u = users::getBy(["u_id" => $cr->cr_user]);	
						
						if(count($u) > 0){
							$u = $u[0];
						}else{
							$u = null;
						}
					?>
					<div class="card mb-3 shadow usp-right-sheet usp-popup-window-minimize-this" href="<?= PORTAL ?>medical-record/view/<?= $c->c_ukey ?>/<?= $cr->cr_key ?>">
						<div class="card-body">
							<b><?= $cr->cr_date ?> <?= date("H:i:s\ ", $cr->cr_time) ?></b> by <span class="badge badge-primary"><?= !is_null($u) ? $u->u_name : "NIL" ?></span><br />
							
							<?= $cr->cr_illness ?>
						</div>
					</div>
					<?php
					}
				?>
			</div>
		<?php
			}
		?>
			
			
		</div>
	</div>
</div>


<div class="modal fade" id="show-record">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span class="fa fa-eye"></span> View Record</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<div class="modal-body" id="record-content"></div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="add-prescription">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span class="fa fa-plus"></span> Add Item</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			<div class="modal-body">
				Search Item:
				<input type="text" class="form-control" id="pres-add-name" placeholder="Search" />
				<div id="search-pres-box" style="display: none;"></div>
				<br />
				
				<input type="hidden" id="pres-add-id" />
				
				Quantity:
				<input type="number" id="pres-add-quantity" class="form-control" value="1" /><br />
				
				Price:
				<input type="number" id="pres-add-freq" step="0.01" class="form-control" placeholder="0.00" /><br />
				
				Remarks:
				<input type="text" id="pres-add-remarks" class="form-control" placeholder="Remarks" /><br />
				
				<button class="btn btn-sm btn-success" id="add-to-list-pres">
					<span class="fa fa-plus"></span> Add List
				</button>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div id="image-viewer" style="display: none; position:fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1050; background-color: rgba(0, 0, 0, 0.8)">
	<img id="image-viewer-image" src="" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); height: auto; max-height: 100%; width: auto; max-width: 100%;" />
</div>

<button id="image-viewer-close" style="display: none; position:fixed; top: 10px; right: 10px; z-index: 1051;" class="btn btn-outline-danger">
	<span class="fa fa-close"></span> Close
</button>

<?php
if(!isset($doc)){
	$doc = "";
}

if(!is_null($c)){
	if(!isset($doc)){
		$doc = "doc-" . date("Ymd") . Session::get("clinic")->c_id . "-" . F::UniqId(6);
	}
}
?>
<script>
selected_doc = "<?= $doc ?>";
selected_customer_id = "<?= $c->c_ukey ?>";
</script>