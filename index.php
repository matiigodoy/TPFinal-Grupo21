<?php
session_start();
include_once("Configuration.php");
include_once("helper/SessionManager.php");

$router = Configuration::getRouter();
$sessionManager = new SessionManager();

$controller = $_GET["controller"] ?? "";
$action = $_GET["action"] ?? "";

// Load the auth.ini file
$authConfig = parse_ini_file("config/auth.ini", true);

// Determine the role of the user
$role = 'guest'; // Default role
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
}

// Get allowed controllers and actions for the role
$allowedControllers = $authConfig[$role]['controllers'] ?? [];
$allowedActions = $authConfig[$role]['actions'] ?? [];

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {

    if (!in_array($controller, $allowedControllers) || !in_array($action, $allowedActions)) {

        $controller = "login";
        $action = "login";
    }
} else {
    // If the user is logged in, allow access based on their role
    if (!in_array($controller, $allowedControllers) || !in_array($action, $allowedActions)) {
        // If the requested controller or action is not allowed, redirect to a default page
        $controller = "lobby";
        $action = "";
    }
}

$router->route($controller, $action);
