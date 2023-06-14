

<div class="card">
	<div class="card-header">
		Create new Menu
		
		<a href="<?= PORTAL ?>settings/menus/list" class="btn btn-sm btn-primary">
			Back
		</a>
	</div>	
	
	<div class="card-body">
		<form action="" method="POST">
			<div class="row">
				<div class="col-md-6">
					Name:
					<input type="text" class="form-control" placeholder="Name" name="name" /><br />
					
					Route:
					<input type="text" class="form-control" placeholder="Route" name="route" /><br />
					
					<div class="row">
						<div class="col-md-12">
							Main:
							<select class="form-control" name="main">
								<option value="">None</option>
							<?php
								foreach(menus::getBy(["m_main" => 0]) as $m){
									$pl = false;
								?>
								<option value="<?= $m->m_id ?>">
									<?= $m->m_name ?> (/<?= $m->m_url ?>) - 
								<?php
									$rls = explode(",", $m->m_role);
									
									foreach($rls as $rl){
										$r = roles::getBy(["r_id" => $rl]);
										
										if(count($r) > 0){
										?>
											<?= $pl ? "|" : "" ?> <?= $r[0]->r_name ?> 
										<?php
											$pl = true;
										}
									}
								?>
								</option>
								<?php
								}
							?>
							</select><br />
						</div>
						
						<div class="col-md-12">
							URL:
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text">/</span>
								</div>
								
								<input type="text" name="url" class="form-control" placeholder="URL" />
							</div><br />
						</div>
						
						<div class="col-md-4">
							Status:
							<select class="form-control" name="status">
								<option value="1">Active</option>
								<option value="0">Inactive</option>
							</select><br />
						</div>
						
						<div class="col-md-4">
							Short (3 letters):
							<input type="text" class="form-control" name="short" placeholder="SEO" /><br />
						</div>
						
						<div class="col-md-4">
							Sort:
							<input type="number" class="form-control" name="sort" value="1" /><br />
						</div>
					</div>
						
					
					
				</div>
				
				<div class="col-md-6">
					Description:
					<textarea class="form-control" name="description" placeholder="Description"></textarea><br />
					
					CSS Class Icon:
					<input type="text" class="form-control" name="icon" placeholder="Icon" /><br />
					
					Roles:
					<select class="form-control" name="role[]" multiple>
						<option value="">Select Roles</option>
						<?php
							foreach(roles::list() as $r){
							?>
							<option value="<?= $r->r_id ?>"><?= $r->r_name ?></option>
							<?php
							}
						?>
					</select><br />				
				</div>
				
				<div class="col-md-12 text-center">
				<?php
					Controller::form("settings/menus", [
						"action"	=> "add"
					]);
				?>
					<button  class="btn btn-sm btn-success">
						Save
					</button>
				</div>
			</div>
		</form>
	</div>
</div>

 <script>
	
</script>