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
			<input type="text" placeholder="IC No." name="ic" class="form-control" /><br />
			
			Email:
			<input type="email" placeholder="Email" name="email" class="form-control" /><br />
			
			Phone:
			<input type="text" placeholder="Phone" name="phone" class="form-control" /><br />
			
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