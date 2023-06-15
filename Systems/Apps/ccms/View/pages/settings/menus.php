<?php
new Controller(["settings/menus"]);
?>
<div class="row">
	<div class="col-md-12">
	<?php
		Controller::alert();
		
		switch(url::get(2)){
			case "":
			case "list":
				Page::Load("pages/settings/menus/list");
			break;
			
			case "edit":
				Page::Load("pages/settings/menus/edit");
			break;
			
			case "delete":
				Page::Load("pages/settings/menus/delete");
			break;
			
			case "add":
				Page::Load("pages/settings/menus/add");
			break;
		}
	?>
	</div>
</div>	