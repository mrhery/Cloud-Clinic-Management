<div class="card">
	<div class="card-header">
		<a href="<?= PORTAL ?>medical-record" class="btn btn-sm btn-primary">
			<span class="fa fa-arrow-left"></span> Back
		</a> 
		Medical Records
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
	?>
			<table class="table dataTable table-fluid table-hover">
				<thead>
					<tr>
						<th width="5%">No</th>
						<th class="text-center" width="10%">Date</th>
						<th class="">Details</th>
						<th class="text-right">:::</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$no = 1;
					
					if(Session::get("admin")){
						$q = customer_record::getBy(["cr_customer" => $c->c_id], ["order" => "cr_id DESC"]);
					}else{
						$q = customer_record::getBy(["cr_customer" => $c->c_id, "cr_clinic" => Session::get("clinic")->c_id], ["order" => "cr_id DESC"]);
					}
					
					
					foreach ($q as $cr) {
				?>
						<tr>
							<td class="text-center"><?= $no++ ?></td>
							<td class="text-center">
								<?= date("d-M-Y H:i:s\ ", $cr->cr_time) ?><br />
								<small><?= $cr->cr_key ?></small>
							</td>
							<td>
								<?= $cr->cr_illness ?>
							</td>
							<td class="text-right">
								<a href="<?= PORTAL ?>medical-record/view/<?= url::get(2) ?>/<?= $cr->cr_key ?>" class="btn btn-sm btn-warning">
									<span class="fa fa-eye"></span> View
								</a>
							</td>
						</tr>
				<?php 
					} 
				?>
				</tbody>
			</table>
	<?php
		}
	?>
	</div>
</div>