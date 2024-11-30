<?php
$show = Input::get("show");
$search = Input::get("search");
$page = (int)Input::get("page");
$npage = 1;

if ($page < 1) {
    $page = 1;
}

Controller::alert();
?>
<a href="<?= PORTAL ?>Users/customers/add" class="bg-primary text-light fab fab-right-bottom usp-right-sheet">
	<span class="fa fa-plus"></span>
</a>

<div class="row mb-3">
	<div class="col-md-4 col-sm-6">
		<div class="input-group mb-3">
			<input type="text" class="form-control" name="search" placeholder="Search">
			<div class="input-group-append">
				<button class="btn btn-success" type="submit"><span class="fa fa-search"></span></button>
			</div>
		</div>
	</div>
	
	<div class="col-md-8 col-sm-6">
		<form action="" method="GET" class="text-right">
			<a href="<?= PORTAL ?>appointments?page=<?= $page - 1 ?>&search=<?= $search ?>" class="btn btn-sm btn-primary">
				<span class="fa fa-arrow-left"></span>
			</a>
			
			<input type="number" name="page" class="form-control text-center pagination-input" value="<?= $page ?>" /> / <?= $npage ?>
			<input type="hidden" value="<?= $search ?>" name="search" />
			
			<a href="<?= PORTAL ?>appointments?page=<?= $page + 1 ?>&search=<?= $search ?>" class="btn btn-sm btn-primary">
				<span class="fa fa-arrow-right"></span>
			</a>
		</form>
	</div>
</div>


<div class="row">
<?php
$no = 1;

if(Session::get("admin")){
	$q = customers::list();
}else{
	$q = DB::conn()->query("SELECT * FROM customers WHERE c_id IN (SELECT cc_customer FROM clinic_customer WHERE cc_clinic = ?)", [Session::get("clinic")->c_id])->results();
}

foreach ($q as $c) {
?>
	<div class="col-md-6 col-sm-12 col-xs-12">
		<div class="card mb-3 shadow xa-href usp-right-sheet" href="<?= PORTAL ?>Users/customers/edit/<?= $c->c_ukey ?>">
			<div class="card-body">
				<div class="row">
					<div class="col-2">
						<img src="<?= PORTAL ?>assets/images/user-default.png" class="img img-fluid" />
					</div>
					
					<div class="col-10">
						<b><?= $c->c_name ?> (<?= $c->c_ic ?>)</b><br />
						Tel: <?= empty($c->c_phone) ? "-" : $c->c_phone ?> | Email: <?= empty($c->c_email) ? "-" : $c->c_email ?>	
					</div>
				</div>
			</div>
		</div>
	</div>
<?php 
} 
?>
</div>