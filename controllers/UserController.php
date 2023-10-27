<?php

require("../models/UserModel.php");

use models\UserModel;

$userModel = new UserModel();

if ($_POST) {
    // This checks if a request was send from $ajax/javascript. 
    $action = $_POST["action"];
} else if ($_GET) {
    // retrieve action parameter from _GET requests
    $action = $_GET["action"];
} else {
    // debug/test
    $action = $_ACTION["action"];
}



switch ($action) {
    case "login":
        $email = $_POST["username"];
        $password = $_POST["password"];
        $userModel->login($email, $password);

        break;

    case "logout":

        $userID = $_POST["userID"];
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
