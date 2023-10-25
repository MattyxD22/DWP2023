<?php

require("../models/UserModel.php");

use models\UserModel;

$userModel = new UserModel();

$action = $_GET["action"];

switch ($action) {
    case "create":
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $userModel->create($email, $username, $password);
        break;
    case "login":
        break;
}

