<?php
session_start();
include_once("Configuration.php");
include_once("helper/SessionManager.php");

$router = Configuration::getRouter();
$sessionManager = new SessionManager();

$controller = $_GET["controller"] ?? "";
$action = $_GET["action"] ?? "";

if (!isset($_SESSION['userID'])) {

    // If the user is not logged in, allow access only to login and signup actions
    if (in_array($controller, ['login', 'register']) && in_array($action, ['login', 'register', 'authenticate', 'create'])) {
        $router->route($controller, $action);
        exit;
    }

    // Redirect to login page if trying to access other actions
    $controller = "user";
    $action = "login";
}

$router->route($controller, $action);