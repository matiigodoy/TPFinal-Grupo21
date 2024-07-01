<?php

class RegisterController {

    private $registerModel;
    private $presenter;

    public function __construct($registerModel, $presenter) {
        $this->registerModel = $registerModel;
        $this->presenter = $presenter;
    }

    public function register() {
        $data = ["showMessage" => false]; // Default, no message to show

        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Check if form has been submitted
            if (isset(
                $_POST["fullname"],
                $_POST["birth_year"],
                $_POST["gender"],
                $_POST["country"],
                $_POST["latitude"],
                $_POST["longitude"],
                $_POST["email"],
                $_POST["password"],
                $_POST["confirm_password"],
                $_POST["username"]
            )) {

                $formData = $_POST;
                $fileData = $_FILES["profile_picture"];
                $data = $formData; // Save form data to return it to the view in case of an error

                if ($formData["password"] === $formData["confirm_password"]) {

                    $uploadFile = null;
                    if ($fileData && $fileData['tmp_name']) {
                        $uploadDir = __DIR__ . '/../public/';
                        $uploadFile = $uploadDir . basename($fileData['name']);
                        if (!move_uploaded_file($fileData['tmp_name'], $uploadFile)) {
                            $this->renderRegisterError("Hubo un error al subir el archivo.", $data);
                            return;
                        }
                    }

                    $userData = [
                        'fullname' => $formData['fullname'],
                        'birth_year' => $formData['birth_year'],
                        'gender' => $formData['gender'],
                        'country' => $formData['country'],
                        'latitude' => $formData['latitude'],
                        'longitude' => $formData['longitude'],
                        'email' => $formData['email'],
                        'password' => $formData['password'],
                        'username' => $formData['username'],
                        'profile_picture' => $uploadFile // Ruta del archivo de imagen
                    ];

                    $authCode = $this->registerModel->register($userData);
                    if ($authCode) {
                        $this->renderRegisterSuccess($formData['username'], $authCode);
                    } else {
                        $this->renderRegisterError("Error al registrar el usuario.", $data);
                    }
                } else {
                    $this->renderRegisterError("Las contraseñas no coinciden.", $data);
                }
            } else {
                $data["message"] = "Faltó completar uno o más campos. Por favor, intente nuevamente.";
                $data["showMessage"] = true;
                $this->presenter->render("register", $data);
            }
        } else {
            // Render the registration form with no error message initially
            $this->presenter->render("register", $data);
        }
    }

    private function renderRegisterSuccess($username, $authCode) {
        $data = [
            'message' => 'Registro exitoso. Por favor, Haga click en el siguiente boton para activar su cuenta.',
            'activationLink' => "/register/validateUser?username={$username}&auth_code={$authCode}"
        ];
        $this->presenter->render("register_success", $data);
    }

    public function validateUser()
    {
        $username = $_GET['username'] ?? '';
        $auth_code = $_GET['auth_code'] ?? '';
        $data= [];

        if ($username && $auth_code) {

            if ($this->registerModel->activateUser($username, $auth_code)) {
                $data["username"] = $username;
                $this->presenter->render("login", $data);
            } else {
                $this->renderRegisterError("Error al activar la cuenta. Por favor, intente nuevamente.", $data);
            }
        } else {
            $this->renderRegisterError("Error al activar la cuenta. Por favor, intente nuevamente.", $data);
        }
    }

    private function renderRegisterError($message, $data) {
        $data["message"] = $message;
        $data['showMessage'] = true;
        $this->presenter->render("register", $data);
    }
}
