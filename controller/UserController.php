<?php

include_once('vendor/phpqrcode-master/qrlib.php');

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
            // Manejar el caso cuando el ID no está presente
            $this->renderProfileError("El ID del usuario no está presente");
            return;
        }

        $userId = $_GET['id'];
        $user = $this->userModel->getUserById($userId);
        $username = $user['username'];

        if (!$user) {
            // Manejar el caso cuando el usuario no es encontrado
            $this->renderProfileError("El usuario con ID $userId no existe");
            return;
        }

        // Obtener todos los usuarios ordenados por puntuación
        $allUsers = $this->userModel->getAllUsersOrderedByScore();

        // Buscar el índice del usuario actual en la lista ordenada
        $userPosition = array_search($userId, array_column($allUsers, 'id')) + 1;

        // Agregar la posición al array de datos del usuario
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




}