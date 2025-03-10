<style>
#ic-search-list {
	display: none;
	position: absolute;
	background-color: #363636;
	width: 95%;
	overflow-y: auto;
}

.ic-list-item {
	color: white;
	padding: 10px;
	cursor: pointer;
	font-size: 9pt;
}

.ic-list-item:hover {
	background-color: black;
}
</style>

<div class="card">
	<div class="card-header">
		<a href="<?= PORTAL ?>dashboard" class="btn btn-sm btn-primary mr-2">
			<span class="fa fa-arrow-left"></span> Back
		</a>
		
		Add New Patient
	</div>
	
	<div class="card-body">
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
	</div>
</div>
