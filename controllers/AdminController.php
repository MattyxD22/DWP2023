<?php
namespace controllers;

require("../models/AdminModel.php");
use models\AdminModel;

class AdminController {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new AdminModel();
    }

    function fetchUsers($userID) {
        $users = $this->adminModel->getUser($userID);
        return $users;
    }
    
}