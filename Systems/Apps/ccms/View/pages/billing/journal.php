<div class="row">
    <div class="col-md-12">
	<?php
		new Controller(["billing/journal"]);
		Controller::alert();
	
		switch(url::get(2)){
			case "":
			case "list":
				Page::Load("pages/billing/journal/list");
			break;
			
			case "add":
				Page::Load("pages/billing/journal/add");
			break;
			
			case "view":
				Page::Load("pages/billing/journal/view");
			break;
			
			case "edit":
				Page::Load("pages/billing/journal/edit");
			break;
			
			case "delete":
				Page::Load("pages/billing/journal/delete");
			break;
		}
	?>
	</div>
</div>