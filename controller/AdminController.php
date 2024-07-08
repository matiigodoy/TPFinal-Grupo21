<?php

class AdminController
{
    private $adminModel;
    private $presenter;

    public function __construct($adminModel, $presenter) {
        $this->adminModel = $adminModel;
        $this->presenter = $presenter;
    }
    public function get(){
        // Obtener datos necesarios para la vista y el gráfico
        $totalUsers = $this->adminModel->getTotalUsers();
        $totalRolUsers = $this->adminModel->getTotalUsersByRole('user');
        $totalAdmins = $this->adminModel->getTotalUsersByRole('admin');
        $totalEditors = $this->adminModel->getTotalUsersByRole('editor');
        $totalPartidas = $this->adminModel->getTotalPartidasJugadas();
        $totalQuestions = $this->adminModel->getTotalQuestions();
        $questionsByCreationStatus = $this->adminModel->getQuestionsByCreationStatus();
        $totalNewUsersLastWeek = $this->adminModel->getNewUsersLastWeek();
        $usersCountByCountry = $this->adminModel->getUsersCountByCountry();
        $usersCountByGender = $this->adminModel->getUsersCountByGender();
        $usersCountByAgeGroup = $this->adminModel->getUsersCountByAgeGroup();

        $data = [
            'totalUsers' => $totalUsers,
            'totalRolUsers' => $totalRolUsers,
            'totalAdmins' => $totalAdmins,
            'totalEditors' => $totalEditors,
            'totalPartidas' => $totalPartidas,
            'totalQuestions' => $totalQuestions,
            'questionsByCreationStatus' => $questionsByCreationStatus,
            'totalNewUsersLastWeek' => $totalNewUsersLastWeek,
            'usersCountByCountry' => $usersCountByCountry,
            'usersCountByGender' => $usersCountByGender,
            'usersCountByAgeGroup' => $usersCountByAgeGroup,
        ];

        $this->presenter->render("admin", $data);
    }



}