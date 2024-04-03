<div class="row">
	<div class="col-md-12">
		<?php

		new Controller(["businesses"]);
		Controller::alert();

		switch (url::get(1)) {
			case "":
			case "list":
				Page::Load("pages/businesses/list");
				break;

			case "add":
				Page::Load("pages/businesses/add");
				break;

			case "edit":
				Page::Load("pages/businesses/edit");
				break;
			case "delete":
				Page::Load("pages/businesses/delete");
				break;
		}

		?>
	</div>
</div>