<?php

$show = input::get("show");

switch($show){
    default:
    case "today":
        $show = "today";
    break;

    case "now":
        $show = "now";
    break;

    case "tomorrow":
        $show = "tomorrow";
    break;

    case "week":
        $show = "week";
    break;

    case "month":
        $show = "month";
    break;

    case "year":
        $show = "year";
    break;

    case "pending":
        $show = "pending";
    break;

    case "all":
        $show = "all";
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
            <div class="d-flex justify-content-between">
            <a href="<?= PORTAL ?>appointments" class="btn btn btn-primary mr-2">
			<span class="fa fa-arrow-left"></span> Back
		</a>
                <button class="btn btn-primary" onclick="printDocument()">Print</button>
            </div>
                <h3 class="text-center">List <?= ucfirst($show) ?> Records</h3>
                <table class="table dataTable table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" width="3%">No</th>
                            <th class="text-center" width="7%">Datetime</th>
                            <th class="">Appointment</th>
                            <th class="text-center" width="5%">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;

                        switch ($show) {
                            case "today":
                                $r = Session::get("admin") ? appointments::getBy(["a_date" => date("d-M-Y")]) : appointments::getBy(["a_date" => date("d-M-Y"), "a_clinic" => Session::get("clinic")->c_id]);
                                break;

                            case "now":
                                $b = strtotime("-2 hours");
                                $a = strtotime("+2 hours");

                                if (Session::get("admin")) {
                                    $r = DB::conn()->query("SELECT * FROM appointments WHERE a_time > ? AND a_time < ?", [$b, $a])->results();
                                } else {
                                    $r = DB::conn()->query("SELECT * FROM appointments WHERE a_time > ? AND a_time < ? AND a_clinic = ?", [$b, $a, Session::get("clinic")->c_id])->results();
                                }
                                break;

                            case "tomorrow":
                                if (Session::get("admin")) {
                                    $r = appointments::getBy(["a_date" => date("d-M-Y", strtotime("+1 day"))]);
                                } else {
                                    $r = appointments::getBy(["a_date" => date("d-M-Y", strtotime("+1 day")), "a_clinic" => Session::get("clinic")->c_id]);
                                }

                                break;

                            case "week":
                                $b = strtotime("-3 days");
                                $a = strtotime("+3 days");

                                if (Session::get("admin")) {
                                    $r = DB::conn()->query("SELECT * FROM appointments WHERE a_time > ? AND a_time < ?", [$b, $a])->results();
                                } else {
                                    $r = DB::conn()->query("SELECT * FROM appointments WHERE a_time > ? AND a_time < ? AND a_clinic = ?", [$b, $a, Session::get("clinic")->c_id])->results();
                                }
                                break;

                            case "month":
                                if (Session::get("admin")) {
                                    $r = DB::conn()->query("SELECT * FROM appointments WHERE a_date LIKE ?", ["%" . date("M-Y") . "%"])->results();
                                } else {
                                    $r = DB::conn()->query("SELECT * FROM appointments WHERE a_date LIKE ? AND a_clinic = ?", ["%" . date("M-Y") . "%", Session::get("clinic")->c_id])->results();
                                }
                                break;

                            case "year":
                                if (Session::get("admin")) {
                                    $r = DB::conn()->query("SELECT * FROM appointments WHERE a_date LIKE ?", ["%" . date("-Y") . "%"])->results();
                                } else {
                                    $r = DB::conn()->query("SELECT * FROM appointments WHERE a_date LIKE ? AND a_clinic = ?", ["%" . date("-Y") . "%", Session::get("clinic")->c_id])->results();
                                }
                                break;

                            case "all":
                                if (Session::get("admin")) {
                                    $r = DB::conn()->query("SELECT * FROM appointments")->results();
                                } else {
                                    $r = DB::conn()->query("SELECT * FROM appointments WHERE a_clinic = ?", [Session::get("clinic")->c_id])->results();
                                }
                                break;

                            case "pending":
                                if (Session::get("admin")) {
                                    $r = appointments::getBy(["a_status" => 0]);
                                } else {
                                    $r = appointments::getBy(["a_status" => 0, "a_clinic" => Session::get("clinic")->c_id]);
                                }
                                break;
                        }

                        foreach ($r as $a) {
                            $c = customers::getBy(["c_id" => $a->a_customer])[0];
                        ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center"><?= date("d M Y H:i:s\ ", $a->a_time) ?></td>
                                <td>
                                    <strong>Customer</strong><br />
                                    <?= $c->c_name ?> (<?= $c->c_ic ?>)<br /><br />

                                    <strong>Description</strong><br />
                                    <?= $a->a_reason ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    switch ($a->a_status) {
                                        case "1":
                                            echo "Approved";
                                            break;
                                        case "0":
                                            echo "Pending";
                                            break;
                                        case "2":
                                            echo "Cancelled";
                                            break;
                                    }
                                    ?>
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