<?php
Controller::alert();
?>
<h4>Edit User Information</h4>

<?php
$u = users::getBy(["u_ukey" => url::get(3)]);

if (count($u) > 0) {
	$u = $u[0];
?>
	<form action="" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-6">
				Name:
				<input type="text" placeholder="Name" name="name" class="form-control" value="<?= $u->u_name ?>" /><br />
				
				IC:
				<input type="text" placeholder="IC No." name="ic" class="form-control" value="<?= $u->u_ic ?>" maxlength="12" pattern="\d{12}"/><br />
				
				Email:
				<input type="email" placeholder="Email" name="email" class="form-control" value="<?= $u->u_email ?>" /><br />
				
				Phone:
				<input type="text" placeholder="Phone" name="phone" class="form-control" value="<?= $u->u_phone ?>" maxlength="11" pattern="\d{10,11}" oninput="validatePhone(this)"/><br />
				
				Address:
				<textarea type="text" placeholder="Address" name="alamat" rows="3" class="form-control" value=""><?= $u->u_alamat ?></textarea><br />
			</div>

			<div class="col-md-6">
			<?php
				if(Session::get("admin")){
			?>
				Role:
				<select class="form-control" name="role">
				<?php
					foreach (roles::list() as $role) {
					?>
						<option value="<?= $role->r_id ?>" <?= $u->u_role == $role->r_id ? "selected"  : "" ?>>
							<?= $role->r_name ?>
						</option>
					<?php
					}
				?>
				</select><br />
			<?php
				}
			?>
				
				Password:
				<input type="text" placeholder="New Password" name="password" class="form-control" /><br />
				
				Image:
				<div class="col-md-4 mx-auto">
					<img src="<?= PORTAL ?>assets/images/profile/<?= $u->u_picture ?>" class="img img-responsive" width="50%" alt="No Image" /><br />
				</div>
				<input type="file" accept="image/*" multiple class="form-control" name="picture" />
				<br />
			</div>
			
			<div class="col-md-12 text-center">
				<?php
				Controller::form(
					"pengguna",
					[
						"action" => "edit"
					]
				);
				?>
				<button class="btn btn-sm btn-primary">
					<span class="fa fa-save"></span> Save
				</button>
			</div>

		</div>
	</form>

	<script>
function validatePhone(input) {
	let value = input.value.replace(/\D/g, ''); // Remove non-numeric characters

// Set correct max length
if (value.startsWith('011')) {
	input.setAttribute("maxlength", "11"); // Ensure 011-prefixed numbers have 11 digits
} else if (/^01[2-9]/.test(value)) {
	input.setAttribute("maxlength", "10"); // Ensure other 01X-prefixed numbers have 10 digits
} else {
	input.setAttribute("maxlength", "11"); // Default case
}

input.value = value; // Update the field with numeric value only
}
</script>

<?php
} else {
	new Alert("error", "Maklumat pengguna tidak dijumpai.");
}
?>