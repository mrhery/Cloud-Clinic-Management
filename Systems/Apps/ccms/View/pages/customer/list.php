<div class="card">
    <div class="card-header">
       <span class="fa fa-list"></span> Users

        <a href="<?= PORTAL ?>customers/add" class="btn btn-primary btn-sm float-right">
            Add new Customer
        </a>
    </div>

    <div class="card-body">
        <table class="table table-fluid table-hover">
            <thead>
                <tr>
                    <th>Bil. </th>
                    <th class="text-center">Name </th>
                    <th class="text-center">IC</th>
                    <th class="text-right">:::</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach (users::list() as $user) {
                ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center"><?= $user->u_name ?></td>
                        <td class="text-center">-</td>
                        <td class="text-right">
                            <a href="<?= PORTAL ?>customer/edit/<?= $user->u_id ?>" class="btn btn-sm btn-warning">
                                Edit
                            </a>
                            <a href="<?= PORTAL ?>customer/view/<?= $user->u_id ?>" class="btn btn-sm btn-success">
                                View
                            </a>

                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>