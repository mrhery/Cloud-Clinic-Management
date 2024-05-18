<?php
$s = sales::getBy(["s_key" => url::get(3), "s_clinic" => Session::get("clinic")->c_id]);
?>
<style>
.pos-rel {
	position: relative;
}

.item-search-container {
	position: absolute;
	width: 100%;
	background-color: rgba(0, 0, 0, 0.8);
	z-index: 1001;
}

.item-search-row {
	padding: 10px;
	color: white;
	cursor: pointer;
}

.item-search-row:hover {
	background-color: black;
}

.close-search {
	cursor: pointer;
}

#client-search-container{
	position: absolute;
	width: 100%;
	background-color: rgba(0, 0, 0, 0.8);
	z-index: 1001;
	display: none;
}

.client-search-row {
	padding: 10px;
	color: white;
	cursor: pointer;
}

.client-search-row:hover {
	background-color: black;
}

.close-client-search {
	cursor: pointer;
}
</style>

<div class="card">
    <div class="card-header">
       <a href="<?= PORTAL ?>billing/sales" class="btn btn-primary btn-sm">
			<span class="fa fa-arrow-left"></span> Back
		</a>

		Sales Records
    </div>

    <div class="card-body">
	<?php
		if(count($s) > 0){
			$s = $s[0];
		
	?>
		<div class="row">
			<div class="col-md-6 pos-rel">
				<strong>From (Patient):</strong><br />
				<?php
					$c = customers::getBy(["c_id" => $s->s_client]);
					
					if(count($c) > 0){
						$c = $c[0];
					?>
					<strong><?= $c->c_name ?></strong><br />
					<span><?= $c->c_address ?></span><br />
					<span><?= $c->c_phone ?> | <?= $c->c_email ?></span><br />
					<?php
					}else{
						unset($c);
						echo "-";
					}
				?>
				
				<br />
				<strong>Document No:</strong><br />
				<?= $s->s_doc ?><br /><br />
				
				<strong>Remarks:</strong>
				<?= $s->s_remark ?><br />
			</div>
			
			<div class="col-md-6">
				<strong>Date:</strong> <?= $s->s_date ?><br />
				<br />
				
				<div class="row">
					<div class="col-md-6">
						<strong>Total (RM):</strong><br />
						<?= number_format($s->s_total, 2) ?><br /><br />
					</div>
					
					<div class="col-md-6">
						<strong>Paid (RM):</strong><br />
						<?= number_format($s->s_paid, 2) ?><br /><br />
					</div>
				</div><br />
				
				<strong>Doc. Type:</strong> 
				<?php
					switch($s->s_type){
						default:
						case "invoice":
							echo "Invoice";
						break;
						
						case "credit_note":
							echo "Credit Note";
						break;
						
						case "debit_note":
							echo "Debit Note";
						break;
					}
				?><br />
			</div>
			
			<div class="col-md-12 mb-3">
				<hr />
				
				<table class="table table-hover table-bordered table-fluid">
					<thead>
						<tr>
							<th>Item</th>
							<th class="text-right" width="15%">Cost</th>
							<th class="text-center" width="15%">Qty</th>
							<th class="text-right" width="20%">Total</th>
						</tr>
					</thead>
					
					<tbody>
					<?php
						foreach(sale_item::getBy(["si_purchase" => $s->s_id]) as $si){
							$i = items::getBy(["i_id" => $si->si_item]);
							
							if(count($i) > 0){
								$i = $i[0];
					?>
						<tr>
							<td class="pos-rel">
								<input type="text" class="form-control" value="<?= $i->i_name ?>" placeholder="Search item" disabled />
								<br />
								
								Remark:
								<textarea class="form-control" placeholder="Remarks" disabled><?= $si->si_remark ?></textarea>
							</td>
							
							<td>
								<input type="number" class="form-control" step="0.01" placeholder="0.00" value="<?= $si->si_cost ?>" disabled />
							</td>
							
							<td>
								<input type="number" class="form-control" step="1" placeholder="0" value="<?= $si->si_quantity ?>" disabled />
							</td>
							
							<td>
								<input type="number" class="form-control" step="0.01" placeholder="0.00" value="<?= $si->si_total_cost ?>" disabled />
							</td>
						</tr>
					<?php					
							}
						}
					?>
					</tbody>
				</table>
				<div class="text-center">
					<a href="<?= PORTAL ?>webservice/sales/print/<?= $s->s_key ?>" class="btn btn-success">Print</a>
				</div>
			</div>
		</div>
	<?php
		}else{
			new Alert("error", "No purchase record found.");
		}
	?>
	</div>
</div>