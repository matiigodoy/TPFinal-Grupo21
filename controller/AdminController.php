<?php

class AdminController
{
    private $adminModel;
    private $presenter;

    public function __construct($adminModel, $presenter) {
        $this->adminModel = $adminModel;
        $this->presenter = $presenter;
    }
    public function getAdminView(){
        // Obtener datos necesarios para la vista y el gráfico
        $totalUsers = $this->adminModel->getTotalUsersByRole('user');
        $totalAdmins = $this->adminModel->getTotalUsersByRole('admin');
        $totalEditors = $this->adminModel->getTotalUsersByRole('editor');
        $totalPartidas = $this->adminModel->getTotalPartidasJugadas();
        $totalQuestions = $this->adminModel->getTotalQuestions();
        $totalNewUsersLastWeek = $this->adminModel->getNewUsersLastWeek();
        $usersCountByCountry = $this->adminModel->getUsersCountByCountry();
        $usersCountByGender = $this->adminModel->getUsersCountByGender();
        $usersCountByAgeGroup = $this->adminModel->getUsersCountByAgeGroup();

        $data['user'] = [
            'totalUsers' => $totalUsers,
            'totalAdmins' => $totalAdmins,
            'totalEditors' => $totalEditors,
            'totalPartidas' => $totalPartidas,
            'totalQuestions' => $totalQuestions,
            'totalNewUsersLastWeek' => $totalNewUsersLastWeek,
            'usersCountByCountry' => $usersCountByCountry,
            'usersCountByGender' => $usersCountByGender,
            'usersCountByAgeGroup' => $usersCountByAgeGroup,
        ];

        $this->presenter->render("admin", $data);
    }



}