<div class="card">
    <div class="card-header">
       <span class="fa fa-list"></span> Users

        <a href="<?= PORTAL ?>Users/customers/add" class="btn btn-primary btn-sm">
            <span class="fa fa-plus"></span> Add new Customer
        </a>
    </div>

    <div class="card-body">
        <table class="table dataTable table-fluid table-hover">
            <thead>
                <tr>
                    <th width="5%">No </th>
                    <th>Name </th>
                    <th class="text-center">IC</th>
                    <th class="text-right" width="5%">:::</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $no = 1;
				
				if(Session::get("admin")){
					$q = customers::list();
				}else{
					$q = DB::conn()->query("SELECT * FROM customers WHERE c_id IN (SELECT cc_customer FROM clinic_customer WHERE cc_clinic = ?)", [Session::get("clinic")->c_id])->results();
				}
				
                foreach ($q as $c) {
            ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= $c->c_name ?></td>
                        <td class="text-center"><?= $c->c_ic ?></td>
                        <td class="text-right">
                            <a href="<?= PORTAL ?>Users/customers/edit/<?= $c->c_ukey ?>" class="btn btn-sm btn-warning">
                                <span class="fa fa-edit"></span> Edit
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>