<?php

use models\UserModel;

$userModel = new UserModel();

$action = $_GET["action"];

switch ($action) {
    case "login":
        $email = $_POST["Email"];
        $password = $_POST["Password"];
        $userModel->login($email, $password);
    
        break;

    case "logout":

        $userID = $_POST["UserID"];
        $userModel->logout($userID);
        break;

    case "updateEmail":
        $userID = $_POST["UserID"];
        $email = $_POST["Email"];
        $userModel->updateEmail($userID, $email);
    
        break;

    case "updatePassword":

        $userID = $_POST["userID"];
        $password = $_POST["Password"];
        $userModel->updatePassword($userID, $password);
        break;




}

