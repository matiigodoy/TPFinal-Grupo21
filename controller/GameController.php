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

        $userId = 1; //hardcodeado

        $gameId = 5; //hardcodeado

        if ($gameId !== false) {

        $this->askQuestion($gameId, $userId);
            exit();
        } else {

            echo "Hubo un error al iniciar la partida.";
        }
    }

    public function askQuestion($gameId, $userId) {
        $question = $this->gameModel->getQuestion($userId, $gameId); //hardcodeado
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

    public function answerQuestion()
    {
        if (isset($_POST['gameId'], $_POST['userId'], $_POST['questionId'], $_POST['selectedOption'])) {
            $gameId = 5;
            $userId = 1;
            $questionId = $_POST['questionId'];
            $selectedOption = $_POST['selectedOption'];

            $wasRight = $this->gameModel->saveAnswer($gameId, $userId, $questionId, $selectedOption);

            if ($wasRight) {
                $this->askQuestion($gameId, $userId);
            } else {
                $message = "Respuesta incorrecta.";
                $this->renderError($message);
            }
        } else {
            $this->renderError("Faltan datos para procesar la respuesta.");
        }
    }

    private function renderError($message) {
        $data = ['message' => $message];
        $this->presenter->render("lobby", $data);
    }
}