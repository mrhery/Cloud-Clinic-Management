<?php
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";

if (Session::get("admin")) {
	if (Session::get("clinic")) {
		Page::Load("pages/dashboard/workshop");
	} else {
		Page::Load("pages/dashboard/admin");
	}
} else {
	Page::Load("pages/dashboard/workshop");
}
