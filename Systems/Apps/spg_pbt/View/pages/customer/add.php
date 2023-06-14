<?php
Controller::alert();
?>

<div class="card">
    <div class="card-header">
        Add new Customer

        <a href="<?= PORTAL ?>customers/list" class="btn btn-sm btn-primary float-right">
            Back
        </a>
    </div>

    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    Name:
                                    <input type="text" placeholder="Nama pengguna" name="u_name" class="form-control" /> <br>
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
                                    IC:
                                    <input type="text" placeholder="Nombor IC" name="u_ic" class="form-control" /> <br>
                                </div>

                                <div class="col-md-6">
                                    Address:
                                    <textarea type="text" placeholder="Alamat" name="u_alamat" rows="3" class="form-control" value=""> </textarea>
                                    <br>
                                </div>

                                <div class="col-md-12 text-center">
                                    <button class="btn btn-sm btn-primary">
                                        Save
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>