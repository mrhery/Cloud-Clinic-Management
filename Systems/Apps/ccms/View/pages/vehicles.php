<div class="row">
    <div class="col-md-12">
	<?php
		new Controller(["vehicles"]);
		Controller::alert();
	
		switch(url::get(1)){
			case "":
			case "list":
				Page::Load("pages/vehicles/list");
			break;
			
			case "create":
				Page::Load("pages/vehicles/create");
			break;
			
			case "edit":
				Page::Load("pages/vehicles/edit");
			break;
			
			case "view":
				Page::Load("pages/vehicles/view");
			break;
			
			case "delete":
				Page::Load("pages/vehicles/delete");
			break;
		}
	?>
	</div>
</div>