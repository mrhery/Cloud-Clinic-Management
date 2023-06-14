<?php
Controller::alert();
?>
<div class="card">
    <div class="card-header">
        Tambah Pengguna

        <a href="<?= PORTAL ?>pengguna/list" class="btn btn-sm btn-primary float-right">
            Kembali
        </a>
    </div>

    <div class="card-body">
        <?php
        $u = users::getBy(["u_id" => url::get(2)]);

        if (count($u) > 0) {
            $u = $u[0];

            $r = roles::getBy(["r_id" => $u->u_role]);
            // $r = $r[0];

        ?>
            <form action="" method="get">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-12">
                                        Gambar:
                                        <div class="col-md-4 mx-auto">
                                            <!--<img src="<?= PORTAL ?>assets/images/test1.png" alt="" style="width: 100%; height: 100%;">-->
                                            <img src="<?= PORTAL ?>assets/images/profile/<?= $u->u_picture ?>" class="img img-responsive" width="50%" /><br />
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        Nama Pengguna:
                                        <input type="text" name="u_name" class="form-control" value="<?= $u->u_name ?>" disabled /> <br>
                                    </div>

                                    <div class="col-md-6">
                                        Alamat Emel:
                                        <input type="email" name="u_email" class="form-control" value="<?= $u->u_email ?>" disabled /> <br>
                                    </div>

                                    <div class="col-md-6">
                                        No. Telefon:
                                        <input type="text" name="u_phone" class="form-control" value="<?= $u->u_phone ?>" disabled /> <br>
                                    </div>

                                    <div class="col-md-6">
                                        IC:
                                        <input type="text" name="u_ic" class="form-control" value="<?= $u->u_ic ?>" disabled /> <br>
                                    </div>

                                    <div class="col-md-6">
                                        Peranan:
                                        <?php
                                        $r = roles::getBy(["r_id" => $u->u_role]);
                                        if (count($r) > 0) {
                                            $r = $r[0];
                                        ?>
                                            <input type="text" name="u_role" class="form-control" value="<?= $r->r_name ?>" disabled /> <br>
                                        <?php
                                        }
                                        ?>
                                    </div>

                                    <div class="col-md-6">
                                        Alamat:
                                        <textarea type="text" name="u_alamat" rows="3" class="form-control" value="" disabled><?= $u->u_alamat ?> </textarea>
                                        <br>
                                    </div>

                                    <div class="col-md-6">
                                        Daerah:
                                        <input type="text" name="u_area" class="form-control" value="<?= $u->u_area ?>" disabled /> <br>
                                    </div>

                                    <div class="col-md-6">
                                        Negeri:
                                        <input type="text" name="u_state" class="form-control" value="<?= $u->u_state ?>" disabled /> <br>
                                    </div>

                                    <div class="col-md-6">
                                        Poskod:
                                        <input type="text" name="u_postcode" class="form-control" value="<?= $u->u_postcode ?>" disabled /> <br>
                                    </div>

                                    <div class="col-md-6">
                                        Negara:
                                        <input type="text" name="u_country" class="form-control" value="<?= $u->u_country ?>" disabled /> <br>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        <?php
        } else {
            new Alert("error", "Maklumat pengguna tidak dijumpai.");
        }
        ?>
    </div>
</div>