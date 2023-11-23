<div class="card">
    <div class="card-header">
        <span class="fas fa-capsules"></span> Prescription
		
	<?php
		if(Session::get("admin")){
	?>	
		<a href="<?= PORTAL ?>Prescription/add" class="btn btn-primary btn-sm">
			<span class="fa fa-plus"></span> Add Medicine
		</a>
	<?php
		}
	?>
    </div>

    <div class="card-body">
        <table class="table dataTable table-hover table-fluid">
			<thead>
				<tr>
					<th class="text-center" width="5%">No</th>
					<th class="text-center" width="25%">Name</th>
					<th class="text-center" width="25%">Description</th>
                    <th class="text-center" width="15%">Code</th>
                    <th class="text-center" width="10%">Quantity</th>
                    <th class="text-center" width="10%">Price</th>
					<th class="text-right" width="10%">:::</th>
				</tr>
			</thead>
			
			<tbody>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    
					<td class="text-right">
						<a href="<?= PORTAL ?>Prescription/edit/<?= $c->c_ukey ?>" class="btn btn-sm btn-primary">
							<span class="fa fa-edit"></span> Edit
						</a>
					</td>
				</tr>
			
			</tbody>
		</table>
    </div>
</div>