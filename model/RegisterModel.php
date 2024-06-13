<?php

class RegisterModel {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function register($data) {
        $query = "INSERT INTO user (fullname, birth_year, gender, latitude, longitude, email, password, username, profile_picture, auth_code, is_active) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";
        $stmt = $this->database->prepare($query);

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }

        $profile_picture = $data['profile_picture'] ?? null;
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
        $auth_code = bin2hex(random_bytes(16)); // Generate a random auth code

        $stmt->bind_param("sisddsssss",
            $data['fullname'],
            $data['birth_year'],
            $data['gender'],
            $data['latitude'],
            $data['longitude'],
            $data['email'],
            $hashed_password,
            $data['username'],
            $profile_picture,
            $auth_code
        );

        if ($stmt->execute()) {
            $stmt->close();
            return $auth_code; // Return the auth code on success
        } else {
            $stmt->close();
            return false;
        }
    }

    public function activateUser($username, $auth_code) {
        $query = "UPDATE user SET is_active = 1 WHERE username = ? AND auth_code = ?";
        $stmt = $this->database->prepare($query);

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }

        $stmt->bind_param("ss", $username, $auth_code);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }
}
