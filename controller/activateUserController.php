<?php

class ActivateUserController
{
    private $userModel;
    private $presenter;

    public function __construct($userModel, $presenter) {
        $this->userModel = $userModel;
        $this->presenter = $presenter;
    }

    public function show() {


        $data = ['message' => 'hi'];
        $data = ['activationLink' => 'hi2'];
        $this->presenter->render("register_success", $data);
    }


}