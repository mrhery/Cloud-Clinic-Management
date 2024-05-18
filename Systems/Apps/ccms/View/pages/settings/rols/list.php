<div class="card">
    <div class="card-header">

        List Role User
		
		<a href="<?= PORTAL ?>settings/rols/add" class="btn btn-primary btn-sm float-right">
            Add Role User
		</a>
    </div>

    <div class="card-body">
        <table class="table table-fluid table-hover">
            <thead>
                <tr>
                    <th>Bil. </th>
                    <th class="text-center">Name </th>
                    <th class="text-center">Menu</th>
                    <th class="text-center">Status </th>
                    <th class="text-center">Action</th>
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
							Edit
						</a>
                        <a href="<?= PORTAL ?>settings/rols/view/<?= $role->r_id ?>" class="btn btn-sm btn-success">
							View
						</a>
                        <a href="<?= PORTAL ?>settings/rols/delete/<?= $role->r_id ?>" class="btn btn-sm btn-danger">
							Delete
						</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>