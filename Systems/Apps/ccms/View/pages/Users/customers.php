<?php
new Controller(["customer"]);
?>
<div class="row">
	<div class="col-md-12">
	<?php
		echo Controller::alert();
		
		switch(url::get(2)){
			case "":
			case "list":
				Page::Load("pages/Users/customer/list");
			break;
			
			case "edit":
				Page::Load("pages/Users/customer/edit");
			break;
			
			case "view":
				Page::Load("pages/Users/customer/view");
			break;
			
			case "delete":
				Page::Load("pages/Users/customer/delete");
			break;
			
			case "add":
				Page::Load("pages/Users/customer/add");
			break;
		}
	?>
	</div>
</div>	