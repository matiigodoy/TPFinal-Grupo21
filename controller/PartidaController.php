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
        $this->model->startPartida($this->presenter);
    }
}