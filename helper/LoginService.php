<?php

class LoginService {
    
    private $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function verifyUser($formData)
    {
        $username = $formData["username"];
        $password = $formData["password"];

        if($this->model->validateLogin($username, $password)){
            return true;
        } else {
            return "Usuario y/o contraseña inválidos. Intente nuevamente";
        }
    }
}