<?php

class RegisterModel
{
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function register($data) {
        $query = "INSERT INTO user (fullname, birth_year, gender, country, city, email, password, username, profile_picture) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->database->prepare($query);

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }

        $profile_picture = $data['profile_picture'] ?? null;
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt->bind_param("sisssssss",
            $data['fullname'],
            $data['birth_year'],
            $data['gender'],
            $data['country'],
            $data['city'],
            $data['email'],
            $hashed_password,
            $data['username'],
            $profile_picture
        );

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            die('Execute failed: ' . htmlspecialchars($stmt->error));
        }
    }
}
