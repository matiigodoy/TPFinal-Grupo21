<?php

class LobbyController {
    private $presenter;

    public function __construct($presenter) {
        $this->presenter = $presenter;
    }

    public function get()
    {
        $data = [];
        $this->presenter->render("lobby", $data);
    }
}