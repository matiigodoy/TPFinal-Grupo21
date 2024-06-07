<?php

class LoginModel {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function validateLogin($username, $password) {
        $query = "SELECT id, role FROM user WHERE username = ? AND password = ?";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $role = null;
        $id = null;
        $stmt->bind_result($id, $role);
        $stmt->fetch();
        $stmt->close();

        if (!empty($id)) {
            return ['id' => $id, 'role' => $role];
        } else {
            return false;
        }
    }
}
