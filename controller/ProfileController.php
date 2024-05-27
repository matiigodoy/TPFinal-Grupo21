<?php

class ProfileController {
    private $profileService;
    private $presenter;

    public function __construct($profileService, $presenter) {
        $this->profileService = $profileService;
        $this->presenter = $presenter;
    }

    public function get() {
        $userID = null;
        if (isset($_SESSION["userID"])) {
            $userID = $_SESSION["userID"];
        }

        $data = $this->profileService->getProfile($userID);
    
        $this->presenter->render("profile", $data);
    }
}