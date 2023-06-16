<div class="card">
    <div class="card-header">
        <span class="fa fa-building"></span> Clinic Information
		
	<?php
		if(Session::get("admin")){
	?>	
		<a href="<?= PORTAL ?>Clinic/add" class="btn btn-primary btn-sm">
			<span class="fa fa-plus"></span> Add Clinic
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
					<th>Name</th>
					<th class="text-center" width="20%">Owner</th>
					<th class="text-right" width="10%">:::</th>
				</tr>
			</thead>
			
			<tbody>
			<?php
				if(isset($_SESSION["admin"])){
					$q = DB::conn()->query("SELECT * FROM clinics")->results();
				}else{
					$q = DB::conn()->query("SELECT * FROM clinics WHERE c_id IN (SELECT cu_clinic FROM clinic_user WHERE cu_user = ?)", [Session::get("user")->u_id])->results();
				}
				
				$no = 1;
				foreach($q as $c){
				?>
				<tr>
					<td><?= $no++ ?></td>
					<td><?= $c->c_name ?></td>
					<td>
					<?php
						$u = users::getBy(["u_id" => $c->c_owner]);
						
						if(count($u) > 0){
							echo $u[0]->u_name;
						}else{
							echo "Unknown";
						}
					?>
					</td>
					<td class="text-right">
						<a href="<?= PORTAL ?>Clinic/edit/<?= $c->c_ukey ?>" class="btn btn-sm btn-primary">
							<span class="fa fa-edit"></span> Edit
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