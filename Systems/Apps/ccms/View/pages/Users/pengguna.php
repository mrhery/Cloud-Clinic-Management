<?php
new Controller(["pengguna"]);
?>
<div class="row">
	<div class="col-md-12">
	<?php
		// Controller::alert();
		
		switch(url::get(2)){
			case "":
			case "list":
				Page::Load("pages/Users/pengguna/list");
			break;
			
			case "edit":
				Page::Load("pages/Users/pengguna/edit");
			break;
			
			case "view":
				Page::Load("pages/Users/pengguna/view");
			break;
			
			case "delete":
				Page::Load("pages/Users/pengguna/delete");
			break;
			
			case "add":
				Page::Load("pages/Users/pengguna/add");
			break;
		}
	?>
	</div>
</div>	