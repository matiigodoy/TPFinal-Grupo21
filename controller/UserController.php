<?php

class UserController
{
    private $userModel;
    private $presenter;

    public function __construct($userModel, $presenter) {
        $this->userModel = $userModel;
        $this->presenter = $presenter;
    }

    public function get() {
        $allUsers = $this->userModel->getAllUsersOrderedByScore();
        $topUsers = array_slice($allUsers, 0, 10);

        $data = ['topUsers' => $topUsers];
        $this->presenter->render("ranking", $data);
    }


}