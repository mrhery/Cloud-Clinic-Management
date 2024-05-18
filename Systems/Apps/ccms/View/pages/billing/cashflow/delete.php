<?php
$t = transactions::getBy(["t_key" => url::get(3), "t_business" => Session::get("clinic")->c_id, "t_delete" => 0]);

if(count($t) > 0){
	$t = $t[0];
}else{
	$t = null;
}
?>
<div class="card">
    <div class="card-header">
        <a href="<?= PORTAL ?>billing/cashflow" class="btn btn-primary btn-sm">
			<span class="fa fa-arrow-left"></span> Back
		</a>

		Edit Cashflow Records
    </div>

    <div class="card-body">
	<?php
		if(is_null($t)){
			new Alert("error", "No transaction record were found. Please select a correct transaction.");
		}else{
	?>
		<h2>Are you sure?</h2>
		
		<p>By clicking below button will remove this record from your database.</p>
		
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-6 mb-3">
					<div class="row">
						<div class="col-md-6">
							Date:
							<input disabled type="date" class="form-control" name="doc_date" value="<?= date("Y-m-d", strtotime($t->t_doc_datetime)) ?>" required /><br />
							
							Document:
							<select disabled class="form-control" name="doc_type">
								<option value="cash" <?= $t->t_doc_type == "cash" ? "selected" : "" ?>>Cash</option>
								<option value="cash_bill" <?= $t->t_doc_type == "cash_bill" ? "selected" : "" ?>>Cash Bill</option>
								<option value="invoice" <?= $t->t_doc_type == "invoice" ? "selected" : "" ?>>Invoice</option>
								<option value="voucher" <?= $t->t_doc_type == "voucher" ? "selected" : "" ?>>Voucher</option>
								<option value="debit_note" <?= $t->t_doc_type == "debit_note" ? "selected" : "" ?>>Debit Note</option>
								<option value="credit_note" <?= $t->t_doc_type == "credit_note" ? "selected" : "" ?>>Credit Note</option>
							</select><br />
						</div>
						
						<div class="col-md-6">
							Time:
							<input disabled type="time" class="form-control" name="doc_time" value="<?= date("H:i", strtotime($t->t_doc_datetime)) ?>" /><br />
							
							No:
							<input disabled type="text" class="form-control" name="doc_no" placeholder="Doc. No" value="<?= $t->t_doc_no ?>" /><br />
						</div>
					</div>
					
					Amount (RM):
					<input disabled type="number" step="0.01" class="form-control" name="amount" placeholder="0.00"  value="<?= $t->t_amount ?>" required /><br />
							
					Desription:
					<textarea disabled class="form-control" placeholder="Description" name="description"><?= $t->t_description ?></textarea>
				</div>
				
				<div class="col-md-6 mb-3">
					<div class="card border-info">
						<div class="card-header bg-info text-light">
							Accounting Information
						</div>
						
						<div class="card-body">							
							Class:
							<select disabled class="form-control" name="account_class">
								<option value="">Select ...</option>
								<option value="income" <?= $t->t_account_class == "income" ? "selected" : "" ?>>Income</option>
								<option value="expenses" <?= $t->t_account_class == "expenses" ? "selected" : "" ?>>Expenses</option>
								<option value="current_liability" <?= $t->t_account_class == "current_liability" ? "selected" : "" ?>>C. Liabilities</option>
								<option value="fixed_Liabilities" <?= $t->t_account_class == "fixed_Liabilities" ? "selected" : "" ?>>F. Liabilities</option>
							</select><br />
							
							Account:
							<select disabled class="form-control" name="account">
								<option value="">Select ...</option>
							</select><br />
							
							Cash Account:
							<select disabled class="form-control" name="cash_account">
								<option value="">Select ...</option>
							<?php
								foreach(cashaccounts::getBy(["c_business" => Session::get("clinic")->c_id]) as $c){
							?>
								<option value="<?= $c->c_key ?>" <?= $t->t_cash_account == $c->c_id ? "selected" : "" ?>><?= $c->c_name ?></option>
							<?php
								}
							?>
							</select>
							
						</div>
					</div>
				</div>
				
				<div class="col-md-12 text-center">
					<button class="btn btn-danger">
						<span class="fa fa-trash"></span> Confirm Delete
					</button>
				
				<?php
					Controller::form("billing/cashflow", [
						"action"	=> "delete"
					]);
				?>
				</div>
			</div>
		</form>
	<?php
		}
	?>
    </div>
</div>