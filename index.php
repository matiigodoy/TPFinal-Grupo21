<?php
session_start();
include_once("Configuration.php");
include_once("helper/SessionManager.php");

$router = Configuration::getRouter();
$sessionManager = new SessionManager();

$controller = $_GET["controller"] ?? "";
$action = $_GET["action"] ?? "";

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {

    // If the user is not logged in, allow access only to login and signup actions
    if (in_array($controller, ['login', 'register']) && in_array($action, ['login', 'register', 'authenticate', 'create'])) {
        $router->route($controller, $action);
        exit;
    }

    // Redirect to login page if trying to access other actions
    $controller = "user";
    $action = "login";
} else if ($_SESSION['role'] === 'admin') {
    // let's leave this log for now
    echo "<script>console.log('role: ".$_SESSION['role']."');</script>";
    // If the user is logged in as admin, allow access to all actions except login and register
    if (in_array($controller, ['login', 'register', ""]) && $action !== "exit") {
        $controller = "lobby";
        $action = "";
    }
} else if ($_SESSION['role'] === 'user') {
    // let's leave this log for now
    echo "<script>console.log('role: ".$_SESSION['role']."');</script>";
    // If the user is logged in as user, allow access to all actions except login and register
    if (in_array($controller, ['login', 'register', ""]) && $action !== "exit") {
        $controller = "lobby";
        $action = "";
    }
}
// log user id on the console // lets leave this log for now
echo "<script>console.log('user id: ".$_SESSION['userID']."');</script>";

$router->route($controller, $action);