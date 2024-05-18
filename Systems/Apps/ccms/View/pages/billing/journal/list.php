

<div class="card">
	<div class="card-header">
		<span class="fa fa-list"></span> Journal Records
		
		<a href="<?= PORTAL ?>billing/journal/add" class="btn btn-sm btn-primary">
			<span class="fa fa-plus"></span> Add Record
		</a>
	</div>
	
	<div class="card-body">
		<table class="table table-hover table-fluid table-bordered dataTable">
			<thead>
				<tr>
					<th width="15%" class="text-center">Date</th>
					<th>Particulars</th>
					<th width="5%" class="text-center">L.F.</th>
					<th width="15%" class="text-right">Debit (RM)</th>
					<th width="15%" class="text-right">Credit (RM)</th>
				</tr>	
			</thead>
			
			<tbody>
			<?php
				$accounts = [];
				
				foreach(accounts::getBy(["a_business" => Session::get("clinic")->c_id]) as $a){
					$accounts[$a->a_id] = $a->a_name;
				}
				
				foreach(records::getBy(["r_business" => Session::get("clinic")->c_id]) as $r){
				?>
				<tr>
					<td class="text-center">
						<?= date("d-M-Y", strtotime($r->r_date)) ?>
					</td>
					
					<td>
					<?php
						if(isset($accounts[$r->r_dr_account])){
							echo $accounts[$r->r_dr_account];
						}else{
							echo "- Unknown -";
						}
						
						echo "<br />&nbsp;&nbsp;&nbsp;&nbsp;";
						
						if(isset($accounts[$r->r_cr_account])){
							echo $accounts[$r->r_cr_account];
						}
						echo "<hr />";
						
						echo $r->r_description;
					?>
					</td>
					
					<td class="text-center"></td>
					<td class="text-right"><?= number_format($r->r_amount, 2) ?></td>
					<td class="text-right"><br /><?= number_format($r->r_amount, 2) ?></td>
				</tr>
				<?php
				}
			?>
			</tbody>
		</table>
	</div>
</div>