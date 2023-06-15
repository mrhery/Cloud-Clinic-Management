<div class="card">
	<div class="card-header">
		Delete a Menu
		
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
			<h3>Are you sure?</h3>
			
			By clicking below button will remove this menu permanently. 
			<br /><br />
			
			<form action="" method="POST">
			<?php
				Controller::form("settings/menus", [
					"action"	=> "delete"
				]);
			?>
				<button class="btn btn-danger btn-sm">
					x Confirm Delete
				</button>
			</form>
		<?php
		}else{
			new Alert("error", "No menu information were found.");
		}
	?>
	</div>
</div>