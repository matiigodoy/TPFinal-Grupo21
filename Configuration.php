<?php
include_once("controller/LoginController.php");
include_once("controller/ProfileController.php");
include_once("controller/LobbyController.php");
include_once ("controller/RegisterController.php");
include_once ("controller/GameController.php");

include_once("model/LoginModel.php");
include_once("model/ProfileModel.php");
include_once ("model/RegisterModel.php");
include_once ("model/GameModel.php");

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

    public static function getRegisterController()
    {
        return new RegisterController(self::getRegisterModel(), self::getPresenter());
    }

    public static function getGameController(){
        return new GameController(self::getGameModel(), self::getPresenter());
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

    private static function getRegisterModel()
    {
        return new RegisterModel(self::getDatabase());
    }

    private static function getGameModel(){
        return new GameModel(self::getDatabase());
    }


    // HELPERS
    public static function getDatabase()
    {
        $config = self::getConfig();
        return new Database($config["servername"], $config["username"], $config["password"], $config["dbname"]);
    }

    private static function getConfig()
    {
        $configFile = file_exists("config/macConfig.ini") ? "config/macConfig.ini" : "config/config.ini";
        return parse_ini_file($configFile);
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