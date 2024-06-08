<?php

class ProfileModel {
    
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function getProfile($userID) {
        $sql = "SELECT u.fullname, u.birth_year, u.gender, u.register_date
                FROM user u
                WHERE u.id = ?";

        $query = $this->database->prepare($sql);
        $query->bind_param('i', $userID);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_assoc();
    }
}