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
        $userModel->create($username, $email, $password);
        break;
    case "login":
        $username = $_POST["username"];
        $password = $_POST["password"];
        if ($userModel->login($username, $password)) {
            echo "Logged in successfully!";
        } else {
            echo "Invalid login credentials!";
        }
        break;
}

