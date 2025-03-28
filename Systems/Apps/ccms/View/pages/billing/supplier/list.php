<?php
if (Session::get("admin")) {
?>
	<a href="<?= PORTAL ?>billing/supplier/add" class="fab fab-right-bottom bg-primary text-light">
		<span class="fa fa-plus"></span>
	</a>
<?php
}
?>

<table class="table dataTable table-hover table-fluid">
	<thead>
		<tr>
			<th class="text-center" width="5%">No</th>
			<th>Name</th>
			<th class="text-center" width="20%">Phone</th>
			<th class="text-right" width="100px">:::</th>
		</tr>
	</thead>

	<tbody>
		<?php
		if (isset($_SESSION["admin"])) {
			$q = DB::conn()->query("SELECT * FROM clients")->results();
		} else {
			$q = DB::conn()->query("SELECT * FROM clients WHERE c_clinic = ?", [Session::get("clinic")->c_id])->results();
			
		}

		$no = 1;
		foreach ($q as $c) {
		?>
			<tr>
				<td><?= $no++ ?></td>
				<td><?= $c->c_name ?></td>
				<td>
					<?php
					$u = clients::getBy(["c_id" => $c->c_id]);

					if (count($u) > 0) {
						echo $u[0]->c_phone;
					} else {
						echo "Unknown";
					}
					?>
				</td>
				<td class="text-right">
					<a href="<?= PORTAL ?>billing/supplier/edit/<?= $c->c_key?>" class="btn btn-sm btn-primary">
						<span class="fa fa-edit"></span> Edit
					</a>

					<a href="<?= PORTAL ?>billing/supplier/delete/<?= $c->c_key?>" class="btn btn-sm btn-danger">
						<span class="fa fa-trash"></span>
					</a>
				</td>

				
			</tr>
		<?php
		}
		?>
	</tbody>
</table>