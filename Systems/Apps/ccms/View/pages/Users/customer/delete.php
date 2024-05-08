<div class="card">
    <div class="card-header">
       <span class="fa fa-list"></span> Delete Patient
    </div>

    <div class="card-body">
        <?php
            $c = customers::getBy(["c_ukey" => url::get(3)]);

            if (count($c) > 0) {
                $c = $c[0];
        ?>
        <h5>Are you sure want to delete <?= $c->c_name ?> parmenently ?</h5>
        <form action="" method="post">
            <div class="text-center mt-3">
                <a href="<?= PORTAL ?>Users/customers/" class="btn btn-sm btn-primary">
                    <span class="fa fa-step-backward"></span> Back
                </a>
                <?php
                    Controller::form(
                        "customer",
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