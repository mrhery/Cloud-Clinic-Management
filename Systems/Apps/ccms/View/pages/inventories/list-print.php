<?php

$show = input::get("show");

switch($show){
	default:
	case "all":
		$show = "all";
	break;
	
	case "products":
		$show = "products";
	break;
	
	case "services":
		$show = "services";
	break;
	
	case "discounts":
		$show = "discounts";
	break;
	
	case "packages":
		$show = "packages";
	break;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            width: 21cm;
            height: 29.7cm;
            margin: auto;
            padding: 1cm;
            background-color: white;
        }
        .table th,
        .table td {
            border-width: 1px;
            border-color: black;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
            // $sales = sales::getBy(["s_clinic" => Session::get("clinic")->c_id, "s_type" => $show]);
        ?>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary" onclick="printDocument()">Print</button>

                <h3 class="text-center">List <?= ucfirst($show) ?> Records</h3>
                <table class="table dataTable table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" width="3%">No</th>
                            <th class="text-center" width="7%">Type</th>
                            <th class="">Details</th>
                            <th class="text-center" width="5%">Qty.</th>
                            <th class="text-center" width="5%">Code</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    <?php
                        $no = 1;

                        if(Session::get("clinic") == null){
                            // echo('<p class="text-danger mb-3">Plesae select clinic first to show list</p>');
                            switch($show){
                                default:
                                case "all":
                                    $r = items::list();
                                break;
                                
                                case "products":
                                    $r = items::getBy(["i_type" => "product"]);
                                break;
                                
                                case "services":
                                    $r = items::getBy(["i_type" => "service"]);
                                break;

                                case "discounts":
                                    $r = items::getBy(["i_type" => "discount"]);
                                break;
                                
                                case "packages":
                                    $r = items::getBy(["i_type" => "package"]);
                                break;
                            }
                        }else{
                            switch($show){
                                default:
                                case "all":
                                    $r = items::getBy(["i_clinic" => Session::get("clinic")->c_id]);
                                break;
                                
                                case "products":
                                    $r = items::getBy(["i_clinic" => Session::get("clinic")->c_id, "i_type" => "product"]);
                                break;
                                
                                case "services":
                                    $r = items::getBy(["i_clinic" => Session::get("clinic")->c_id, "i_type" => "service"]);
                                break;
                                
                                case "discounts":
                                    $r = items::getBy(["i_clinic" => Session::get("clinic")->c_id, "i_type" => "discount"]);
                                break;
                                
                                case "packages":
                                    $r = items::getBy(["i_clinic" => Session::get("clinic")->c_id, "i_type" => "package"]);
                                break;
                            }
                        }
                        
                        foreach($r as $i){
                    ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-center"><?= $i->i_type ?></td>
                            <td>
                                <?= $i->i_name ?><br /><br />
                                
                                <strong>Description</strong><br />
                                <?= $i->i_description ?><br /><br />
                                
                                <strong>Sales Price: </strong> RM <?= number_format($i->i_price, 2) ?> | <strong>Purchase Price:</strong> RM <?= number_format($i->i_cost, 2) ?>
                            </td>
                            
                            <td class="text-center">
                                <?= $i->i_quantity ?>
                            </td>
                            
                            <td class="text-center">
                                <?= $i->i_code ?>
                            </td>

                        </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function printDocument() {
            window.print();
        }
    </script>
</body>
</html>