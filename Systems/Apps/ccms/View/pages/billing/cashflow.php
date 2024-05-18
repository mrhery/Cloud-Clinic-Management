<div class="row">
    <div class="col-md-12">
	<?php
		new Controller(["billing/cashflow"]);
		Controller::alert();
	
		switch(url::get(2)){
			case "":
			case "list":
				Page::Load("pages/billing/cashflow/list");
			break;
			
			case "add":
				Page::Load("pages/billing/cashflow/add");
			break;
			
			case "view":
				Page::Load("pages/billing/cashflow/view");
			break;
			
			case "edit":
				Page::Load("pages/billing/cashflow/edit");
			break;
			
			case "delete":
				Page::Load("pages/billing/cashflow/delete");
			break;
		}
	?>
	</div>
</div>