<div class="card">
    <div class="card-header">
       <span class="fa fa-list"></span> Delete Users
    </div>

    <div class="card-body">
        <?php
            $u = users::getBy(["u_ukey" => url::get(3)]);

            if (count($u) > 0) {
                $u = $u[0];
        ?>
        <h5>Are you sure want to delete <?= $u->u_name ?> parmenently ?</h5>
        <form action="" method="post">
            <div class="text-center mt-3">
                <a href="<?= PORTAL ?>Users/pengguna/" class="btn btn-sm btn-primary">
                    <span class="fa fa-step-backward"></span> Back
                </a>
                <?php
                    Controller::form(
                        "pengguna",
                        [
                            "action" => "delete"
                        ]
                    );
                ?>
                <button class="btn btn-sm btn-danger">
                    <span class="fa fa-trash"></span> Delete
                </button>
            </div>
        </form>

        <?php
            }
        ?>
    </div>
</div>