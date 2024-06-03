<?php
include_once ("Configuration.php");
include_once ("helper/SessionManager.php");

$router = Configuration::getRouter();
$sessionManager = new SessionManager();
/*
$controller = isset($_GET["controller"]) ? $_GET["controller"] : "" ;
$action = isset($_GET["action"]) ? $_GET["action"] : "" ;

$router->route($controller, $action);

// index.php?controller=tours&action=get
// tours/get

*/


$controller = $_GET["controller"] ?? "index";
$action = $_GET["action"] ?? "";
echo $controller;
// Validar si la sesión NO es válida
if (!isset($_SESSION['userID'])) {
    echo($_SESSION['userID']);
    // Si la sesión no es válida, verifica si se solicita una vista de inicio de sesión o registro
    if ($controller === 'user' && in_array($action, ['login', 'signin', 'procesarLogin', 'procesarAlta'])) {
        // Si la vista es "user/login" o "user/signin," permite el acceso
        $router->route($controller, $action);
        exit;
    }
    // Si la sesión no es válida y no se solicita "user/login" o "user/signin," redirige a la página de inicio de sesión por defecto
    $controller = "user";
    $action = "login";

} else if ($_SESSION['userID']) {//usuario logeado
    echo($_SESSION['userID']);
    $controller = "index";
    $action = "show";

}
// Si la sesión es válida, permite el acceso a la ruta deseada
$router->route($controller, $action);