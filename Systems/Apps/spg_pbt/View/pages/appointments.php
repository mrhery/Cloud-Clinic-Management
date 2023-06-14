<div class="row">
    <div class="col-md-12">
	<?php
		switch(url::get(1)){
			case "":
			case "list":
				Page::Load("pages/appointment/list");
			break;
			
			case "create":
				Page::Load("pages/appointment/create");
			break;
			
			case "edit":
				Page::Load("pages/appointment/edit");
			break;
		}
	?>
	</div>
</div>