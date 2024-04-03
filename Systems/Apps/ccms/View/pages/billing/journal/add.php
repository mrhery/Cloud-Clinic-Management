

<div class="card">
	<div class="card-header">
		<a href="<?= PORTAL ?>billing/journal" class="btn btn-sm btn-primary">
			<span class="fa fa-arrow-left"></span> Back
		</a> 
		Add Journal Record
	</div>
	
	<div class="card-body">
		<form action="" method="POST" enctype="multipart/form-data">
			<table class="table table-hover table-fluid table-bordered mb-4">
				<thead>
					<tr>
						<th width="15%" class="text-center">Date</th>
						<th>Particulars</th>
						<th width="5%" class="text-center">L.F.</th>
						<th width="15%" class="text-right">Amount (RM)</th>
					</tr>	
				</thead>
				
				<tbody>
					<tr>
						<td>
							<input type="date" name="date" value="<?= date("Y-m-d") ?>" class="form-control" />
						</td>
						<td>
							Debitted Account:
							<select class="form-control" name="dr_account">
								<option value="">Select ...</option>
							<?php
								foreach(account_categories::getBy(["ac_business" => Session::get("clinic")->c_id]) as $ac){
								?>
									<optgroup label="<?= $ac->ac_name ?>">
								<?php
									foreach(accounts::getBy(["a_business" => Session::get("clinic")->c_id, "a_category" => $ac->ac_id]) as $a){
									?>
									<option value="<?= $a->a_id ?>"><?= $a->a_name ?></option>
									<?php
									}
								?>
									</optgroup>
								<?php
								}
							?>
							</select><br />
							
							Creditted Account:
							<select class="form-control" name="cr_account">
								<option value="">Select ...</option>
							<?php
								foreach(account_categories::getBy(["ac_business" => Session::get("clinic")->c_id]) as $ac){
								?>
									<optgroup label="<?= $ac->ac_name ?>">
								<?php
									foreach(accounts::getBy(["a_business" => Session::get("clinic")->c_id, "a_category" => $ac->ac_id]) as $a){
									?>
									<option value="<?= $a->a_id ?>"><?= $a->a_name ?></option>
									<?php
									}
								?>
									</optgroup>
								<?php
								}
							?>
							</select><br />
							
							Description:
							<input type="text" class="form-control" name="description" name="description" placeholder="description" /><br />
							
							File:
							<input type="file" name="file" />
						</td>
						<td></td>
						<td>
							<input type="number" name="amount" step="0.01" placeholder="0.00" class="form-control" />
						</td>
					</tr>
				</tbody>
			</table>
			
			<div class="text-center">
			<?php
				Controller::form("billing/journal", [
					"action"	=> "create"
				]);
			?>
			
				<button class="btn btn-success btn-sm">
					<span class="fa fa-save"></span> Save Record
				</button>
			</div>
		</form>
	</div>
</div>