<?php
new Controller(["settings/rols"]);
?>
<div class="row">
	<div class="col-md-12">
	<?php
		Controller::alert();
		
		switch(url::get(2)){
			case "":
			case "list":
				Page::Load("pages/settings/rols/list");
			break;

			case "view":
				Page::Load("pages/settings/rols/view");
			break;
			
			case "edit":
				Page::Load("pages/settings/rols/edit");
			break;
			
			case "delete":
				Page::Load("pages/settings/rols/delete");
			break;
			
			case "add":
				Page::Load("pages/settings/rols/add");
			break;
		}
	?>
	</div>
</div>	