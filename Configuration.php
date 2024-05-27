<?php
include_once("controller/LoginController.php");
include_once("controller/ProfileController.php");
include_once("controller/LobbyController.php");

include_once("model/LoginModel.php");
include_once("model/ProfileModel.php");

include_once ("helper/LoginService.php");
include_once ("helper/ProfileService.php");

include_once ("helper/Database.php");
include_once ("helper/Router.php");

include_once ("helper/Presenter.php");
include_once ("helper/MustachePresenter.php");
include_once ("helper/SessionManager.php");

include_once('vendor/mustache/src/Mustache/Autoloader.php');

class Configuration
{

    // CONTROLLERS
    public static function getLoginController()
    {
        return new LoginController(self::getLoginService(),self::getSessionManager(),self::getPresenter());
    }

    public static function getProfileController()
    {
        return new ProfileController(self::getProfileService(),self::getPresenter());
    }

    public static function getLobbyController()
    {
        return new LobbyController(self::getPresenter());
    }

    // MODELS
    private static function getLoginModel()
    {
        return new LoginModel(self::getDatabase());
    }

    private static function getProfileModel()
    {
        return new ProfileModel(self::getDatabase());
    }

    // HELPERS
    public static function getDatabase()
    {
        $config = self::getConfig();
        return new Database($config["servername"], $config["username"], $config["password"], $config["dbname"]);
    }

    private static function getConfig()
    {
        return parse_ini_file("config/config.ini");
    }


    public static function getRouter()
    {
        return new Router("getLoginController", "get");
    }

    private static function getPresenter()
    {
        return new MustachePresenter("view/template");
    }

    public static function getLoginService()
    {
        return new LoginService(self::getLoginModel());
    }

    public static function getProfileService()
    {
        return new ProfileService(self::getProfileModel());
    }

    public static function getSessionManager()
    {
        return new SessionManager();
    }
}