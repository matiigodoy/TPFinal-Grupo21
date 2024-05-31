<?php

class RegisterModel
{

    private $database;

    public function __construct($database){
        $this->database = $database;
    }

    public function register($data) {
        $query = "INSERT INTO user (full_name, birth_year, gender, country, city, email, password, username, profile_picture) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->database->prepare($query);

        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt->bind_param("sisssssss",
            $data['full_name'],
            $data['birth_year'],
            $data['gender'],
            $data['country'],
            $data['city'],
            $data['email'],
            $hashed_password,
            $data['username'],
            $data['profile_picture']
        );

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            $stmt->close();
            return false;
        }
    }

}