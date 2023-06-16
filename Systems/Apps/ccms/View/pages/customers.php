<?php
new Controller(["customer"]);
?>
<div class="row">
	<div class="col-md-12">
	<?php
		echo Controller::alert();
		
		switch(url::get(1)){
			case "":
			case "list":
				Page::Load("pages/customer/list");
			break;
			
			case "edit":
				Page::Load("pages/customer/edit");
			break;
			
			case "view":
				Page::Load("pages/customer/view");
			break;
			
			case "delete":
				Page::Load("pages/customer/delete");
			break;
			
			case "add":
				Page::Load("pages/customer/add");
			break;
		}
	?>
	</div>
</div>	