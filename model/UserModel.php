<?php

class UserModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getAllUsersOrderedByScore() {
        $query = "SELECT id, fullname, score FROM user ORDER BY score DESC";
        $stmt = $this->database->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        $stmt->close();
        return $users;
    }

    public function getUserById($id) {
        $query = "SELECT id, fullname, username, score, email FROM user WHERE id = ?";
        $stmt = $this->database->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $user = $result->fetch_assoc();

        $stmt->close();
        return $user;
    }

}