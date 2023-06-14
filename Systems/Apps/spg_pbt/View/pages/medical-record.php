<div class="row">
    <div class="col-md-12">
	<?php
		switch(url::get(1)){
			case "":
			case "list":
				Page::Load("pages/medical-record/list");
			break;
			
			case "create":
				Page::Load("pages/medical-record/create");
			break;
			
			case "edit":
				Page::Load("pages/medical-record/edit");
			break;
		}
	?>
	</div>
</div>