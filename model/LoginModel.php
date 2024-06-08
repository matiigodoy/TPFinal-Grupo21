<?php

class LoginModel {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function getUserByUsername($username) {
        $query = "SELECT * FROM user WHERE username = ?";
        $stmt = $this->database->prepare($query);

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();

        return $user;
    }
}
