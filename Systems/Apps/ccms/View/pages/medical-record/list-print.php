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

                <h3 class="text-center">List Medical Records</h3>
                <table class="table dataTable table-fluid table-hover">
                    <thead>
                        <tr>
                            <th width="5%">No </th>
                            <th>Name </th>
                            <th class="text-center" width="20%">No. of Records</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $no = 1;
                        
                        if(Session::get("admin")){
                            $q = customers::list();
                        }else{
                            $q = DB::conn()->query("SELECT * FROM customers WHERE c_id IN (SELECT cc_customer FROM clinic_customer WHERE cc_clinic = ?)", [Session::get("clinic")->c_id])->results();
                        }
                        
                        foreach ($q as $c) {
                    ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= $c->c_name ?></td>
                                <td class="text-center"><?= count(customer_record::getBy(["cr_customer" => $c->c_id])) ?></td>
                                
                            </tr>
                        <?php } ?>
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