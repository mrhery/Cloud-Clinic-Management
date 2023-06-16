<div class="card">
    <div class="card-header">
       <span class="fa fa-list"></span> Users

        <a href="<?= PORTAL ?>pengguna/add" class="btn btn-primary btn-sm">
            <span class="fa fa-plus"></span> Add Staff
        </a>
    </div>

    <div class="card-body">
        <table class="table dataTable table-fluid table-hover">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th class="text-center" width="10%">Role</th>
                    <th class="text-right" width="10%">:::</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
				
				if(Session::get("admin")){
					$q = users::list();
				}else{
					$q = DB::conn()->query("SELECT * FROM users WHERE u_id IN (SELECT cu_user FROM clinic_user WHERE cu_clinic = ?) AND u_admin = 0", [Session::get("clinic")->c_id])->results();
				}
				
                foreach ($q as $user) {
                ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= $user->u_name ?></td>
                        <td><?= $user->u_email ?></td>
                        <td class="text-center">
                            <?php
                            foreach (roles::getBy(['r_id' => $user->u_role]) as $role) {
                                echo $role->r_name;
                            }
                            ?>
                        </td>
                        <td class="text-right">
                            <a href="<?= PORTAL ?>pengguna/edit/<?= $user->u_ukey ?>" class="btn btn-sm btn-warning">
                                <span class="fa fa-edit"></span> Edit
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>