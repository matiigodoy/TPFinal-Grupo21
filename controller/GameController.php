<?php

class GameController
{
    private $gameModel;
    private $presenter;

    public function __construct($gameModel, $presenter)
    {
        $this->gameModel = $gameModel;
        $this->presenter = $presenter;
    }

    public function startGame() {

        $userId = $_SESSION['user_id']; // Ejemplo, asumiendo que guardas el ID del usuario en una sesión

        $gameId = $this->gameModel->createGame($userId);

        if ($gameId !== false) {

            $data = array(
                'gameId' => $gameId
            );
            $this->presenter->render("play", $data);
            exit();
        } else {
            // Hubo un error al iniciar la partida, muestra algún mensaje de error
            echo "Hubo un error al iniciar la partida.";
        }
    }

    public function askQuestion($gameId, $userId) {
        $question = $this->gameModel->getQuestion($gameId, $userId);
        if ($question) {
            $data = [
                'gameId' => $gameId,
                'userId' => $userId,
                'question' => $question
            ];
            $this->presenter->render("play", $data);
        } else {
            $this->renderError("No hay más preguntas disponibles.");
        }
    }

    public function answerQuestion() {
        if (isset($_POST['gameId'], $_POST['userId'], $_POST['questionId'], $_POST['selectedOption'])) {
            $gameId = $_POST['gameId'];
            $userId = $_POST['userId'];
            $questionId = $_POST['questionId'];
            $selectedOption = $_POST['selectedOption'];

            $wasRight = $this->gameModel->saveAnswer($gameId, $userId, $questionId, $selectedOption);
            $message = $wasRight ? "Respuesta correcta!" : "Respuesta incorrecta.";
            $this->askQuestion($gameId, $userId);
        } else {
            $this->renderError("Faltan datos para procesar la respuesta.");
        }
    }

    private function renderError($message) {
        $data = ['message' => $message];
        $this->presenter->render("lobby", $data);
    }
}