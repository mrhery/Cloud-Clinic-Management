<?php

$show = input::get("show");

switch($show){
    default:
    case "all":
        $show = "all";
    break;

    case "invoice":
        $show = "invoice";
    break;

    case "credit":
        $show = "credit";
    break;

    case "debit":
        $show = "debit";
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
                <table class="table dataTable table-hover table-fluid mt-3">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">No</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Doc.</th>					
                            <th class="text-center" width="20%">Details</th>
                            <th class="text-right">Total</th>
                            <th class="text-right">Paid</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                    <?php

                        if(Session::get("clinic") == null){
                            // echo('<p class="text-danger mb-3">Plesae select clinic first to show list</p>');
                            switch($show){
                                case "all":
                                    $r = sales::list();
                                break;
                                
                                case "invoice":
                                    $r = sales::getBy(["s_type" => "invoice"]);
                                break;
                                
                                case "credit":
                                    $r = sales::getBy(["s_type" => "credit_note"]);
                                break;
                                
                                case "debit":
                                    $r = sales::getBy(["s_type" => "debit_note"]);
                                break;
                            }
                        }else{
                            switch($show){
                                case "all":
                                    $r = sales::getBy(["s_clinic" => Session::get("clinic")->c_id]);
                                break;
                                
                                case "invoice":
                                    $r = sales::getBy(["s_clinic" => Session::get("clinic")->c_id, "s_type" => "invoice"]);
                                break;
                                
                                case "credit":
                                    $r = sales::getBy(["s_clinic" => Session::get("clinic")->c_id, "s_type" => "credit_note"]);
                                break;
                                
                                case "debit":
                                    $r = sales::getBy(["s_clinic" => Session::get("clinic")->c_id, "s_type" => "debit_note"]);
                                break;
                            }
                        }
                        
                        
                        $no = 1;
                        
                        foreach($r as $s){
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-center"><?= $s->s_date ?></td>
                            <td class="text-center"><?= $s->s_doc ?></td>					
                            <td class="text-center"><?= $s->s_summary ?></td>
                            <td class="text-right"><?= number_format($s->s_total, 2) ?></td>
                            <td class="text-right"><?= number_format($s->s_paid, 2) ?></td>
                            <td class="text-center"><?= $s->s_status ?></td>
                            
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