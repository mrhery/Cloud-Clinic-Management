<div class="row">
	<div class="col-md-12">
	<?php

	new Controller(["prescription"]);
	Controller::alert();

	switch(url::get(1)){
		case "":
		case "list":
			Page::Load("pages/prescription/list");
		break;

		case "add":
			Page::Load("pages/prescription/add");
		break;

		case "edit":
			Page::Load("pages/prescription/edit");
		break;
        }
		

        ?>
	</div>
</div>