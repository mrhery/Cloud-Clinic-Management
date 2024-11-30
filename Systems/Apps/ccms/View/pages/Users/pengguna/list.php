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
<a href="<?= PORTAL ?>Users/pengguna/add" class="fab fab-right-bottom bg-primary text-light usp-right-sheet">
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
	$q = users::list();
}else{
	$q = DB::conn()->query("SELECT * FROM users WHERE u_id IN (SELECT cu_user FROM clinic_user WHERE cu_clinic = ?) AND u_admin = 0", [Session::get("clinic")->c_id])->results();
}

foreach ($q as $user) {
?>
	<div class="col-md-6 col-sm-12 col-xs-12">
		<div class="card mb-3 shadow xa-href usp-right-sheet" href="<?= PORTAL ?>Users/pengguna/edit/<?= $user->u_ukey ?>">
			<div class="card-body">
				<div class="row">
					<div class="col-2">
						<img src="<?= PORTAL ?>assets/images/user-default.png" class="img img-fluid" />
					</div>
					
					<div class="col-10">
						<b><?= $user->u_name ?></b>
						<?php
							foreach (roles::getBy(['r_id' => $user->u_role]) as $role) {
							?>
								<span class="badge badge-primary"><?= $role->r_name ?></span>
							<?php
								break;
							}
						?>
						<br />
						Tel: <?= empty($user->u_phone) ? "-" : $user->u_phone ?> | Email: <?= empty($user->u_email) ? "-" : $user->u_email ?>	
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>
</div>