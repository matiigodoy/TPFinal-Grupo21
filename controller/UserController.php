<?php


class UserController
{
    private $userModel;
    private $presenter;
    private $qrCreator;
    private $sessionManager;

    public function __construct($userModel, $presenter, $qrCreator, $sessionManager) {
        $this->userModel = $userModel;
        $this->presenter = $presenter;
        $this->qrCreator = $qrCreator;
        $this->sessionManager = $sessionManager;
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
        $stats = $this->userModel->getUserQuestionStats($userId);
        $username = $user['username'];

        if (!$user) {

            $this->renderProfileError("El usuario con ID $userId no existe");
            return;
        }

        $userPosition = $this->getUserPosition();

        $user['position'] = $userPosition;

        $qrImagePath = $this->qrCreator->createQr($userId, $username);

        // Pasar los datos del usuario a la vista
        $data = ['user' => $user, 'qr' => $qrImagePath,
            'correct' => $stats['correct'],
            'incorrect' => $stats['incorrect']];
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

    public function getSuggestQuestionView(){

        $data=[];
        $this->presenter->render("suggestQuestion", $data);
    }

    public function addInactiveQuestion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $question = $_POST['question'];
            $category = $_POST['category'];
            $option_a = $_POST['option_a'];
            $option_b = $_POST['option_b'];
            $option_c = $_POST['option_c'];
            $option_d = $_POST['option_d'];
            $right_answer = $_POST['right_answer'];

            $this->userModel->addInactiveQuestion($question, $category, $option_a, $option_b, $option_c, $option_d, $right_answer);

            return $this->getSuggestQuestionView();
        }
    }
    public function claimQuestionWrong(){
        $data[] = $_POST['questionId'];

        this->userModel->claimQuestionWrong();
        $this->presenter->render("claimQuestionWrong", $data);
    }

    public function getProfile() {
        $userID = null;
        if (isset($_SESSION["userID"])) {
            $userID = $_SESSION["userID"];
        }

        $data = $this->userModel->getProfile($userID);

        $this->presenter->render("profile", $data);
    }

    public function exit() {
        $this->sessionManager->destroy();
        header("Location: index.php");
        exit();
    }

}