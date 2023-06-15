<div class="card">
    <div class="card-header">
        Senarai Rol Pengguna
		
		<a href="<?= PORTAL ?>settings/rols/add" class="btn btn-primary btn-sm float-right">
			Tambah Rol Pengguna
		</a>
    </div>

    <div class="card-body">
        <table class="table table-fluid table-hover">
            <thead>
                <tr>
                    <th>Bil. </th>
                    <th class="text-center">Nama </th>
                    <th class="text-center">Menu</th>
                    <th class="text-center">Status </th>
                    <th class="text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $no = 1;
                    foreach(roles::list() as $role){
                ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td class="text-center"><?= $role->r_name ?></td>
                    <td class="text-center"><?= $role->r_menu ?></td>
                    <td class="text-center"><?= $role->r_status ? "Active" : "Inactive" ?></td>
                    <td class="text-center">
                        <a href="<?= PORTAL ?>settings/rols/edit/<?= $role->r_id ?>" class="btn btn-sm btn-warning">
							Kemaskini
						</a>
                        <a href="<?= PORTAL ?>settings/rols/view/<?= $role->r_id ?>" class="btn btn-sm btn-success">
							Lihat
						</a>
                        <a href="<?= PORTAL ?>settings/rols/delete/<?= $role->r_id ?>" class="btn btn-sm btn-danger">
							Padam
						</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>