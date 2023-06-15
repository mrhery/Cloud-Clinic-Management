<?php
new Controller(["login"]);
?>
<img class="lena-brand-logo" src="<?= PORTAL ?>assets/img/logo.png" width="50" alt="">

<form class="form-signin" action="" method="POST">
	<h1 class="h3 font-weight-normal">Welcome here 👋</h1>
	<p class="text-color-light">Log in to your account</p>
	
	<?php
		Controller::alert();
	?>
	
	<label for="inputEmail" class="sr-only">Email address</label>
	<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" value="<?= Input::post("email") ?>" required autofocus />
	
	<label for="inputPassword" class="sr-only">Password </label>
	<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required />
	
	<div class="row">
		<div class="col-md-6 col-sm-6 col-6 offset-md-6 offset-sm-6 offset-6">
			<div class="checkbox mb-3 text-right">
			   <small><a href="recover-password.html">Recover password</a></small>
			</div>
		</div>
	</div>
	
	
	<?php
		Controller::form("login", [
			"action"	=> "login"
		]);
	?>
	<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
	
	<div class="row">
		<div class="col-md-12 col-sm-12 col-12">
			<div class="checkbox mb-3">
				<small>Don't have any account? <a href="signup.html">Create one now!</a></small>
			</div>
		</div>
	</div>
</form>

<div class="lena-shape-bg">
	<img src="<?= PORTAL ?>assets/img/bottom-shape-2.svg" />
</div>

