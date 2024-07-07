<?php

class PartidaController {
    private $model;
    private $presenter;

    public function __construct($model, $presenter) {
        $this->model = $model;
        $this->presenter = $presenter;
    }

    public function get()
    {
        $data = [];
        $this->model->renderPartidaView($this->presenter);
    }

    public function play(){
        $data = [];
        $this->model->renderPartidaView($this->presenter);
    }

    public function start(){
        $userId = $_SESSION['userID'];
        $this->model->saveStartTime($userId);
        $partidaData = $this->model->startPartida();
        $partidaFirstKey = array_key_first($partidaData);
        if($this->model->checkWin($partidaData))$this->presenter->render("win", $partidaData);;

        $partidaFirstKey == "category" ? 
        $this->presenter->render($partidaFirstKey, $partidaData) : 
        $this->presenter->render("error", $partidaData);
    }

    public function checkAnswer(){
        $userId = $_SESSION['userID'];
        if ($this->model->isTimeout($userId)) {
            $this->presenter->render("error", ["fail" => "¡Tiempo acabado!"]);
            unset($_SESSION['questionId']);
            return;
        }
        $this->model->saveStartTime($userId);
        $checkAnswerData = $this->model->checkAnswer($this->presenter);
        $checkanswerFirstKey = array_key_first($checkAnswerData);
        //si es 'category' entonces pasó por la respuesta fue correcta, ya que es
        //un valor que llevamos para la view de successfulAnswer
        $checkanswerFirstKey == "category" ? 
        $this->presenter->render("successfulAnswer", $checkAnswerData) :
        $this->presenter->render("failedAnswer", $checkAnswerData);
    }
    
    public function continuePartida(){
        $userId = $_SESSION['userID'];
        $this->model->saveStartTime($userId);
        $contPartidaData = $this->model->continuePartida();
        $contPartidaDataFirstKey = array_key_first($contPartidaData);
        if($this->model->checkWin($contPartidaData)) $this->presenter->render($contPartidaDataFirstKey, $contPartidaData);
        $contPartidaDataFirstKey == "category" ? 
        $this->presenter->render($contPartidaDataFirstKey, $contPartidaData) : 
        $this->presenter->render("error", $contPartidaData);
    }
    

}