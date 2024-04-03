<div class="row">
	<div class="col-md-12">
		<?php

		new Controller(["clients"]);
		Controller::alert();

		switch (url::get(2)) {
			case "":
			case "list":
				Page::Load("pages/billing/supplier/list");
				break;

			case "add":
				Page::Load("pages/billing/supplier/add");
				break;

			case "edit":
				Page::Load("pages/billing/supplier/edit");
				break;

			case "delete":
				Page::Load("pages/billing/supplier/delete");
					break;
		}

		?>
	</div>
</div>