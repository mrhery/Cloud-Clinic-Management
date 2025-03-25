<?php
Controller::alert();
?>
<h4>Add new Staff</h4>

<form action="" method="post" enctype="multipart/form-data">
	<div class="row">
		<div class="col-md-6">
			Name:
			<input type="text" placeholder="Name" name="name" class="form-control" /><br />
			
			IC:
			<input type="text" placeholder="IC No." name="ic" class="form-control" maxlength="12" pattern="\d{12}"/><br />
			
			Email:
			<input type="email" placeholder="Email" name="email" class="form-control" /><br />
			
			Phone:
			<input type="text" placeholder="Phone" name="phone" class="form-control" id="phone" maxlength="11" pattern="\d{10,11}" oninput="validatePhone(this)" /><br />
			
			Address:
			<textarea type="text" placeholder="Address" name="alamat" rows="3" class="form-control"></textarea><br />
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
					<option value="<?= $role->r_id ?>">
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
			<input type="text" placeholder="Password" name="password" class="form-control" /><br />
			
			Image:
			<input type="file" accept="image/*" multiple class="form-control" name="picture" />
			<br />
		</div>
		
		<div class="col-md-12 text-center">
			<?php
			Controller::form(
				"pengguna",
				[
					"action" => "add"
				]
			);
			?>
			<button class="btn btn-sm btn-primary">
				<span class="fa fa-save"></span> Create
			</button>
		</div>
	</div>
</form>
<script>
function validatePhone(input) {
    let value = input.value;
    
    // Ensure only numbers are entered
    value = value.replace(/\D/g, '');

    // Check the prefix and adjust the max length
    if (value.startsWith('011')) {
        input.maxLength = 11; // 011 should have 11 digits
    } else if (/^01[2-9]/.test(value)) {
        input.maxLength = 10; // 012, 013, 014, etc. should have 10 digits
    } else {
        input.maxLength = 11; // Default case, prevent excessive input
    }

    input.value = value; // Update input field with filtered value
}
</script>