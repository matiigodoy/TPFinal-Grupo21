<?php

class UserController
{
    private $userModel;
    private $presenter;

    public function __construct($userModel, $presenter) {
        $this->userModel = $userModel;
        $this->presenter = $presenter;
    }

    public function get() {
        $allUsers = $this->userModel->getAllUsersOrderedByScore();
        $topUsers = array_slice($allUsers, 0, 10);

        $data = ['topUsers' => $topUsers];
        $this->presenter->render("ranking", $data);
    }

    public function getUserProfile() {
        if (!isset($_GET['id'])) {
            // Manejar el caso cuando el ID no está presente
            $this->renderProfileError("El ID del usuario no está presente");
            return;
        }

        $userId = $_GET['id'];
        $user = $this->userModel->getUserById($userId);

        if (!$user) {
            // Manejar el caso cuando el usuario no es encontrado
            $this->renderProfileError("El usuario con ID $userId no existe");
            return;
        }

        $allUsers = $this->userModel->getAllUsersOrderedByScore();

        $userPosition = array_search($userId, array_column($allUsers, 'id')) + 1;

        $user['position'] = $userPosition;

        $data = ['user' => $user];
        $this->presenter->render("profileOtherUser", $data);
    }

    public function renderProfileError($message){
        $data["message"] = $message;
        $data['showMessage'] = true;
        $this->presenter->render("ranking", $data);
    }




}