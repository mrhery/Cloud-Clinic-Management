<?php
?>

<div class="card">
    <div class="card-header">
        Clinic Information
    </div>

    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
				<?php
					new Alert("info", "These information will be display in as an official letterhead of your business.");
				?>
					<div class="row">
						<div class="col-md-12">
							Name:
							<input type="text" placeholder="Business Name" name="u_name" class="form-control" /> <br>
						</div>

						<div class="col-md-6">
							Email:
							<input type="email" placeholder="Alamat emel" name="u_email" class="form-control" /> <br>
						</div>

						<div class="col-md-6">
							Phone:
							<input type="text" placeholder="Nombor telefon" name="u_phone" class="form-control" /> <br>
						</div>

						<div class="col-md-6">
							Regsitration Number:
							<input type="text" placeholder="Nombor IC" name="u_ic" class="form-control" /> <br>
						</div>

						<div class="col-md-6">
							Address:
							<textarea type="text" placeholder="Alamat" name="u_alamat" rows="3" class="form-control" value=""> </textarea>
							<br>
						</div>

						<div class="col-md-12 text-center">
							<button class="btn btn-sm btn-primary">
								<span class="fa fa-save"></span> Save
							</button>
						</div>

					</div>
                </div>
            </div>
        </form>
    </div>
</div>