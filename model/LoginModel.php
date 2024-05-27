<?php

class LoginModel {
    
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function validateLogin($username, $password) {
        $query = "SELECT id FROM user WHERE username = ? AND password = ?";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->store_result();
        $count = $stmt->num_rows;
        $stmt->close();

        return $count > 0;
    }
}