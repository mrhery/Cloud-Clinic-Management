<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');
date_default_timezone_set('Asia/Kuala_Lumpur');


header("Content-Type: application/json");

$conn = mysqli_connect("127.0.0.1", "cloudcms_ccms", "#CloudCMS@123#", "cloudcms_ccms");
mysqli_query($conn, "SET time_zone = '+08:00'");
//var_dump($conn);


if(!$conn){
	die(json_encode([
		"status"	=> "error",
		"message"	=> "Fail connect to database."
	]));
}


if(isset($_GET["key"]) && $_GET["key"] == "asdljnalsdasd"){
	if(isset($_GET["action"])){
		switch($_GET["action"]){
			case "login":
				if(isset($_POST["username"], $_POST["password"])){
					$salt = '5a7347f6fda4a346760af782d2ec126f7b9873ea9a*&(*9yad09707d0a7d0ad!@#!@#!#!#!$#!$!$!#$!$!$!$!$!%@$%#&&*^(7f2bb1fee9abdfd5f4dfc9';
					$string = $_POST["password"];
					 
					$pass = hash("sha256", $string . $salt);
					
					$q = mysqli_query($conn, "SELECT * FROM users 
						WHERE u_email = '{$_POST["username"]}' AND
						u_password = '$pass'
					");
					
					$n = mysqli_num_rows($q);
					
					if($n > 0){
						$row = mysqli_fetch_assoc($q);
						die(json_encode([
							"status"	=> "success",
							"message"	=> "Login in success",
							"u_ukey"    => $row['u_ukey']
						]));
					}else{
						die(json_encode([
							"status"	=> "error",
							"message"	=> "Username or password is incorrect"
						]));
					}
				}else{
					die(json_encode([
						"status"	=> "error",
						"message"	=> "Insufficient request paramater"
					]));
				}
			break;

			case "getClinics":
				$userId = getUserID($conn, $_GET['ukey']);

				$query = mysqli_query($conn, "SELECT c.c_name, c.c_ukey FROM clinics as c JOIN clinic_user as cu ON c.c_id = cu.cu_clinic WHERE cu.cu_user = '$userId'");
				$clinics = [];
				while($row = mysqli_fetch_assoc($query)) {
					$clinics[] = $row;
				}
				echo json_encode($clinics);
				exit;
			break;

			case "dashboard":
				$userId = getUserID($conn, $_GET['userkey']);
				$clinicId = getClinicID($conn, $_GET['clinickey']);

				$name = "SELECT u_name FROM users WHERE u_id = $userId";
				$result = mysqli_query($conn, $name);

				$monthAppointments = "SELECT count(*) as total FROM appointments WHERE a_clinic = $clinicId AND a_status = 1 AND YEAR(FROM_UNIXTIME(a_time)) = YEAR(CURRENT_DATE()) AND MONTH(FROM_UNIXTIME(a_time)) = MONTH(CURRENT_DATE())";
                $result1 = mysqli_query($conn, $monthAppointments);
				
                $todayAppointments = "SELECT count(*) as total FROM appointments WHERE a_clinic = $clinicId AND a_status = 1 AND DATE(FROM_UNIXTIME(a_time)) = current_date()";
                $result2 = mysqli_query($conn, $todayAppointments);

				$totalClient = "SELECT count(*) as total FROM customers as c JOIN clinic_customer as cc ON c.c_id = cc.cc_customer WHERE cc.cc_clinic = '$clinicId'";
                $result3 = mysqli_query($conn, $totalClient);

				$reqestAppointments = "SELECT a.a_date, a.a_time, a.a_reason, a.a_createdDate, clinics.c_name as clinic_name, customers.c_name as customer_name
                FROM appointments as a
                LEFT JOIN clinics ON a.a_clinic = clinics.c_id 
                LEFT JOIN customers ON a.a_customer = customers.c_id
                WHERE a.a_status = 0
				AND a.a_clinic = $clinicId
                ORDER BY a.a_createdDate DESC
                LIMIT 3";

                $result4 = mysqli_query($conn, $reqestAppointments);

                $upcomingAppointments = "SELECT a.a_ukey, a.a_date,  a.a_time, a.a_reason, a.a_createdDate, 
				clinics.c_name AS clinicname, customers.c_name AS customername  
                FROM appointments AS a
                LEFT JOIN clinics ON a.a_clinic = clinics.c_id 
                LEFT JOIN customers ON a.a_customer = customers.c_id
                WHERE a.a_status = 1
				AND a.a_clinic = $clinicId
                AND a.a_time >= UNIX_TIMESTAMP(NOW())
                ORDER BY a.a_time ASC
                LIMIT 3";
                $result5 = mysqli_query($conn, $upcomingAppointments);

                $nextAppointments = "SELECT a.a_date,  a.a_time, a.a_reason, a.a_createdDate, 
                clinics.c_name AS clinicname, customers.c_name AS customername, customers.c_phone AS customerphone, customers.c_email AS customeremail, 
                customers.c_ic AS customeric
                FROM appointments as a
                LEFT JOIN clinics ON a.a_clinic = clinics.c_id 
                LEFT JOIN customers ON a.a_customer = customers.c_id
                WHERE a.a_status = 1
				AND a.a_clinic = $clinicId
                AND a.a_time > UNIX_TIMESTAMP(NOW())
                ORDER BY a.a_time ASC
                LIMIT 1";
                $result6 = mysqli_query($conn, $nextAppointments);

				$subQuery = "SELECT a.a_customer
                FROM appointments as a
                LEFT JOIN clinics ON a.a_clinic = clinics.c_id 
                LEFT JOIN customers ON a.a_customer = customers.c_id
                WHERE a.a_status = 1
				AND a.a_clinic = $clinicId
                AND a.a_time >= UNIX_TIMESTAMP(NOW())
                ORDER BY a.a_time ASC
                LIMIT 1";
                $resultSubQuery = mysqli_query($conn, $subQuery);
                $dataSubQuery = mysqli_fetch_assoc($resultSubQuery);

				$data1 = mysqli_fetch_assoc($result1);
				$data2 = mysqli_fetch_assoc($result2);
				$data3 = mysqli_fetch_assoc($result3);
				$data4 = mysqli_fetch_all($result4);
				$data5 = mysqli_fetch_all($result5, MYSQLI_ASSOC);
				$data6 = mysqli_fetch_assoc($result6);

				foreach ($data5 as $key => $appointment) {
					$data5[$key]['a_time'] = date('d M Y h:i A', $appointment['a_time']);
				}

				if($data6){
					$data6['a_time'] = date('d M Y h:i A', $data6['a_time']);
					$customerInfo = parseCustomerIC($data6['customeric']);
					$data6['age'] = $customerInfo['age'];
					$data6['sex'] = $customerInfo['sex'];
				}


				if($dataSubQuery !== null){
					$historyQuery = "SELECT a_reason FROM appointments 
					WHERE a_customer = " . $dataSubQuery['a_customer'] . " 
					AND a_time < UNIX_TIMESTAMP(NOW())
					ORDER BY a_time DESC";
					$result7 = mysqli_query($conn, $historyQuery);

					$lastAppointmentQuery = "SELECT a_time FROM appointments
					WHERE a_customer = " . $dataSubQuery['a_customer'] . " 
					AND a_time < UNIX_TIMESTAMP(NOW())
					ORDER BY a_time DESC
					LIMIT 1";
					$result8 = mysqli_query($conn, $lastAppointmentQuery);

					$data7 = mysqli_fetch_all($result7);
					$data8 = mysqli_fetch_assoc($result8);

					if(empty($data7)){
						$data7 = ['No record'];
					}
					
					if($data8){
						$data8['a_time'] = date('d M Y h:i A', $data8['a_time']);
					} else {
						$data8 = ['a_time' => 'New Patient'];
					}
				
					

					echo json_encode([
						"status" => "success",
						"username" => mysqli_fetch_assoc($result)['u_name'],
						"monthAppointments" => $data1['total'],
						"todayAppointments" => $data2['total'],
						"totalClient" => $data3['total'],
						"reqestAppointments" => $data4,
						"upcomingAppointments" => $data5,
						"nextAppointments" => $data6,
						"nextHistory" => $data7,
						"lastAppointment" => $data8
					]);
				}else{

					$data8 = ['a_time' => 'N/A'];

					echo json_encode([
						"status" => "success",
						"username" => mysqli_fetch_assoc($result)['u_name'],
						"monthAppointments" => $data1['total'],
						"todayAppointments" => $data2['total'],
						"totalClient" => $data3['total'],
						"reqestAppointments" => $data4,
						"upcomingAppointments" => $data5,
						"nextAppointments" => $data6,
						"lastAppointment" => $data8,
	
					]);
				}
				
			break;

			case "getAppointments":
				$userId = getUserID($conn, $_GET['userkey']);
				$clinicId = getClinicID($conn, $_GET['clinickey']);

				$type = $_GET['type'];
				$dateCondition = "";
			
				switch ($type) {
					case 'today':
						$dateCondition = "DATE(FROM_UNIXTIME(a.a_time)) = current_date()";
						break;
					case 'tomorrow':
						$dateCondition = "DATE(FROM_UNIXTIME(a.a_time)) = DATE_ADD(current_date(), INTERVAL 1 DAY)";
						break;
					case 'week':
						$dateCondition = "WEEK(FROM_UNIXTIME(a.a_time)) = WEEK(current_date())";
						break;
					case 'all':
						$dateCondition = "1"; // Always true, selects all appointments
						break;
				}
			
				$query = mysqli_query($conn, "SELECT a.*, clinics.c_name AS clinic_name, customers.c_name AS customer_name FROM appointments AS a
											   INNER JOIN clinics ON a.a_clinic = clinics.c_id
											   INNER JOIN customers ON a.a_customer = customers.c_id
											   WHERE $dateCondition
											   AND a.a_clinic = $clinicId
											   ORDER BY a.a_time DESC");
				$appointments = [];
				while($row = mysqli_fetch_assoc($query)) {
					$appointments[] = $row;
				}

				if($appointments){
					foreach ($appointments as $key => $appointment) {
						$appointments[$key]['a_time'] = date('d M Y h:i A', $appointment['a_time']);
						if($appointment['a_status'] == 2){
							$appointments[$key]['a_status'] = 'Rejected';
						} elseif($appointment['a_status'] == 1) {
							$appointments[$key]['a_status'] = 'Approved';
						} else {
							$appointments[$key]['a_status'] = 'Pending';
						}
					}
				}
				echo json_encode($appointments);
				exit;
			break;

			case "requestAppointments":
				$userId = getUserID($conn, $_GET['userkey']);
				$clinicId = getClinicID($conn, $_GET['clinickey']);

                $reqestAppointments = "SELECT a.a_date, a.a_time, a.a_reason, a.a_createdDate, a.a_ukey,
                clinics.c_name as clinic_name, customers.c_name as customer_name
                FROM appointments as a
                LEFT JOIN clinics ON a.a_clinic = clinics.c_id 
                LEFT JOIN customers ON a.a_customer = customers.c_id
                WHERE a.a_status = 0
				AND a.a_clinic = $clinicId
                ORDER BY a.a_createdDate DESC";
                $result1 = mysqli_query($conn, $reqestAppointments);

                if($result1){
                    $data1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
                    foreach ($data1 as $key => $appointment) {
                        $data1[$key]['a_time'] = date('d M Y h:i A', $appointment['a_time']);
                    }

                    echo json_encode([
                        "status" => "success",
                        "data" => $data1
                    ]);
                } else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "Failed to execute query."
                    ]);
                }

            break;

            case "actionAppointments":
                if(isset($_POST["id"]) && $_POST["action"] == "approve"){
                    $id = $_POST["id"];
                    $query = "UPDATE appointments SET a_status = 1 WHERE a_ukey = '$id'";
                    $result = mysqli_query($conn, $query);
            
                    if($result){
                        echo json_encode([
                            "status" => "success",
                            "message" => "Appointment approved."
                        ]);
                    } else {
                        echo json_encode([
                            "status" => "error",
                            "message" => "Failed to execute query."
                        ]);
                    }
                } elseif (isset($_POST["id"]) && $_POST["action"] == "reject") {
                    $id = $_POST["id"];
                    $query = "UPDATE appointments SET a_status = 2 WHERE a_ukey = '$id'";
                    $result = mysqli_query($conn, $query);
            
                    if($result){
                        echo json_encode([
                            "status" => "success",
                            "message" => "Appointment rejected."
                        ]);
                    } else {
                        echo json_encode([
                            "status" => "error",
                            "message" => "Failed to execute query."
                        ]);
                    }
                } else {
                    echo json_encode([
                        "status" => "error",
                        "message" => "Appointment ID is required."
                    ]);
                }
                
            break;

			case "detail":
                if(isset($_GET["id"])){
                    $id = $_GET["id"];
                    $query = "SELECT a.a_date, a.a_time, a.a_reason, a.a_createdDate, a.a_status, a.a_customer,
                    c.c_name AS clinicname, cu.c_name AS customername, cu.c_phone AS customerphone, cu.c_email AS customeremail, cu.c_ic AS customeric
                    FROM appointments as a
                    LEFT JOIN clinics as c ON a.a_clinic = c.c_id 
                    LEFT JOIN customers as cu ON a.a_customer = cu.c_id
                    WHERE a.a_ukey = '$id'";
                    $result = mysqli_query($conn, $query);

                    if($result){
                        $data = mysqli_fetch_assoc($result);
                        $data['a_time'] = date('d M Y h:i A', $data['a_time']);
                        $customerInfo = parseCustomerIC($data['customeric']);
                        $data['age'] = $customerInfo['age'];
                        $data['sex'] = $customerInfo['sex'];
                    }

                    $lastAppointmentQuery = "SELECT a_time FROM appointments
                    WHERE a_customer = " . $data['a_customer'] . " 
                    AND a_time < UNIX_TIMESTAMP(NOW())
                    ORDER BY a_time DESC
                    LIMIT 1";
                    $result2 = mysqli_query($conn, $lastAppointmentQuery);

                    $historyQuery = "SELECT a_reason FROM appointments 
                    WHERE a_customer = " . $data['a_customer'] . " 
                    AND a_time < UNIX_TIMESTAMP(NOW())
                    ORDER BY a_time DESC
                    LIMIT 6";
                    $result3 = mysqli_query($conn, $historyQuery);

                    
                    if($result2){
                        $data['lastAppointment'] = mysqli_fetch_assoc($result2);
                        if ($data['lastAppointment']) {
                            $data['lastAppointment']['a_time'] = date('d M Y h:i A', $data['lastAppointment']['a_time']);
                        } else {
                            $data['lastAppointment'] = ['a_time' => 'New Patient'];
                        }
                    }

                    if($result3){
                        $data['nextReason'] = mysqli_fetch_all($result3);
                        if(empty($data['nextReason'])){
                            $data['nextReason'] = ['No record'];
                        }
                    }

                    echo json_encode([
                        "status" => "success",
                        "data" => $data,
                        
                    ]);
                }else{
                    echo json_encode([
                        "status" => "error",
                        "message" => "Appointment ID is required."
                    ]);
                }

            break;

			case "myProfile":
				$userId = getUserID($conn, $_GET['userkey']);
				$query = mysqli_query($conn, "SELECT u_name, u_email, u_phone, u_alamat FROM users WHERE u_id = $userId");
				$data = mysqli_fetch_assoc($query);
				echo json_encode($data);
				exit;

			break;

			case "updateProfile":
				if(isset($_POST["userkey"])){
					$userId = getUserID($conn, $_POST['userkey']);
					$name = $_POST['name'];
					$email = $_POST['email'];
					$phone = $_POST['phone'];
					$address = $_POST['address'];

					$query = "UPDATE users SET u_name = '$name', u_email = '$email', u_phone = '$phone', u_alamat = '$address' WHERE u_id = $userId";
					$result = mysqli_query($conn, $query);

					if($result){
						echo json_encode([
							"status" => "success",
							"message" => "Profile updated.",
						]);
					} else {
						echo json_encode([
							"status" => "error",
							"message" => "Failed to execute query."
						]);
					}
					exit;
				}else{
					echo json_encode([
						"status" => "error",
						"message" => "User key is required."
					]);
				}
				
			break;

			//===========customers===========//

			case "loginCustomer":
				if(isset($_POST["username"], $_POST["password"])){
					$salt = '5a7347f6fda4a346760af782d2ec126f7b9873ea9a*&(*9yad09707d0a7d0ad!@#!@#!#!#!$#!$!$!#$!$!$!$!$!%@$%#&&*^(7f2bb1fee9abdfd5f4dfc9';
					$string = $_POST["password"];
					 
					$pass = hash("sha256", $string . $salt);
					
					$q = mysqli_query($conn, "SELECT * FROM customers 
						WHERE c_email = '". $_POST["username"] . "' AND 
						c_password = '$pass'
					");
					
					$n = mysqli_num_rows($q);
					
					if($n > 0){
						$row = mysqli_fetch_assoc($q);
						die(json_encode([
							"status"	=> "success",
							"message"	=> "Login in success",
							"c_ukey"    => $row['c_ukey']
						]));
					}else{
						die(json_encode([
							"status"	=> "error",
							"message"	=> "Username or password is incorrect."
						]));
					}
				}else{
					die(json_encode([
						"status"	=> "error",
						"message"	=> "Insufficient request paramater"
					]));
				}
			break;

			case "customerDashboard":

				$userId = getCustomerID($conn, $_GET['userkey']);

				$query = mysqli_query($conn, "SELECT c_name FROM customers WHERE c_id = $userId");
				// $data = mysqli_fetch_assoc($query);
				// echo json_encode($data);

				$requestAppointments = "SELECT a.a_date, a.a_time, a.a_reason, a.a_createdDate, clinics.c_name as clinic_name, customers.c_name as customer_name
                FROM appointments as a
                LEFT JOIN clinics ON a.a_clinic = clinics.c_id 
                LEFT JOIN customers ON a.a_customer = customers.c_id
                WHERE a.a_status = 0
				AND a.a_customer = $userId
                ORDER BY a.a_createdDate DESC
                LIMIT 3";

                $result1 = mysqli_query($conn, $requestAppointments);

				$upcomingAppointments = "SELECT a.a_ukey, a.a_date,  a.a_time, a.a_reason, a.a_createdDate, 
				clinics.c_name AS clinicname, customers.c_name AS customername  
                FROM appointments AS a
                LEFT JOIN clinics ON a.a_clinic = clinics.c_id 
                LEFT JOIN customers ON a.a_customer = customers.c_id
                WHERE a.a_status = 1
				AND a.a_customer = $userId
                AND a.a_time >= UNIX_TIMESTAMP(NOW())
                ORDER BY a.a_time ASC
                LIMIT 3";

                $result2 = mysqli_query($conn, $upcomingAppointments);

				$data1 = mysqli_fetch_all($result1);
				$data2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);

				foreach ($data2 as $key => $appointment) {
					$data2[$key]['a_time'] = date('d M Y h:i A', $appointment['a_time']);
				}

				echo json_encode([
					"status" => "success",
					"username" => mysqli_fetch_assoc($query)['c_name'],
					"requestAppointments" => $data1,
					"upcomingAppointments" => $data2,

				]);


			break;
			case "getCustomerAppointments":
				$userId = getCustomerID($conn, $_GET['userkey']);

				$query = mysqli_query($conn, "SELECT a.*, clinics.c_name AS clinic_name FROM appointments AS a
											   INNER JOIN clinics ON a.a_clinic = clinics.c_id
											   WHERE a.a_customer = $userId
											   ORDER BY a.a_time DESC");
				$appointments = [];
				while($row = mysqli_fetch_assoc($query)) {
					$appointments[] = $row;
				}

				if($appointments){
					foreach ($appointments as $key => $appointment) {
						$appointments[$key]['a_time'] = date('d M Y h:i A', $appointment['a_time']);
						if($appointment['a_status'] == 2){
							$appointments[$key]['a_status'] = 'Rejected';
						} elseif($appointment['a_status'] == 1) {
							$appointments[$key]['a_status'] = 'Approved';
						} else {
							$appointments[$key]['a_status'] = 'Pending';
						}
					}
				}

				echo json_encode($appointments);

			break;

			case "getCustomerClinic":
				$userId = getCustomerID($conn, $_GET['userkey']);

				$query = mysqli_query($conn, "SELECT c.c_name, c.c_ukey, c.c_id, c.c_address FROM clinics as c JOIN clinic_customer as cc ON c.c_id = cc.cc_clinic WHERE cc.cc_customer = '$userId'");
				$clinics = [];
				while($row = mysqli_fetch_assoc($query)) {
					$clinics[] = $row;
				}
				echo json_encode($clinics);
				exit;

			break;

			case "addCustomerAppointment" :
				$userId = getCustomerID($conn, $_GET['userkey']);

				$clinicId = $_POST['clinicId'];
				$date = $_POST['date'];
				$time = strtotime($_POST['date'] . ' ' . $_POST['time']);
				$reason = $_POST['description'];
				$today = date('d-M-Y');

				$ukey = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);
				$query = "INSERT INTO appointments (a_ukey, a_customer, a_clinic, a_date, a_time, a_reason, a_status, a_createdDate) VALUES ('$ukey', $userId, $clinicId, '$date', '$time', '$reason', 0, '$today')";
				$result = mysqli_query($conn, $query);

				if($result){
					echo json_encode([
						"status" => "success",
						"message" => "Profile updated.",
					]);
				} else {
					echo json_encode([
						"status" => "error",
						"message" => "Failed to execute query."
					]);
				}
				exit;

			break;

			case "customerProfile":
				$userId = getCustomerID($conn, $_GET['userkey']);

				$query = mysqli_query($conn, "SELECT c_name, c_email, c_phone, c_address, c_ic FROM customers WHERE c_id = $userId");
				$data = mysqli_fetch_assoc($query);
				echo json_encode($data);
				exit;

			break;

			case "updateCustomerProfile":

				if(isset($_POST["userkey"])){
					$userId = getCustomerID($conn, $_POST['userkey']);
					$name = $_POST['name'];
					$email = $_POST['email'];
					$phone = $_POST['phone'];
					$address = $_POST['address'];

					$query = "UPDATE customers SET c_name = '$name', c_email = '$email', c_phone = '$phone', c_address = '$address' WHERE c_id = $userId";
					$result = mysqli_query($conn, $query);

					if($result){
						echo json_encode([
							"status" => "success",
							"message" => "Profile updated.",
						]);
					} else {
						echo json_encode([
							"status" => "error",
							"message" => "Failed to execute query."
						]);
					}
					exit;
				}else{
					echo json_encode([
						"status" => "error",
						"message" => "User key is required."
					]);
				}

			break;


		}
	}else{
		die(json_encode([
			"status"	=> "error",
			"message"	=> "Unknown API endpoint."
		]));
	}

}else{
	die(json_encode([
		"status"	=> "error",
		"message"	=> "API Key is invalid."
	]));
}


function parseCustomerIC($customeric) {
    $birthYear = substr($customeric, 0, 2);
    $currentYear = date('Y') % 100;
    $age = ($birthYear <= $currentYear) ? $currentYear - $birthYear : $currentYear + (100 - $birthYear);

    $sexDigit = substr($customeric, -1);
    $sex = $sexDigit % 2 == 0 ? 'Female' : 'Male';

    return ['age' => $age, 'sex' => $sex];
}

function getUserID($conn, $ukey) {
	$userQuery = mysqli_query($conn, "SELECT u_id FROM users WHERE u_ukey = '$ukey'");
	$user = mysqli_fetch_assoc($userQuery);
	return $user['u_id'];
}

function getClinicID($conn, $c_ukey) {
	$clinicQuery = mysqli_query($conn, "SELECT c_id FROM clinics WHERE c_ukey = '$c_ukey'");
	$clinic = mysqli_fetch_assoc($clinicQuery);
	return $clinic['c_id'];
}

function getCustomerID($conn, $ukey) {
	$userQuery = mysqli_query($conn, "SELECT c_id FROM customers WHERE c_ukey = '$ukey'");
	$user = mysqli_fetch_assoc($userQuery);
	return $user['c_id'];
}