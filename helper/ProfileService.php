<?php

class ProfileService {
    
    private $profileModel;

    public function __construct($profileModel)
    {
        $this->profileModel = $profileModel;
    }

    public function getProfile($userID)
    {
        return $this->profileModel->getProfile($userID);
    }
}