<div class="card">
	<div class="card-header">
		Padam Rol
		
		<a href="<?= PORTAL ?>settings/rols/list" class="btn btn-sm btn-primary">
			Kembali
		</a>
	</div>	
	
	<div class="card-body">
	<?php
		$r = roles::getBy(["r_id" => url::get(3)]);
		
		if(count($r) > 0){
			$r = $r[0];
		?>
			<h3>Adakah anda pasti?</h3>
			
			Dengan menekan butang di bawah akan padam rol ini secara kekal.
			<br /><br />
			
			<form action="" method="POST">
			<?php
				Controller::form("settings/rols", [
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