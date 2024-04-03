<div class="row">
    <div class="col-md-12">
        <?php
        new Controller(["pos"]);
        Controller::alert();

        switch (url::get(2)) {
            case "":
            case "list":
                Page::Load("pages/billing/pos/list");
                break;

                /* case "add":
				Page::Load("pages/billing/purchasing/add");
			break;
			
			case "view":
				Page::Load("pages/billing/purchasing/view");
			break; */
        }
        ?>
    </div>
</div>