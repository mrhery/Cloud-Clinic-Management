<?php
new Controller(["recover-password"]);
?>


<form class="form-signin small-form" action="" method="POST">
    <img src="<?= PORTAL ?>assets/images/logo-naked.png" class="mb-2 img img-fluid" width="80px" height="80px" alt="">
    <h2 class="h5 font-weight-normal">Forgot Password</h2>
    <p class="text-color-light">Enter your email address below, and we'll send you instructions to reset your password.</p>

    <?php Controller::alert(); ?>

	<input type="email" name="email" id="inputEmail" class="form-control form-control-sm mb-1" placeholder="Email address" value="<?= Input::post("email") ?>" required autofocus />
	
	<input type="password" name="password" id="inputPassword" class="form-control form-control-sm mb-1" placeholder="Password" required />

    <input type="password" name="newpassword" id="inputNewPassword" class="form-control form-control-sm mb-2" placeholder="New Password" required />

    <?php Controller::form("recover-password", ["action" => "recover-password"]); ?>
    
    <button class="btn btn-sm btn-primary btn-block small-button" type="submit">Change Now</button>

    <div class="row">
        <div class="col-12">
            <div class="checkbox mb-4">
                <small>Back to <a href="<?= PORTAL ?>">login</a></small>
            </div>
        </div>
    </div>
</form>

<style>
    .small-form {
    max-width: 350px;
    margin: auto;
    padding: 15px;
    position: absolute;
    top: 69px; /* Adjust this value to position it closer to the top */
    left: 50%;
    transform: translateX(-50%);
}
</style>

<div class="lena-shape-bg">
	<img src="<?= PORTAL ?>assets/img/bottom-shape-2.svg" />
</div>

