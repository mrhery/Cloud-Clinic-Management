<?php
//A journey start with a step

$page = new Page();
$page->addTopTag('
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="Sistem Pengurusan Gerai" />

<!--
<link rel="shortcut icon" href="./assets/img/favicons/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="./assets/img/favicons/apple-touch-icon.png" />
<link rel="icon" type="image/png" sizes="32x32" href="./assets/img/favicons/favicon-32x32.png" />
<link rel="icon" type="image/png" sizes="16x16" href="./assets/img/favicons/favicon-16x16.png" />
-->

<meta name="msapplication-TileColor" content="#da532c" />
<meta name="theme-color" content="#ffffff" />
<link href="' . PORTAL . 'assets/css/main.89d50cb6ee50eddf8f9a.css" rel="stylesheet" />
<!-- 
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" /> 
-->
<link rel="stylesheet" href="' . PORTAL . 'assets/vendor/select2/select2.min.css" />
<!--<link rel="stylesheet" href="' . PORTAL . 'assets/vendor/chartjs/chart.min.css" />-->
<link rel="stylesheet" href="' . PORTAL . 'assets/vendor/font-awesome/css/font-awesome.min.css" />
<link rel="stylesheet" href="' . PORTAL . 'assets/vendor/bs-select/bs-select.css" />
<link rel="stylesheet" href="' . PORTAL . 'assets/vendor/datatable/dataTables.min.css" />

<script>
let PORTAL = "' . PORTAL . '";
</script>


');

$page->addBottomTag('
<script src="' . PORTAL . 'assets/vendor/jquery/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="' . PORTAL . 'assets/main.js"></script>
<script src="' . PORTAL . 'assets/vendor/select2/select2.min.js"></script>
<script src="' . PORTAL . 'assets/vendor/chartjs/chart.min.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="https://code.iconify.design/2/2.1.2/iconify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js"></script>
<script src="' . PORTAL . 'assets/vendor/datatable/dataTables.min.js"></script>



<script>
$(".dataTable").DataTable();

</script>
');

if (!Session::exists("user")) {
	switch (url::get(0)) {
		case "login":
		case "index":
			$page->setBodyAttribute("class='lena-centered-body text-center'");
			$page->title = "Log Masuk - " . APP_NAME;
			$page->loadPage("login");
			$page->render();
			break;

		case "register":
			$page->title = "Pendaftaran - " . APP_NAME;
			$page->loadPage("register");
			$page->render();
			break;

		default:
			$page->title = "Tidak Dijumpai - " . APP_NAME;
			$page->loadPage("404");
			$page->render();
			break;
		
		// case "decode":
			// header("Content-Type: image/png");
			// echo base64_decode("iVBORw0KGgoAAAANSUhEUgAAAG4AAAB+CAMAAADyU9RSAAAAn1BMVEX////tHCQAAADsAABYWFj96OjsAw2kpKTV1dX4wsP3srP2qqrtGCDtEx2goKDe3t7wVFXuLTP1nZ5fX1/CwsL+8/L719jzjI7uMznsBBTyc3OgFRuZEhfziIr2HSV3DhIeHh5ECApKSkr84eLwWlxxAAAREREmJibMzMybAAegCxLuJCupFRs6BwgxAADawcHvRknzgIHxamy+goPfpKUTNIuKAAADbklEQVRoge3ba3ebIAAGYAmVzghrks4LbulN261zbZO0//+3zaggeCdCzlnn+82D4UHCzfbEsnguFyfn5xdLORO4xULdm8TdKXuTOHVvGqfsFdzDhWKu707zCu5KrY1ZrtnzPSl5Bac+xK6rDlVpqwZOxdPBKXhauPGeHm70eNHDjfY0cWPnny5u5P6gjRv3fPq4UZ5GbvE0PB90ciPmn15u0NPMDXm6uQFPO9c/XrRz/fNBP9e7vhjg+jwTXI9nhOv+/sxwnePTENc1/4xxX/9l7uK83K9vnbk0wPXkauZmbub+Y85+NsU9+82SmPw2xf2ADS8G5Lsx7obWvDglNwY5QiQv04BJDkjeUTPLiZ4NMs0wBwj7/mxy1ExzAMM411CuGecKz4YYFNyfl/v7+9c3W2PeXrMqX74XXO4tIWC5OYYijaF5lRxArrVE4GyZuZk7ncNQDKK4owxRUquMwkYQlu5ocnjnCFm62xCydQDgtVgSrCCkorZ3mtlJXpMjq8ZK5KaQcbUSJxJAtGlZxVZEmbOsALZz2RJ4gPo5y4UdnFUtgho5a4u6OMuB+jlvjbs41tXTOC8bV75d1YlEzo9toc6QSJxXxR7N+fnESWJ+KXAehGS18Xh3Iolz05BHqruXy9tFmWBTiQOYwB33UixyG4h5FDkAy8fzQixxxw8fxJ4WOdCREZzfyfGyYnDq4coxcRyadQ7tWU8DLHGEFsGqHN2xGuWhIt9rrUXOOURldmQ8B7OjDQzZgHdaOByywRLi1nm3QaM5exsEG4d/8kBauDVrzPExpnFyfGkRM84ltI3jnbmb3JlS9vKOwDg2jjR8d0K8qLbfsZGZsOtUH+e5aXlLY5q75XU+aaqJsN8WCVbjJ0K+sNu+G4lnFYnDmI2UZW1VKWd54/A0uCNkB66qrMbxh7MOFGhaxMQIHCao0ry8SSa5NAnkrdckJ8euHR4Mc+VCfCYuKis4C2cnjXOmOc5bpnyiTOPiQc7zgxBWG3Z1ElPgcBgUieo7f5Y04NlGKyq/T5GkLEqaDe3kAO5YgPJQIaTeHtL3yS7OZGZOL+dW7+35H7Ca7/NTkleJ+KVr2fy1/f3x9vb28aPlhf7kfORVvvPrWJi2n/q/JDM3czM3czM3czNnilP/+cMkTvnHHX15GOQMZOY+BfcXpu52yGEhs/AAAAAASUVORK5CYII=");
			// die();
		// break;
		
		case "api":
			header("Content-Type: application/json");
			
			if(Input::get("key") == "3maro-44ukk-ty8d1-qr20m-spo01"){
				switch(url::get(1)){
					case "login":
						if(
							!empty(Input::post("username")) && 
							!empty(Input::post("password"))
						){
							$pass = Password::get(Input::post("password"));
							
							$u = customers::getBy([
								"c_email"		=> Input::post("username"),
								"c_password"	=> $pass
							]);
							
							if(count($u) > 0){
								$u = $u[0];
								
								die(json_encode([
									"status"	=> "success",
									"message"	=> "Login success",
									"data"		=> [
										"name"		=> $u->c_name,
										"phone"		=> $u->c_phone,
										"username"	=> $u->c_email,
										"password"	=> $u->c_password,
										"ukey"		=> $u->c_ukey
									]
								]));
							}else{
								die(json_encode([
									"status"	=> "error",
									"message"	=> "Email or password is not correct."
								]));
							}
						}else{
							die(json_encode([
								"status"	=> "error",
								"message"	=> "Insufficient request parameter."
							]));
						}
					break;
					
					case "register":
						if(
							!empty(Input::post("name")) && 
							!empty(Input::post("password")) && 
							!empty(Input::post("email")) && 
							!empty(Input::post("phone"))
						){
							$pass = Password::get(Input::post("password"));
							
							$c = customers::getBy([
								"c_email"		=> Input::post("username")
							]);
							
							if(count($c) > 0){
								die(json_encode([
									"status"	=> "error",
									"message"	=> "Email has been registered before."
								]));
							}
							
							$key = F::UniqKey("customer_");
							
							customers::insertInto([
								"c_email"		=> Input::post("username"),
								"c_password"	=> $pass,
								"c_phone"		=> Input::post("phone"),
								"c_name"		=> Input::post("name"),
								"c_key"			=> $key
							]);
							
							die(json_encode([
								"status"	=> "success",
								"message"	=> "Customer registration success.",
								"data"		=> [
									"name"		=> Input::post("name"),
									"phone"		=> Input::post("phone"),
									"username"	=> Input::post("email"),
									"password"	=> $pass,
									"ukey"		=> $key
								]
							]));
						}else{
							die(json_encode([
								"status"	=> "error",
								"message"	=> "Insufficient request parameter."
							]));
						}
					break;
					
					case "forgot-password":
						if(
							!empty(Input::post("email"))
						){
							$pass = Password::get(Input::post("password"));
							
							$c = customers::getBy([
								"c_email"		=> Input::post("username")
							]);
							
							if(count($c) > 0){
								$c = $c[0];
								
								// not implemented yet
								
								die(json_encode([
									"status"	=> "error",
									"message"	=> "Forgot password is not ready."
								]));
							}else{
								die(json_encode([
									"status"	=> "error",
									"message"	=> "Email not exists."
								]));
							}
						}else{
							die(json_encode([
								"status"	=> "error",
								"message"	=> "Insufficient request parameter."
							]));
						}
					break;
					
					case "password-recovery":
						// not implemented yet
						
						die(json_encode([
							"status"	=> "error",
							"message"	=> "Forgot password is not ready."
						]));
					break;
					
					case "pages":
						$c = UserAuthentication::check();
						
						Page::Load("apis/index", ["c" => $c]);
					break;
				}
			}else{
				die(json_encode([
					"status"	=> "error",
					"message"	=> "API Key is not valid."
				]));
			}
			
			die(json_encode([
				"status"	=> "error",
				"message"	=> "API Endpoint not valid."
			]));
		break;
	}
} else {
	$mpage = url::get(0);

	if ($mpage == "webservice") {

		switch (url::get(1)) {
			case "items":
				Page::Load("webservice/items");
				break;
				
			case "clients":
				Page::Load("webservice/clients");
				break;
				
			case "purchases":
				Page::Load("webservice/purchases");
				break;
				
			case "prescriptions":
				Page::Load("webservice/prescriptions");
				break;
			
			case "customers":
				Page::Load("webservice/customers");
				break;
				
			case "records":
				Page::Load("webservice/records");
				break;

			case "customers1":
				Page::Load("webservice/customers1");
				break;

			case "sales":
				Page::Load("webservice/sales");
				break;
		}


		die();
	}
	
	switch ($mpage) {
		case "change":
			$c = clinics::getBy(["c_ukey" => url::get(1), "c_id" => function($cl){
				return "$cl IN (SELECT cu_clinic FROM clinic_user WHERE cu_user = '". Session::get("user")->u_id ."')";
			}]);
			
			if(count($c) > 0){
				$c = $c[0];
				
				Session::set("clinic", $c);
			}
			header("Location: " . PORTAL);
		break;
		
		case "profil":
			$page->setMainMenu("widgets/header.php");
			$page->title = " Profil Saya " . APP_NAME;
			$page->loadPage("pages/profil/profil");
			$page->render();
			die();
			break;

		case "tutorial":

			$page->setMainMenu("widgets/header.php");
			$page->title = " Tutorial " . APP_NAME;
			$page->loadPage("pages/tutorial/tutorial");
			$page->render();
			die();
			break;

		case "tutorials":
			if (url::get(1)) {
				$page->setMainMenu("widgets/header.php");
				/* $page->title = " Tutorial Video " . APP_NAME; */
				$page->loadPage("pages/tutorial/tt_vid");
				$page->render();
				die();
				break;
			}

		case "help":
			$page->setMainMenu("widgets/header.php");
			$page->title = " Contact Us " . APP_NAME;
			$page->loadPage("pages/help/help");
			$page->render();
			die();
			break;
		
		case "file_viewer":
			$x = DB::conn()->query("SELECT * FROM record_file WHERE (rf_fileid = ? OR rf_file = ?) AND rf_record IN (SELECT cr_id FROM customer_record WHERE cr_clinic = ?)", [
				url::get(1),
				url::get(1),
				Session::get("clinic")->c_id
			])->Results();

			if(count($x) > 0){
				$rf = $x[0];
				$cr = customer_record::getBy(["cr_id" => $rf->rf_record])[0];
				
				if(file_exists(ASSET . "records/" . $cr->cr_key . "/" . $rf->rf_file)){
					$file = file_get_contents(ASSET . "records/" . $cr->cr_key . "/" . $rf->rf_file);
					
					$fs = explode(";", $file);
					
					if(count($fs) > 1){
						$type = str_replace("data:", "", $fs[0]);
						$ext = explode("/", $type)[1];
						$name = $rf->rf_file . "." . $ext;
						
						header("Content-Type: $type");
						header('Content-Disposition: inline; filename="'. (empty($rf->rf_original_name) ? $name : $rf->rf_original_name) .'"');
						
						echo base64_decode(str_replace("data:$type;base64,", "", $file));
						die();
					}else{
						
					}					
				}else{
					header("HTTP/1.1 404 Not Found");
					die("File not found");
				}
			}else{
				header("HTTP/1.1 404 Not Found");
				die("Path is incorrect");
			}
			
			die();
			break;
	}

	// if (Session::get("user")->u_role == 3 || Session::get("user")->u_role == 4) {
		// if ($mpage == "index") {
			// $mpage = "dashboard";
		// }
	// } else {
		// if ($mpage == "index") {
			// $mpage = "dashboard-admin";
		// }
	// }
	
	if ($mpage == "index") {
		$mpage = "dashboard";
	}

	if ($mpage == "logout") {
		session_destroy();
		header("Location: " . PORTAL);
	}

	// echo $mpage . "<br />";
	// echo 1 . "<br />";

	$m = menus::getBy([
		"m_url" => $mpage,
		"m_status" => 1,
		"m_role" => function ($c) {
			return "FIND_IN_SET(" . Session::get("user")->u_role . ", $c) > 0";
		}

	]);



	if (count($m) > 0) {
		$m = $m[0];

		$sm = menus::getBy(["m_main" => $m->m_id, "m_status" => 1], ["order" => "m_sort ASC"]);

		if (count($sm) > 0) {
			$spage = url::get(1);

			if (empty($spage)) {
				$spage = $sm[0]->m_url;
			}

			$sm = menus::getBy(["m_main" => $m->m_id, "m_status" => 1, "m_url" => $spage]);

			if (count($sm) > 0) {
				$sm = $sm[0];

				if (!is_dir(VIEW . "pages/" . $m->m_route)) {
					mkdir(VIEW . "pages/" . $m->m_route, 0777, true);
				}

				$page->setMainMenu("widgets/header.php");
				$page->title = $sm->m_name . " - " . APP_NAME;
				$page->loadPage("pages/" . $m->m_route . "/" . $sm->m_route, ["m" => $sm]);
				$page->render();
			} else {
				$page->title = "Tidak Dijumpai - " . APP_NAME;
				$page->loadPage("404");
				$page->render();
			}
		} else {
			// echo "pages/" . $m->m_route;
			// die();

			if (!is_dir(dirname(VIEW . "pages/" . $m->m_route))) {
				mkdir(dirname(VIEW . "pages/" . $m->m_route), 0777, true);
			}

			$page->setMainMenu("widgets/header.php");
			$page->title = $m->m_name . " - " . APP_NAME;
			$page->loadPage("pages/" . $m->m_route, ["m" => $m]);
			$page->render();
		}
	} else {
		$page->title = "Tidak Dijumpai - " . APP_NAME;
		$page->loadPage("404");
		$page->render();
	}
}
