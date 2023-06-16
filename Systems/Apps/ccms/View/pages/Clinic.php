<div class="row">
	<div class="col-md-12">
	<?php

	new Controller(["clinic"]);
	Controller::alert();

	switch(url::get(1)){
		case "":
		case "list":
			Page::Load("pages/clinic/list");
		break;
		
		case "add":
			Page::Load("pages/clinic/add");
		break;
		
		case "edit":
			Page::Load("pages/clinic/edit");
		break;
	}

	?>
	</div>
</div>