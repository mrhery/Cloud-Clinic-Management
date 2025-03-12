


<?php
// Initialize Controller
new Controller(["dashboard"]);
Controller::alert();

// Check for admin session and load the correct dashboard
if (Session::get("admin")) {
    if (Session::get("clinic")) {
        Page::Load("pages/dashboard/workshop");
    } else {
        Page::Load("pages/dashboard/admin");
    }
} else {
    Page::Load("pages/dashboard/workshop");
}

// Get URL parameter safely
$page = url::get(2) ?? "";  // Ensure the value is not null

// Handle different page requests
switch ($page) {
    case "view":
        Page::Load("pages/sales/dashboard/view");
        break;

    default:
        Page::Load("pages/dashboard/default"); // Ensure a default page exists
        break;
}
?>


