<?php
include_once ("Configuration.php");
include_once ("helper/SessionManager.php");

$router = Configuration::getRouter();
$sessionManager = new SessionManager();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; // hardcodeado
}

$controller = isset($_GET["controller"]) ? $_GET["controller"] : "" ;
$action = isset($_GET["action"]) ? $_GET["action"] : "" ;

$router->route($controller, $action);

// index.php?controller=tours&action=get
// tours/get