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
        $partidaFirstKey = array_key_first($partidaData);

        $partidaFirstKey == "category" ? 
        $this->presenter->render($partidaFirstKey, $partidaData) : 
        $this->presenter->render("error", $partidaData);
    }

    public function checkAnswer(){
        $checkAnswerData = $this->model->checkAnswer($this->presenter);
        $checkanswerFirstKey = array_key_first($checkAnswerData);
        //si es 'category' entonces pasó por la respuesta fue correcta, ya que es
        //un valor que llevamos para la view de successfulAnswer
        $checkanswerFirstKey == "category" ? 
        $this->presenter->render("successfulAnswer", $checkAnswerData) :
        $this->presenter->render("failedAnswer", $checkAnswerData);
    }
    
    public function continuePartida(){
        $contPartidaData = $this->model->continuePartida();
        $contPartidaDataFirstKey = array_key_first($contPartidaData);

        $contPartidaDataFirstKey == "category" ? 
        $this->presenter->render($contPartidaDataFirstKey, $contPartidaData) : 
        $this->presenter->render("error", $contPartidaData);
    }
    public function timeout(){
        $this->presenter->render("failedAnswer");
    }
}