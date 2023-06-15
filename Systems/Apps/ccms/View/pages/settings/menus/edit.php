<div class="card">
	<div class="card-header">
		Edit a Menu
		
		<a href="<?= PORTAL ?>settings/menus/list" class="btn btn-sm btn-primary">
			Back
		</a>
	</div>	
	
	<div class="card-body">
	<?php
		
		
		$m = menus::getBy(["m_id" => url::get(3)]);
		
		if(count($m) > 0){
			$m = $m[0];
		?>
		<form action="" method="POST">
			<div class="row">
				<div class="col-md-6">
					Name:
					<input type="text" class="form-control" placeholder="Name" name="name" value="<?= $m->m_name ?>" /><br />
					
					Route:
					<input type="text" class="form-control" placeholder="Route" name="route" value="<?= $m->m_route ?>" /><br />
					
					<div class="row">
						<div class="col-md-6">
							Main:
							<select class="form-control" name="main">
								<option value="">None</option>
							<?php
								foreach(menus::getBy(["m_main" => 0]) as $mx){
								?>
								<option value="<?= $mx->m_id ?>" <?= $m->m_main == $mx->m_id ? "selected" : "" ?>>
									<?= $mx->m_name ?> (/<?= $mx->m_url ?>)
								</option>
								<?php
								}
							?>
							</select><br />
						</div>
						
						<div class="col-md-6">
							URL:
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text">/</span>
								</div>
								
								<input type="text" name="url" class="form-control" placeholder="URL" value="<?= $m->m_url ?>" />
							</div><br />
						</div>
						
						<div class="col-md-4">
							Status:
							<select class="form-control" name="status">
								<option value="1" <?= $m->m_status ? "selected" : "" ?>>Active</option>
								<option value="0" <?= $m->m_status ? "" : "selected" ?>>Inactive</option>
							</select><br />
						</div>
						
						<div class="col-md-4">
							Short (3 letters):
							<input type="text" class="form-control" name="short" placeholder="SEO" value="<?= $m->m_short ?>" /><br />
						</div>
						
						<div class="col-md-4">
							Sort:
							<input type="number" class="form-control" name="sort" value="<?= $m->m_sort ?>" /><br />
						</div>
					</div>
											
				</div>
				
				<div class="col-md-6">
					Description:
					<textarea class="form-control" name="description" placeholder="Description"><?= $m->m_description ?></textarea><br />
					
					CSS Class Icon:
					<input type="text" class="form-control" name="icon" placeholder="Icon" value="<?= $m->m_icon ?>" /><br />
					
					Roles:
					<select class="form-control" name="role[]" multiple>
					<?php
						$slt = explode(",", $m->m_role);
						
						foreach(roles::list() as $r){
							if(in_array($r->r_id, $slt)){
								$selected = "selected";
							}else{
								$selected = "";
							}
						?>
						<option value="<?= $r->r_id ?>" <?= $selected ?>><?= $r->r_name ?></option>
						<?php
						}
					?>
					</select><br />	

				</div>
				
				<div class="col-md-12 text-center">
				<?php
					Controller::form("settings/menus", [
						"action"	=> "edit"
					]);
				?>
					<button  class="btn btn-sm btn-success">
						Save
					</button>
				</div>
			</div>
		</form>
		<?php
		}else{
			new Alert("error", "No menu information were found.");
		}
	?>
	</div>
</div>