<?php

class AdminModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getTotalUsers() {
        $query = "SELECT COUNT(*) as total FROM user";
        $stmt = $this->database->prepare($query);

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();
        $totalUsers = $row['total'];

        $stmt->close();
        return $totalUsers;
    }

    public function getTotalUsersByRole($role) {
        $query = "SELECT COUNT(*) as total FROM user WHERE role = ?";
        $stmt = $this->database->prepare($query);

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }

        $stmt->bind_param("s", $role);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();
        $totalUsers = $row['total'];

        $stmt->close();
        return $totalUsers;
    }

    public function getUserRoleById($userID) {
        $query = "SELECT role FROM user WHERE id = ?";
        $stmt = $this->database->prepare($query);

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }

        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $stmt->close();
            return null; // No se encontró el usuario
        }

        $row = $result->fetch_assoc();
        $role = $row['role'];

        $stmt->close();
        return $role;
    }

    public function getNewUsersLastWeek() {
        $query = "
        SELECT DATE(register_date) as date, COUNT(*) as count 
        FROM user 
        WHERE register_date >= DATE_SUB(NOW(), INTERVAL 1 WEEK)
        GROUP BY DATE(register_date)
        ORDER BY DATE(register_date) ASC";

        $stmt = $this->database->prepare($query);

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $newUsersLastWeek = [];

        while ($row = $result->fetch_assoc()) {
            $newUsersLastWeek[] = [
                'date' => $row['date'],
                'count' => $row['count']
            ];
        }

        $stmt->close();
        return $newUsersLastWeek;
    }

    public function getUsersCountByCountry()
    {
        $query = "SELECT country, COUNT(*) as user_count FROM user GROUP BY country";
        $stmt = $this->database->prepare($query);

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $usersCountByCountry = [];
        while ($row = $result->fetch_assoc()) {
            $usersCountByCountry[] = $row;
        }

        $stmt->close();
        return $usersCountByCountry;
    }

    public function getUsersCountByGender() {
        $query = "SELECT gender, COUNT(*) as user_count FROM user GROUP BY gender";
        $stmt = $this->database->prepare($query);

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $usersCountByGender = [];
        while ($row = $result->fetch_assoc()) {
            $usersCountByGender[] = $row;
        }

        $stmt->close();
        return $usersCountByGender;
    }

    public function getUsersCountByAgeGroup() {
        $currentYear = date('Y');

        $ageGroups = [
            ['min_age' => 0, 'max_age' => 17, 'label' => 'Menores de 18 años'],
            ['min_age' => 18, 'max_age' => 24, 'label' => '18-24 años'],
            ['min_age' => 25, 'max_age' => 34, 'label' => '25-34 años'],
            ['min_age' => 35, 'max_age' => 44, 'label' => '35-44 años'],
            ['min_age' => 45, 'max_age' => 54, 'label' => '45-54 años'],
            ['min_age' => 55, 'max_age' => 64, 'label' => '55-64 años'],
            ['min_age' => 65, 'max_age' => 100, 'label' => '65 años o más'],
        ];

        $usersCountByAgeGroup = [];

        foreach ($ageGroups as $group) {
            $query = "SELECT COUNT(*) as user_count FROM user WHERE (YEAR(CURDATE()) - birth_year) BETWEEN ? AND ?";
            $stmt = $this->database->prepare($query);

            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($this->database->error));
            }

            $stmt->bind_param("ii", $group['min_age'], $group['max_age']);
            $stmt->execute();
            $result = $stmt->get_result();

            $count = $result->fetch_assoc()['user_count'];

            $usersCountByAgeGroup[] = [
                'age_group' => $group['label'],
                'user_count' => $count
            ];

            $stmt->close();
        }

        return $usersCountByAgeGroup;
    }

    public function getTotalPartidasJugadas() {
        $query = "SELECT COUNT(*) as total FROM partida";
        $stmt = $this->database->prepare($query);

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();
        $totalPartidas = $row['total'];

        $stmt->close();
        return $totalPartidas;
    }


    public function getTotalQuestions() {
        $query = "SELECT COUNT(*) as total FROM question";
        $stmt = $this->database->prepare($query);

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();
        $totalQuestions = $row['total'];

        $stmt->close();
        return $totalQuestions;
    }

    public function getQuestionsByCreationStatus() {
        $query = "SELECT 
                SUM(CASE WHEN isCreada = 1 AND active = 1 THEN 1 ELSE 0 END) as createdQuestions,
                SUM(CASE WHEN isCreada = 0 AND active = 1 THEN 1 ELSE 0 END) as notCreatedQuestions
              FROM question";
        $stmt = $this->database->prepare($query);

        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($this->database->error));
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();
        $questionsByCreationStatus = [
            'createdQuestions' => $row['createdQuestions'],
            'notCreatedQuestions' => $row['notCreatedQuestions']
        ];

        $stmt->close();
        return $questionsByCreationStatus;
    }

}