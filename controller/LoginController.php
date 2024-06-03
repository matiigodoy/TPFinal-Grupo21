<?php

class LoginController {
    private $loginService;
    private $sessionManager;
    private $presenter;

    public function __construct($loginService, $sessionManager, $presenter) {
        $this->loginService = $loginService;
        $this->sessionManager = $sessionManager;
        $this->presenter = $presenter;
    }

    public function get()
    {
        if (isset($_SESSION["userID"])) {
            // If the user is logged in, redirect them to a different page, e.g., home or dashboard
            Redirect::to('/lobby'); // Adjust the route as needed
        } else {
            $data["isLogged"] = false;
            $this->presenter->render("login", $data);
        }
    }

    public function authenticate() {
        if(isset($_POST["username"], $_POST["password"])) {
            $formData = $_POST;
            $result = $this->loginService->verifyUser($formData);

            if($result === true) {
                $this->sessionManager->setUser("1");
                $this->renderLoginSuccess();
            } else {
                $this->renderLoginError($result);
            }
        } else {
            $data["message"] = "Faltó completar uno o más campos. Por favor, intente nuevamente.";
            $data["showMessage"] = true;
            $this->presenter->render("login", $data);
        }
    }

    private function renderLoginSuccess()
    {
        $data = [];
        $this->presenter->render("lobby", $data);
    }

    private function renderLoginError($message)
    {
        $data["message"] = $message;
        $data['showMessage'] = true;
        $this->presenter->render("login", $data);
    }

    public function exit() {
        $this->sessionManager->destroy();
        header("Location: index.php");
    }
}