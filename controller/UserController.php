<?php


class UserController
{
    private $userModel;
    private $presenter;
    private $qrCreator;

    public function __construct($userModel, $presenter, $qrCreator) {
        $this->userModel = $userModel;
        $this->presenter = $presenter;
        $this->qrCreator = $qrCreator;
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