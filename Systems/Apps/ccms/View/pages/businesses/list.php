<?php
$show = Input::get("show");
$search = Input::get("search");
$page = (int)Input::get("page");
$npage = 1;

if ($page < 1) {
    $page = 1;
}

if (Session::get("admin")) {
?>
	<a href="<?= PORTAL ?>businesses/add" class="fab fab-right-bottom bg-primary text-light usp-right-sheet">
		<span class="fa fa-plus"></span>
	</a>
<?php
}
?>

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
if (isset($_SESSION["admin"])) {
	$q = DB::conn()->query("SELECT * FROM clinics")->results();
} else {
	$q = DB::conn()->query("SELECT * FROM clinics WHERE c_id IN (SELECT cu_clinic FROM clinic_user WHERE cu_user = ?)", [Session::get("user")->u_id])->results();
}

$no = 1;
foreach ($q as $c) {
	$u = users::getBy(["u_id" => $c->c_owner]);

	if (count($u) > 0) {
		$owner = $u[0]->u_name;
	} else {
		$owner = "Unknown";
	}
?>
	<div class="col-md-6 col-sm-12 col-xs-12">
		<div class="card mb-3 shadow xa-href usp-right-sheet" href="<?= PORTAL ?>businesses/edit/<?= $c->c_ukey ?>">
			<div class="card-body">
				<div class="row">
					<div class="col-2">
						<img src="<?= PORTAL ?>assets/images/user-default.png" class="img img-fluid" />
					</div>
					
					<div class="col-10">
						<b><?= $c->c_name ?></b> <br />
						<small>owned by <span class="badge badge-danger"><?= $owner ?></span></small><br />
						
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