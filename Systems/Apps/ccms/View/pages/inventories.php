<div class="row">
    <div class="col-md-12">
	<?php
		new Controller(["inventories"]);
		Controller::alert();
	
		switch(url::get(1)){
			case "":
			case "list":
				Page::Load("pages/inventories/list");
			break;
			
			case "create":
				Page::Load("pages/inventories/create");
			break;
			
			case "edit":
				Page::Load("pages/inventories/edit");
			break;
			
			case "card":
				Page::Load("pages/inventories/card");
			break;
		}
	?>
	</div>
</div>