<div class="card">
    <div class="card-header">
       <span class="fa fa-list"></span> Users

        <a href="<?= PORTAL ?>pengguna/add" class="btn btn-primary btn-sm float-right">
            Create new User
        </a>
    </div>

    <div class="card-body">
        <table class="table table-fluid table-hover">
            <thead>
                <tr>
                    <th>Bil. </th>
                    <th class="text-center">Name </th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Role </th>
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
                        <td class="text-center"><?= $user->u_email ?></td>
                        <td class="text-center">
                            <?php
                            foreach (roles::getBy(['r_id' => $user->u_role]) as $role) {
                                echo $role->r_name;
                            }
                            ?>
                        </td>
                        <td class="text-right">
                            <a href="<?= PORTAL ?>pengguna/edit/<?= $user->u_id ?>" class="btn btn-sm btn-warning">
                                Edit
                            </a>
                            <a href="<?= PORTAL ?>pengguna/view/<?= $user->u_id ?>" class="btn btn-sm btn-success">
                                View
                            </a>

                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>