<?php

session_start();

// Define the root path constant for the app
define("ABSPATH", true);

require "../app/core/init.php";

// Get the controller name from the URL, defaulting to "home"
$url = $_GET['payroll'] ?? "home";  // Default to "home" if no 'payroll' is provided
$controller = strtolower($url);     // Convert the controller name to lowercase

// If the controller exists, require the controller file
if (file_exists("../app/controller/" . $controller . ".php")) {
    require "../app/controller/" . $controller . ".php";
} else {
    echo "Controller Not Found!";
}

// Now handle the logout action explicitly
if ($url === 'logout') {
    // Ensure you include the logout logic and then exit
    require "../app/controller/logout.php";  // Adjust the path as needed
    exit;
}
