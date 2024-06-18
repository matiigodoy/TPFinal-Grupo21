<?php
include_once("controller/LoginController.php");
include_once("controller/ProfileController.php");
include_once("controller/LobbyController.php");
include_once ("controller/RegisterController.php");
include_once ("controller/PartidaController.php");
include_once ("controller/UserController.php");
include_once ("controller/EditorController.php");
include_once ("controller/AdminController.php");


include_once("model/LoginModel.php");
include_once("model/ProfileModel.php");
include_once ("model/RegisterModel.php");
include_once("model/PartidaModel.php");
include_once ("model/UserModel.php");
include_once ("model/EditorModel.php");
include_once ("model/AdminModel.php");


include_once ("helper/ProfileService.php");

include_once ("helper/Database.php");
include_once ("helper/Router.php");

include_once ("helper/Presenter.php");
include_once ("helper/MustachePresenter.php");
include_once ("helper/SessionManager.php");
include_once ("helper/Redirect.php");
include_once ("helper/QrCreator.php");
include_once ("helper/GraphCreator.php");


include_once('vendor/mustache/src/Mustache/Autoloader.php');

class Configuration
{

    // CONTROLLERS
    public static function getLoginController()
    {
        return new LoginController(self::getLoginModel(),self::getSessionManager(),self::getPresenter());
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

    public static function getPartidaController(){
        return new PartidaController(self::getPartidaModel(), self::getPresenter());
    }
  
    public static function getUserController(){
        return new UserController(self::getUserModel(), self::getPresenter(), self::getQrCreator());
    }

    public static function getEditorController(){
        return new EditorController(self::getEditorModel(), self::getPresenter());
    }

    public static function getAdminController(){
        return new AdminController(self::getAdminModel(), self::getPresenter());
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
    private static function getUserModel(){
        return new UserModel(self::getDatabase());
    }

    private static function getPartidaModel(){
        return new PartidaModel(self::getDatabase());
    }

    private static function getEditorModel(){
        return new EditorModel(self::getDatabase());
    }

    private static function getAdminModel(){
        return new AdminModel(self::getDatabase());
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

    public static function getProfileService()
    {
        return new ProfileService(self::getProfileModel());
    }

    public static function getSessionManager()
    {
        return new SessionManager();
    }

    public static function getQrCreator(){
        return new QrCreator();
    }

    public static function getGraphCreator(){
        return new GraphCreator();
    }


}