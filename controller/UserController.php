<?php


class UserController
{
    private $userModel;
    private $presenter;
    private $qrCreator;
    private $graphCreator;

    public function __construct($userModel, $presenter, $qrCreator, $graphCreator) {
        $this->userModel = $userModel;
        $this->presenter = $presenter;
        $this->qrCreator = $qrCreator;
        $this->graphCreator = $graphCreator;
    }

    public function get() {
        $allUsers = $this->userModel->getAllUsersOrderedByScore();
        $topUsers = array_slice($allUsers, 0, 10);

        $data = ['topUsers' => $topUsers];
        $this->presenter->render("ranking", $data);
    }

    public function getUserProfile() {
        if (!isset($_GET['id'])) {

            $this->renderProfileError("El ID del usuario no está presente");
            return;
        }

        $userId = $_GET['id'];
        $user = $this->userModel->getUserById($userId);
        $username = $user['username'];

        if (!$user) {

            $this->renderProfileError("El usuario con ID $userId no existe");
            return;
        }

        $userPosition = $this->getUserPosition();

        $user['position'] = $userPosition;

        $qrImagePath = $this->qrCreator->createQr($userId, $username);

        // Pasar los datos del usuario a la vista
        $data = ['user' => $user, 'qr' => $qrImagePath];
        $this->presenter->render("profileOtherUser", $data);
    }

    public function getAdminView(){
        // Obtener datos necesarios para la vista y el gráfico
        $totalUsers = $this->userModel->getTotalUsersByRole('user');
        $totalAdmins = $this->userModel->getTotalUsersByRole('admin');
        $totalEditors = $this->userModel->getTotalUsersByRole('editor');
        $totalPartidas = $this->userModel->getTotalPartidasJugadas();
        $totalQuestions = $this->userModel->getTotalQuestions();
        $totalNewUsersLastWeek = $this->userModel->getNewUsersLastWeek();
        $usersCountByCountry = $this->userModel->getUsersCountByCountry();
        $usersCountByGender = $this->userModel->getUsersCountByGender();
        $usersCountByAgeGroup = $this->userModel->getUsersCountByAgeGroup();


        // Preparar los datos y el gráfico para pasar a la vista
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

        // Renderizar la vista con los datos y el gráfico
        $this->presenter->render("admin", $data);
    }

    public function renderProfileError($message){
        $data["message"] = $message;
        $data['showMessage'] = true;
        $this->presenter->render("ranking", $data);
    }

    public function getUserPosition(){
        $userId = $_GET['id'];
        $allUsers = $this->userModel->getAllUsersOrderedByScore();
        $userPosition = array_search($userId, array_column($allUsers, 'id')) + 1;

        return $userPosition;
    }
}