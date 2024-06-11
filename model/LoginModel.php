<?php

class LoginModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function validateLogin($username, $password)
    {
        $query = "SELECT id, role, password FROM user WHERE username = ?";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $id = null;
        $role = null;
        $hashedPassword = null;
        $stmt->bind_result($id, $role, $hashedPassword);
        $stmt->fetch();
        $stmt->close();


        if ($id && password_verify($password, $hashedPassword)) {
            return ['id' => $id, 'role' => $role];
        } else {
            return false;
        }
    }
}
