<div class="card">
    <div class="card-header">
        <a href="<?= PORTAL ?>billing/cashflow" class="btn btn-primary btn-sm">
			<span class="fa fa-arrow-left"></span> Back
		</a>

		Add Cashflow Records
    </div>

    <div class="card-body">
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-6 mb-3">
					<div class="row">
						<div class="col-md-6">
							Date:
							<input type="date" class="form-control" name="doc_date" value="<?= date("Y-m-d") ?>" required /><br />
							
							Amount (RM):
							<input type="number" step="0.01" class="form-control" name="amount" placeholder="0.00" required /><br />
						</div>
						
						<div class="col-md-6">
							<input type="hidden" name="type" value="in" />
							<br />
							<button type="button" class="btn btn-success text-light btn-outline-success in">
								Money In
							</button>
							
							<button type="button" class="btn btn-outline-danger out">
								Money Out
							</button><br /><br />
							
							No:
							<input type="text" class="form-control" name="doc_no" placeholder="Doc. No" /><br />
						</div>
					</div>
					
					Desription:
					<textarea class="form-control" placeholder="Description" name="description"></textarea>
				</div>
				
				<div class="col-md-6 mb-3">
					<div class="card border-info">
						<div class="card-header bg-info text-light">
							Accounting Information
						</div>
						
						<div class="card-body">							
							Account:
							<select class="form-control" name="account">
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
							
							Cash Account:
							<select class="form-control" name="cash_account">
							<?php
								foreach(cashaccounts::getBy(["c_business" => Session::get("clinic")->c_id]) as $c){
							?>
								<option value="<?= $c->c_key ?>"><?= $c->c_name ?></option>
							<?php
								}
							?>
							</select><br />
							
							Upload file:
							<input type="file" multiple name="files[]" />
						</div>
					</div>
				</div>
				
				<div class="col-md-12 text-center">
					<button class="btn btn-success">
						<span class="fa fa-save"></span> Save Record
					</button>
				
				<?php
					Controller::form("billing/cashflow", [
						"action"	=> "create"
					]);
				?>
				</div>
			</div>
		</form>
		
		<hr />
		
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th width="8%" class="text-center">Date</th>
					<th>Description</th>
					<th class="text-right">In (RM)</th>
					<th class="text-right">Out (RM)</th>
				</tr>
			</thead>
			
			<tbody>
			<?php
				foreach(transactions::getBy(["t_business" => Session::get("clinic")->c_id]) as $t){
				?>
				<tr>
					<td class="text-center"><?= date("d M Y", strtotime($t->t_created)) ?></td>
					<td><?= $t->t_description ?></td>
					<td class="text-right" width="10%"><?= $t->t_type == "in" ? number_format($t->t_amount, 2) : "-" ?></td>
					<td class="text-right" width="10%"><?= $t->t_type == "out" ? number_format($t->t_amount, 2) : "-" ?></td>
				</tr>
				<?php
				}
			?>
			</tbody>
		</table>
    </div>
</div>

<?php

Page::append(<<<A
<script>
$(".in").on("click", function(){
	$(this).addClass("btn-success text-light");
	$(".out").removeClass("btn-danger text-light");
	
	$("[name=type]").val("in");
});

$(".out").on("click", function(){
	$(this).addClass("btn-danger text-light");
	$(".in").removeClass("btn-success text-light");
	
	$("[name=type]").val("out");
});
</script>
A
);
