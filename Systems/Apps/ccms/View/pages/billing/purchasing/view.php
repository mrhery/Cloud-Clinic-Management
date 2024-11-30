<?php
$p = purchases::getBy(["p_key" => url::get(3), "p_clinic" => Session::get("clinic")->c_id]);
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

<h4>Purchase Invoice</h4>

<?php
if(count($p) > 0){
	$p = $p[0];

?>
<div class="row">
	<div class="col-md-6 pos-rel">
		<strong>From (Client):</strong><br />
		<?php
			$c = clients::getBy(["c_id" => $p->p_client]);
			
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
		<?= $p->p_doc ?><br /><br />
		
		<strong>Remarks:</strong>
		<?= $p->p_remark ?><br />
	</div>
	
	<div class="col-md-6">
		<strong>Date:</strong> <?= $p->p_date ?><br />
		<br />
		
		<div class="row">
			<div class="col-md-6">
				<strong>Total (RM):</strong><br />
				<?= number_format($p->p_total, 2) ?><br /><br />
			</div>
			
			<div class="col-md-6">
				<strong>Paid (RM):</strong><br />
				<?= number_format($p->p_total, 2) ?><br /><br />
			</div>
		</div><br />
		
		<strong>Doc. Type:</strong> 
		<?php
			switch($p->p_type){
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
				foreach(purchase_item::getBy(["pi_purchase" => $p->p_id]) as $pi){
					$i = items::getBy(["i_id" => $pi->pi_item]);
					
					if(count($i) > 0){
						$i = $i[0];
			?>
				<tr>
					<td class="pos-rel">
						<input type="text" class="form-control" value="<?= $i->i_name ?>" placeholder="Search item" disabled />
						<br />
						
						Remark:
						<textarea class="form-control" placeholder="Remarks" disabled><?= $pi->pi_remark ?></textarea>
					</td>
					
					<td>
						<input type="number" class="form-control" step="0.01" placeholder="0.00" value="<?= $pi->pi_cost ?>" disabled />
					</td>
					
					<td>
						<input type="number" class="form-control" step="1" placeholder="0" value="<?= $pi->pi_quantity ?>" disabled />
					</td>
					
					<td>
						<input type="number" class="form-control" step="0.01" placeholder="0.00" value="<?= $pi->pi_total_cost ?>" disabled />
					</td>
				</tr>
			<?php					
					}
				}
			?>
			</tbody>
		</table>
	</div>
</div>
<?php
}else{
	new Alert("error", "No purchase record found.");
}
?>