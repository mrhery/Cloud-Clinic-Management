

<div class="card">
	<div class="card-header">
		<span class="fa fa-list"></span> All Vehicles 
		
		<a href="<?= PORTAL ?>vehicles/create" class="btn btn-sm btn-primary">
			<span class="fa fa-plus"></span> Add Vehicle
		</a>
	</div>
	
	<div class="card-body">
		<table class="table table-hover table-bordered table-fluid dataTable">
			<thead>
				<tr>
					<th class="text-center" width="5%">No</th>
					<th class="text-center">Plate Number</th>
					<th class="text-center">Brand</th>
					<th class="text-center">Model</th>
					<th class="text-right">:::</th>
				</tr>
			</thead>
			
			<tbody>
			<?php
				$no = 1;
				foreach(vehicles::getBy(["v_business" => Session::get("clinic")->c_id]) as $v){
				?>
				<tr>
					<td class="text-center"><?= $no++ ?></td>
					<td class="text-center"><?= $v->v_no ?></td>
					<td class="text-center"><?= $v->v_brand ?></td>
					<td class="text-center"><?= $v->v_model ?></td>
					<td class="text-right">
						<a href="<?= PORTAL ?>vehicles/view/<?= $v->v_key ?>" class="btn btn-sm btn-warning text-light">
							<span class="fa fa-eye"></span>
						</a>
						
						<a href="<?= PORTAL ?>vehicles/edit/<?= $v->v_key ?>" class="btn btn-sm btn-info text-light">
							<span class="fa fa-pencil"></span> Edit
						</a>
					</td>
				</tr>
				<?php
				}
			?>
			</tbody>
		</table>
	</div>
</div>