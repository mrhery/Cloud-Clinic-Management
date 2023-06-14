<?php
Controller::alert();
?>
<div class="card">
    <div class="card-header">

        <?php
        $user = users::getBy([
            "u_id"    => url::get(2)
        ]);
        ?>
        <span class="icon-plus2"></span>
        Buang Pengguna

        <a href="<?= PORTAL ?>pengguna/list" class="btn btn-sm btn-primary float-right">
            Kembali
        </a>

        <a href="<?= PORTAL ?>pengguna/delete/<?= $user[0]->u_id ?>" class="btn btn-sm btn-danger float-right">
            Padam
        </a>
    </div>

    <div class="card-body">
        <?php
        $u = users::getBy(["u_id" => url::get(2)]);

        if (count($u) > 0) {
            $u = $u[0];
        ?>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-12">
                                        Gambar: <br>
                                        <div class="col-md-4 mx-auto">
                                            <img src="<?= PORTAL ?>assets/images/profile/<?= $u->u_picture ?>" class="img img-responsive" width="50%" alt="Tiada Gambar dijumpai" /><br />
                                        </div>
                                        <br>
                                        <input type="file" accept="image/*" multiple class="form-control" name="u_picture" />
                                        <br /><br />
                                    </div>
                                    <div class="col-md-6">
                                        Nama Pengguna:
                                        <input type="text" placeholder="Nama pengguna" name="u_name" class="form-control" value="<?= $u->u_name ?>" /> <br>
                                    </div>

                                    <div class="col-md-6">
                                        Kata Laluan :
                                        <input type="text" placeholder="Kata laluan baharu" name="u_password" class="form-control" /> <br>
                                    </div>

                                    <div class="col-md-6">
                                        Alamat Emel:
                                        <input type="email" placeholder="Alamat emel" name="u_email" class="form-control" value="<?= $u->u_email ?>" /> <br>
                                    </div>

                                    <div class="col-md-6">
                                        No. Telefon:
                                        <input type="text" placeholder="Nombor telefon" name="u_phone" class="form-control" value="<?= $u->u_phone ?>" /> <br>
                                    </div>

                                    <div class="col-md-6">
                                        IC:
                                        <input type="text" placeholder="Nombor IC" name="u_ic" class="form-control" value="<?= $u->u_ic ?>" /> <br>
                                    </div>

                                    <div class="col-md-6">
                                        Peranan:

                                        <select class="form-control" name="u_role">
                                            <?php
                                            foreach (roles::list() as $role) {
                                            ?>
                                                <option value="<?= $role->r_id ?>" <?= $u->u_role == $role->r_id ? "selected"  : "" ?>>
                                                    <?= $role->r_name ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select><br>
                                    </div>

                                    <div class="col-md-6">
                                        Alamat:
                                        <textarea type="text" placeholder="Alamat" name="u_alamat" rows="3" class="form-control" value=""><?= $u->u_alamat ?> </textarea>
                                        <br>
                                    </div>

                                    <div class="col-md-6">
                                        Daerah:
                                        <input type="text" placeholder="Daerah" name="u_area" class="form-control" value="<?= $u->u_area ?>" /> <br>
                                    </div>

                                    <div class="col-md-6">
                                        Negeri:
                                        <input type="text" placeholder="Negeri" name="u_state" class="form-control" value="<?= $u->u_state ?>" /> <br>
                                    </div>

                                    <div class="col-md-6">
                                        Poskod:
                                        <input type="text" placeholder="Poskod" name="u_postcode" class="form-control" value="<?= $u->u_postcode ?>" /> <br>
                                    </div>

                                    <div class="col-md-6">
                                        Negara:
                                        <input type="text" placeholder="Negara" name="u_country" class="form-control" value="<?= $u->u_country ?>" /> <br>
                                    </div>

                                    <div class="col-md-12 text-center">
                                        <?php
                                        Controller::form(
                                            "pengguna",
                                            [
                                                "action" => "edit"
                                            ]
                                        );
                                        ?>
                                        <button class="btn btn-sm btn-primary">
                                            Simpan
                                        </button>
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