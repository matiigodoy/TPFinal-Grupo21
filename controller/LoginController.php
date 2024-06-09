<?php

class LoginController {
    private $loginModel;
    private $sessionManager;
    private $presenter;

    public function __construct($loginModel, $sessionManager, $presenter) {
        $this->loginModel = $loginModel;
        $this->sessionManager = $sessionManager;
        $this->presenter = $presenter;
    }

    public function get() {
        $data["isLogged"] = false;
        $this->presenter->render("login", $data);
    }

    public function authenticate() {
        if (isset($_POST["username"], $_POST["password"])) {
            $formData = $_POST;
            $result = $this->verifyUser($formData);

            if ($result !== false) {
                $this->sessionManager->setUser($result['id'], $result['role'], $result['username']);
                $this->renderLoginSuccess();
            } else {
                $this->renderLoginError("Usuario y/o contraseña inválidos. Intente nuevamente");
            }
        } else {
            $data["message"] = "Faltó completar uno o más campos. Por favor, intente nuevamente.";
            $data["showMessage"] = true;
            $this->presenter->render("login", $data);
        }
    }

    public function verifyUser($formData) {
        $username = $formData["username"];
        $password = $formData["password"];

        $user = $this->loginModel->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    }

    private function renderLoginSuccess() {
        $data = [];
        $this->presenter->render("lobby", $data);
    }

    private function renderLoginError($message) {
        $data["message"] = $message;
        $data['showMessage'] = true;
        $this->presenter->render("login", $data);
    }

    public function exit() {
        $this->sessionManager->destroy();
        header("Location: index.php");
        exit();
    }
}
