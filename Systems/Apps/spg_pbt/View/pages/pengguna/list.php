<div class="card">
    <div class="card-header">
        Senarai Pengguna

        <a href="<?= PORTAL ?>pengguna/add" class="btn btn-primary btn-sm float-right">
            Tambah Pengguna
        </a>
    </div>

    <div class="card-body">
        <table class="table table-fluid table-hover">
            <thead>
                <tr>
                    <th>Bil. </th>
                    <th class="text-center">Nama </th>
                    <th class="text-center">Emel</th>
                    <th class="text-center">Peranan </th>
                    <th class="text-center">Tindakan</th>
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
                        <td class="text-center">
                            <a href="<?= PORTAL ?>pengguna/edit/<?= $user->u_id ?>" class="btn btn-sm btn-warning">
                                Kemaskini
                            </a>
                            <a href="<?= PORTAL ?>pengguna/view/<?= $user->u_id ?>" class="btn btn-sm btn-success">
                                Lihat
                            </a>

                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>