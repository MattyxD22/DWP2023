<?php

namespace controllers;
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
    $action = "none"; //$_ACTION["action"];
}



switch ($action) {
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

        //$result = $userModel->login($username, $password);

        //echo $result;



        if ($userModel->login($username, $password) != 0) {
            echo "Logged in successfully!";
            header('Location: ../views/feed.php');

            // $path = BASE_URL . "/views/feed.php";


            // $test = [];


            // foreach ($result as $key => $value) {


            //     array_push($test, (object)[
            //         "PostID" => $value["PostID"],
            //         "Title" => $value["Title"]
            //     ]);

            //     //echo $value["PostID"];
            // }


            // $view = render_view($path, array($test));



            // return $test;
        } else {
            echo "Invalid login credentials!";
        }
        break;
    case "fetchFollowers":
        
        break;

}

class UserController {
    function fetchFollowers($userID) {
        global $userModel;
        $followersCount = $userModel->fetchAmountOfFollowers($userID);
        return $followersCount;
    }

    function fetchFollowing($userID) {
        global $userModel;
        $followingCount = $userModel->fetchAmountOfFollowing($userID);
        return $followingCount;
    }
    
    function fetchPostsAmount($userID) {
        global $userModel;
        $followingCount = $userModel->fetchAmountOfPosts($userID);
        return $followingCount;
    }

    function fetchUsername($userID) {
        global $userModel;
        $username = $userModel->fetchUsernameById($userID);
        return $username;
    }

    function fetchPosts($userID) {
        global $userModel;
        $posts = $userModel->fetchPostsById($userID);
        return $posts;
    }
}
