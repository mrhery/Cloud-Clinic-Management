<?php
new Controller(["pengguna"]);
?>
<div class="row">
	<div class="col-md-12">
	<?php
		// Controller::alert();
		
		switch(url::get(1)){
			case "":
			case "list":
				Page::Load("pages/pengguna/list");
			break;
			
			case "edit":
				Page::Load("pages/pengguna/edit");
			break;
			
			case "view":
				Page::Load("pages/pengguna/view");
			break;
			
			case "delete":
				Page::Load("pages/pengguna/delete");
			break;
			
			case "add":
				Page::Load("pages/pengguna/add");
			break;
		}
	?>
	</div>
</div>	