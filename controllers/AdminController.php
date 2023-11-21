<?php
namespace controllers;

require("../models/AdminModel.php");
use models\AdminModel;

$adminModel2 = new AdminModel();

if ($_POST) {
    // This checks if a request was send from $ajax/javascript. 
    $action = $_POST["action"];
} else if ($_GET) {
    // retrieve action parameter from _GET requests
    $action = $_GET["action"];
} else {
    // debug/test
    $action = "none";
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

switch ($action) {
    case "updateUser":
        if (isset($_POST["user"])) {
            $userObj = json_decode($_POST["user"], true); // Decodes the JSON string into an associative array
            var_dump($userObj);
            echo $userObj['UserID'];
            $userID = is_object($userObj) ? $userObj->UserID : $userObj['UserID']; // Extract UserID
        } else {
            var_dump($_POST);
            $userID = $_SESSION["UserID"]; // Fall back to the session UserID
        }
        
        $userBan = $_POST["userBan"];
        $userNewEmail = $_POST["userNewEmail"];
        $userNewPassword = password_hash($_POST["userNewPassword"], PASSWORD_DEFAULT);
        $result = $adminModel2->updateUser($userID, $userBan, $userNewEmail, $userNewPassword);

        // return $adminModel2->createComment($postID, $comment, $userID);
        break;
}

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