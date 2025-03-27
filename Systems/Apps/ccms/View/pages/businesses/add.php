<h4>Business Information</h4>
<?php
if (Session::get("admin")) {
?>
	<form action="" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-12">
				<?php
				//new Alert("info", "These information will be display in as an official letterhead of your business.");
				Controller::alert();
				?>
				<div class="row">
					<div class="col-md-6">
						Name:
						<input type="text" placeholder="Business Name" name="name" class="form-control" /> <br />
					</div>

					<div class="col-md-6">
						Email:
						<input type="email" placeholder="Email" name="email" class="form-control" /> <br />
					</div>

					<div class="col-md-6">
						Phone:
						<input type="text" placeholder="Phone" name="phone" class="form-control" pattern="\d{8,11}" required oninput="validatePhone(this)"/> <br />
					</div>

					<div class="col-md-6">
						Regsitration Number:
						<input type="text" placeholder="Reg. Number" name="regno" class="form-control" /> <br />
					</div>

					<div class="col-md-6">
						Address:
						<textarea placeholder="Address" name="address" class="form-control"></textarea>
						<br />
					</div>

					<div class="col-md-6">
						Owner:
						<select class="form-control" name="owner">
							<?php
							foreach (users::getBy(["u_admin" => 0]) as $u) {
							?>
								<option value="<?= $u->u_id ?>"><?= $u->u_name ?></option>
							<?php
							}
							?>
						</select>
						<br />
					</div>

					<div class="col-md-12 text-center">
						<button class="btn btn-sm btn-primary">
							<span class="fa fa-save"></span> Save
						</button>

						<?php
						Controller::form("businesses", ["action" => "create"]);
						?>
					</div>
				</div>
			</div>
		</div>
	</form>
<?php
} else {
	new Alert("error", "Only admin allowed to access this page.");
}
?>
<script>
function validatePhone(input) {
    let value = input.value.replace(/\D/g, ''); // Remove non-numeric characters

    // Check prefix and set the max length accordingly
    if (value.startsWith('011')) {
        input.setAttribute("maxlength", "11"); // 011 numbers must have 11 digits
    } else if (/^01[2-9]/.test(value)) {
        input.setAttribute("maxlength", "10"); // Other 01X numbers must have 10 digits
    } else if (/^\d{8}$/.test(value)) {
        input.setAttribute("maxlength", "8"); // Allow exactly 8-digit numbers
    } else {
        input.setAttribute("maxlength", "11"); // Default case
    }

    // Ensure input is trimmed to the correct length
    if (value.length > input.maxLength) {
        value = value.substring(0, input.maxLength);
    }

    input.value = value; // Update the field
}
</script>