<div class="row">
	<div class="col-md-12">
	<?php

	new Controller(["tips"]);
	Controller::alert();

	switch(url::get(1)){
		case "":
		case "list":
			Page::Load("pages/tips/list");
		break;

		case "add":
			Page::Load("pages/tips/add");
		break;

        case "delete":
			Page::Load("pages/tips/delete");
		break;

		case "edit":
			Page::Load("pages/tips/edit");
		break;
        }
		

        ?>
	</div>
</div>