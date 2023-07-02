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
	}
} else {
	$mpage = url::get(0);

	if ($mpage == "webservice") {

		// switch (url::get(1)) {
			// case "permohonan":
				// Page::Load("pages/permohonan/webservice");
				// break;

			// case "dashboards":
				// Page::Load("pages/dashboards/webservice");
				// break;

			// case "dashboard":
				// Page::Load("pages/dashboards/webservice");
				// break;

			// case "cagaran":
				// Page::Load("pages/permohonan/cagaran/webservice");
				// break;

			// case "pindah-milik":
				// Page::Load("pages/permohonan/pindah_milik/webservice");
				// break;
		// }


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
