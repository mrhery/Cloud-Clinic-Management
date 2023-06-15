<div class="card">
	<div class="card-header">
		Menus Listing
		
		<a href="<?= PORTAL ?>settings/menus/add" class="btn btn-sm btn-primary">
			Create New
		</a>
	</div>	
	
	<div class="card-body">
		<table class="table table-fluid table-hover">
			<thead>
				<tr>
					<th class="text-center">No</th>
					<th>Name</th>
					<th class="text-center">Route</th>
					<th class="text-center">Sort</th>
					<th class="text-center">Status</th>
					<th class="text-right">:::</th>
				</tr>
			</thead>
			
			<tbody>
			<?php
				$no = 1;
				foreach(menus::getBy(["m_main" => 0], ["order" => "m_sort ASC"]) as $m){
					
				?>
				<tr>
					<td class="text-center"><?= $no ?></td>
					<td>
						<?= $m->m_name ?><br />
						<small>/<?= $m->m_url ?></small><br />
					<?php
						$rids = explode(",", $m->m_role);
						
						foreach($rids as $rid){
							$r = roles::getBy(["r_id" => $rid]);
							
							if(count($r) > 0){
								$r = $r[0];
							?>
							<span class="badge badge-primary badge-lg"><?= $r->r_name ?></span>
							<?php
							}
						}
					?>
					</td>
					<td class="text-center"><?= $m->m_route ?></td>
					<td class="text-center"><?= $m->m_sort ?></td>
					<td class="text-center"><?= $m->m_status ? "Active" : "Inactive" ?></td>
					<td class="text-right">
						<a href="<?= PORTAL ?>settings/menus/edit/<?= $m->m_id ?>" class="btn btn-warning btn-sm">
							Kemaskini
						</a>
						
						<a href="<?= PORTAL ?>settings/menus/delete/<?= $m->m_id ?>" class="btn btn-danger btn-sm">
							Padam
						</a>
					</td>
				</tr>
				<?php
					$ns = 1;
					$sm = menus::getBy(["m_main" => $m->m_id]);
					
					foreach($sm as $s){
					?>
					<tr>
						<td class="text-center"><?= $no ?>.<?= $ns ?></td>
						<td class="">
							<?= $s->m_name ?><br />
							<small>/<?= $m->m_url ?>/<?= $s->m_url ?></small><br />
						<?php
						$rids = explode(",", $m->m_role);
						
						foreach($rids as $rid){
							$r = roles::getBy(["r_id" => $rid]);
							
							if(count($r) > 0){
								$r = $r[0];
							?>
							<span class="badge badge-primary badge-lg"><?= $r->r_name ?></span>
							<?php
							}
						}
						?>
						</td>
						<td class="text-center"><?= $s->m_route ?></td>
						<td class="text-center"><?= $s->m_sort ?></td>
						<td class="text-center"><?= $s->m_status ? "Active" : "Inactive" ?></td>
						<td class="text-right">
							<a href="<?= PORTAL ?>settings/menus/edit/<?= $s->m_id ?>" class="btn btn-warning btn-sm">
								Kemaskini
							</a>
							
							<a href="<?= PORTAL ?>settings/menus/delete/<?= $s->m_id ?>" class="btn btn-danger btn-sm">
								Padam
							</a>
						</td>
					</tr>
					<?php
						$ns++;
					}
					
					$no++;
				}
			?>
			</tbody>
		</table>
	</div>
</div>
