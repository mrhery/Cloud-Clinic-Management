<div class="card">
	<div class="card-header">
		<span class="fa fa-calendar"></span> Service Records 
		
		<a href="<?= PORTAL ?>medical-record/create" class="btn btn-sm btn-primary">
			<span class="fa fa-plus"></span> Record
		</a>
	</div>
	
	<div class="card-body">
        <a class="btn btn-sm btn-primary mb-3" href="<?= PORTAL ?>print-list-medical-record">
            Print
        </a>
		<table class="table dataTable table-fluid table-hover">
            <thead>
                <tr>
                    <th width="5%">No </th>
                    <th>Name </th>
					<th class="text-center" width="20%">No. of Records</th>
                    <th class="text-right" width="8%">:::</th>
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
                        <td class="text-center"><?= count(customer_record::getBy(["cr_customer" => $c->c_id])) ?></td>
                        <td class="text-right">
                            <a href="<?= PORTAL ?>medical-record/view/<?= $c->c_ukey ?>" class="btn btn-sm btn-warning">
                                <span class="fa fa-eye"></span> View
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
	</div>
</div>