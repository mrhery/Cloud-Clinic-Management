<div class="card">
    <div class="card-header">
         <a href="<?= PORTAL ?>Prescription" class="btn btn-primary btn-sm">
			<span class="fa fa-arrow-left"></span> Back
		</a>
		Add new Medicine Information
		
    </div>

    <div class="card-body">
	<?php
		if(Session::get("admin")){
	?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
					<div class="row">
						<div class="col-md-6">
							Name:
							<input type="text" placeholder="Medicine Name" name="name" class="form-control" /> <br />
						</div>

						<div class="col-md-6">
							Description:
							<input type="email" placeholder="Description" name="description" class="form-control" /> <br />
						</div>

						<div class="col-md-6">
							Code:
							<input type="text" placeholder="Medicine Code" name="code" class="form-control" /> <br />
						</div>

						<div class="col-md-6">
							Quantity:
							<input type="text" placeholder="Quantity" name="quantity" class="form-control" /> <br />
						</div>

						<div class="col-md-6">
							Price:
							<input placeholder="Price" name="RM" class="form-control"></textarea>
							<br />
						</div>
                        <div class="col-md-12 text-center">
							<button class="btn btn-sm btn-primary">
								<span class="fa fa-save"></span> Save
							</button>

                            
					</div>
                </div>
            </div>
        </form>
        <?php
		}else{
			new Alert("error", "Only admin allowed to access this page.");
		}
	?>
        </div>
</div>