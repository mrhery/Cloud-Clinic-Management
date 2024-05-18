<div class="card">
    <div class="card-header">
        Tambah Permohonan

        <a href="<?= PORTAL ?>settings/jabatan/" class="btn btn-sm btn-primary">
            Kembali
        </a>
    </div>
    <div class="card-body">
        <?php
        $dep = clinics::getBy(["c_id" => url::get(2)]);

        ?>
        <form action="" method="POST">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    Adakah anda pasti ingin membuang Jabatan bernama <b><?= $dep[0]->c_name ?></b>?
                                    <br /><br />
                                    <?php
                                    Controller::form("businesses", [
                                        "action"    => "delete"
                                    ]);
                                    ?>
                                    <button class="btn btn-sm btn-danger">
                                        Pasti
                                    </button>
                                    <a href="<?= PORTAL ?>settings/jabatan/" class="btn btn-sm btn-primary">
                                        Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>