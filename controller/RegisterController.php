<?php

class RegisterController{

    private $registerModel;

    private $presenter;

    public function __construct($registerModel, $presenter) {
        $this->registerModel = $registerModel;
        $this->presenter = $presenter;
    }



    public function register() {
        if (isset(
            $_POST["full_name"],
            $_POST["birth_year"],
            $_POST["gender"],
            $_POST["country"],
            $_POST["city"],
            $_POST["email"],
            $_POST["password"],
            $_POST["confirm_password"],
            $_POST["username"],
            $_FILES["profile_picture"]
        )) {

            $formData = $_POST;
            $fileData = $_FILES["profile_picture"];

            if ($formData["password"] === $formData["confirm_password"]) {

                $uploadDir = __DIR__ . '/../public/';

                $uploadFile = $uploadDir . basename($fileData['name']);

                if (move_uploaded_file($fileData['tmp_name'], $uploadFile)) {

                    $hashedPassword = password_hash($formData['password'], PASSWORD_DEFAULT);

                    $userData = [
                        'full_name' => $formData['full_name'],
                        'birth_year' => $formData['birth_year'],
                        'gender' => $formData['gender'],
                        'country' => $formData['country'],
                        'city' => $formData['city'],
                        'email' => $formData['email'],
                        'password' => $hashedPassword,
                        'username' => $formData['username'],
                        'profile_picture' => $uploadFile // Ruta del archivo de imagen
                    ];

                    if ($this->registerModel->register($userData)) { 
                        $this->renderRegisterSuccess();
                    } else {
                        $this->renderRegisterError("Error al registrar el usuario.");
                    }
                } else {
                    $this->renderRegisterError("Hubo un error al subir el archivo.");
                }
            } else {
                $this->renderRegisterError("Las contraseñas no coinciden.");
            }
        } else {
            $data["message"] = "Faltó completar uno o más campos. Por favor, intente nuevamente.";
            $data["showMessage"] = true;
            $this->presenter->render("register", $data);
        }
    }

    private function renderRegisterSuccess()
    {
        $data = [];
        $this->presenter->render("login", $data);
    }

    private function renderRegisterError($message)
    {
        $data["message"] = $message;
        $data['showMessage'] = true;
        $this->presenter->render("register", $data);
    }
}