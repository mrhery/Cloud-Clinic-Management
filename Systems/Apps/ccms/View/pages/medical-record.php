<div class="row">
    <div class="col-md-12">
	<?php
		new Controller(["medical-record"]);
		Controller::alert();
		
		switch(url::get(1)){
			case "":
			case "list":
				Page::Load("pages/medical-record/list");
			break;
			
			case "pre-create":
				Page::Load("pages/medical-record/pre-create");
			break;
			
			case "create":
				Page::Load("pages/medical-record/create");
			break;
			
			case "view":
				Page::Load("pages/medical-record/view");
			break;
		}
	?>
	</div>
</div>