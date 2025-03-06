<?php
new Controller(["recover-password"]);
?>


<form class="form-signin" action="" method="POST">
     
	<img src="<?= PORTAL ?>assets/images/logo-naked.png" class="mb-3 img img-fluid" width="150px" height="150px"  alt="">
	<h1 class="h3 font-weight-normal">Forgot Password</h1>
	<p class="text-color-light">Enter your email address below, and we'll send you instructions to reset your password.</p>
	
	<?php
		Controller::alert();
	?>
	
	<label for="inputEmail" class="sr-only">Email address</label>
	<input type="email" name="email" id="inputEmail" class="form-control mb-2" placeholder="Email address" value="<?= Input::post("email") ?>" required autofocus />
	
	<label for="inputPassword" class="sr-only">Password </label>
	<input type="password" name="password" id="inputPassword" class="form-control mb-2" placeholder="Password" required />

    <label for="inputNewPassword" class="sr-only">New Password </label>
    <input type="password" name="newpassword" id="inputNewPassword" class="form-control" placeholder="New Password" required />
	
	
	<?php
		Controller::form("recover-password", [
			"action"	=> "recover-password"
		]);
	?>
	<button class="btn btn-lg btn-primary btn-block" type="submit">Change Now</button>
	
	<div class="row">
		<div class="col-md-12 col-sm-12 col-12">
			<div class="checkbox mb-3">
				<small>Back to <a href="<?= PORTAL ?>login">login</a></small>
			</div>
		</div>
	</div>
</form>

<div class="lena-shape-bg">
	<img src="<?= PORTAL ?>assets/img/bottom-shape-2.svg" />
</div>

