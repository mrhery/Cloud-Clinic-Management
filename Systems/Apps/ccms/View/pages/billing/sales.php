<div class="row">
    <div class="col-md-12">
	<?php
		new Controller(["sales"]);
		Controller::alert();
	
		switch(url::get(2)){
			case "":
			case "list":
				Page::Load("pages/billing/sales/list");
			break;
			
			case "add":
				Page::Load("pages/billing/sales/add");
			break;
			
			case "view":
				Page::Load("pages/billing/sales/view");
			break;

			case "print":
				Page::Load("pages/billing/sales/print");
			break;
		}
	?>
	</div>
</div>