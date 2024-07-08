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
        $partidaData = $this->model->startPartida();
        //$partidaId = $_SESSION['partidaId'];
        //$this->model->saveStartTime($partidaId);
        $partidaFirstKey = array_key_first($partidaData);
        if($this->model->checkWin($partidaData))$this->presenter->render("win", $partidaData);;
        $_SESSION['question_start'] = microtime(true);
        $partidaFirstKey == "category" ? 
        $this->presenter->render($partidaFirstKey, $partidaData) : 
        $this->presenter->render("error", $partidaData);
    }

    public function checkAnswer(){
        $responseTime = microtime(true);
        $difference = $responseTime - $_SESSION['question_start'];
        if($difference > 15){
            $this->presenter->render("error", ["fail" => "¡Tiempo acabado!"]);
            unset($_SESSION['questionId']);
            return;
        } 
        // $partidaId = $_SESSION['partidaId'];
        // if ($this->model->isTimeout($partidaId)) {
        //     $this->presenter->render("error", ["fail" => "¡Tiempo acabado!"]);
        //     unset($_SESSION['questionId']);
        //     return;
        // }
        // $this->model->saveStartTime($userId);
        $checkAnswerData = $this->model->checkAnswer($this->presenter);
        $checkanswerFirstKey = array_key_first($checkAnswerData);
        //si es 'category' entonces pasó por la respuesta fue correcta, ya que es
        //un valor que llevamos para la view de successfulAnswer
        $checkanswerFirstKey == "category" ? 
        $this->presenter->render("successfulAnswer", $checkAnswerData) :
        $this->presenter->render("failedAnswer", $checkAnswerData);
    }
    
    public function continuePartida(){
        $_SESSION['question_start'] = microtime(true);
        //$partidaId = $_SESSION['partidaId'];
        //$this->model->saveStartTime($partidaId);
        $contPartidaData = $this->model->continuePartida();
        $contPartidaDataFirstKey = array_key_first($contPartidaData);
        if($this->model->checkWin($contPartidaData)) $this->presenter->render($contPartidaDataFirstKey, $contPartidaData);
        $contPartidaDataFirstKey == "category" ? 
        $this->presenter->render($contPartidaDataFirstKey, $contPartidaData) : 
        $this->presenter->render("error", $contPartidaData);
    }
    

}