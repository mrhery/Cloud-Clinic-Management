<?php
Controller::alert();
?>
<h4>Add new Patient</h4>

<form action="" method="post" enctype="multipart/form-data">
	<div class="row">
		<div class="col-md-6">
			Name:
			<input type="text" placeholder="Name" name="name" class="form-control" /> <br>
		</div>

		<div class="col-md-6">
			Email:
			<input type="email" placeholder="Email" name="email" class="form-control" /> <br>
		</div>

		<div class="col-md-6">
			Phone:
			<input type="text" placeholder="+60 ..." name="phone" class="form-control" /> <br>
		</div>

		<div class="col-md-6">
			IC:
			<input type="text" placeholder="IC / Passport" name="ic" class="form-control" /> <br>
		</div>

		<div class="col-md-6">
			Address:
			<textarea type="text" placeholder="Address" name="address" rows="3" class="form-control" value=""> </textarea>
			<br>
		</div>

		<div class="col-md-12 text-center">
			<button class="btn btn-sm btn-primary">
				<span class="fa fa-save"></span> Save
			</button>
			
		<?php
			Controller::form("customer", ["action" => "add"]);
		?>
		</div>
	</div>
</form>