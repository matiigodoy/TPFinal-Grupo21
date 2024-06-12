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
        $query = "SELECT id, role, password, is_active FROM user WHERE username = ?";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $id = null;
        $role = null;
        $is_active = null;
        $hashedPassword = null;
        $stmt->bind_result($id, $role, $hashedPassword, $is_active);
        $stmt->fetch();
        $stmt->close();

        if ($is_active === 1 && $id && password_verify($password, $hashedPassword)) {
            return ['id' => $id, 'role' => $role];
        } else {
            return false;
        }
    }
}
