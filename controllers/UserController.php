<?php

namespace controllers;

require("../models/UserModel.php");

use models\UserModel;

$userModel = UserModel::getUserModel();

if ($_POST) {
    // This checks if a request was send from $ajax/javascript. 
    $action = $_POST["action"];
} else if ($_GET && isset($_GET["action"])) {
    // retrieve action parameter from _GET requests
    $action = $_GET["action"];
} else {
    // debug/test
    $action = "none"; //$_ACTION["action"];
}



switch ($action) {

        // case "follow":

        //     $followUser = $_POST["followUser"];
        //     $userID = $_SESSION["UserID"];
        //     $userModel->follow($followUser, $userID);
        //     break;

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
        $recaptcha = $_POST['g-recaptcha-response'];
        $secret_key = CAPTCHA_SECRET_KEY;
        $url = 'https://www.google.com/recaptcha/api/siteverify?secret='
          . $secret_key . '&response=' . $recaptcha;  
          $response = file_get_contents($url); 
          $response = json_decode($response); 
          if ($response->success == true) { 
            echo '<script>alert("Google reCAPTACHA verified")</script>'; 
        } else { 
            echo '<script>alert("Error in Google reCAPTACHA")</script>'; 
            return;
        } 
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
    case "fromPost":
        $userID = $_POST["userID"];
        $userModel->userPage($userID);
        break;
    case "followUser":
        $userIDToFollow = $_POST["userID"];
        $userModel->followUser($userIDToFollow);
        break;
}

class UserController
{
    function fetchFollowers($userID)
    {
        global $userModel;
        $followersCount = $userModel->fetchAmountOfFollowers($userID);
        return $followersCount;
    }

    function fetchFollowing($userID)
    {
        global $userModel;
        $followingCount = $userModel->fetchAmountOfFollowing($userID);
        return $followingCount;
    }

    function fetchPostsAmount($userID)
    {
        global $userModel;
        $followingCount = $userModel->fetchAmountOfPosts($userID);
        return $followingCount;
    }

    function fetchUsername($userID)
    {
        global $userModel;
        $username = $userModel->fetchUsernameById($userID);
        return $username;
    }

    function fetchPosts($userID)
    {
        global $userModel;
        $posts = $userModel->fetchPostsById($userID);
        return $posts;
    }

    function fetchLikes($userID)
    {
        global $userModel;

        $likes = $userModel->fetchLikesById($userID);
        return $likes;
    }

    function fetchDislikes($userID)
    {
        global $userModel;



        $dislikes = $userModel->fetchDisLikesById($userID);
        return $dislikes;
    }

    function fetchUserComments($userID)
    {
        global $userModel;

        $comments = $userModel->fetchUserCommentsByID($userID);
        return $comments;
    }

    function fetchReposts($userID) {
        global $userModel;

        $reposts = $userModel->fetchRepostsByUserID($userID);
        return $reposts;
    }

    function fetchFollowingUsers($userID) {
        global $userModel;

        $followingUser = $userModel->fetchFollowingUsers($userID);
        return $followingUser;
    }

    function fetchUserProfilePicture($userID) {
        global $userModel;

        $profilePicture = $userModel->fetchUserProfilePicture($userID);
        return $profilePicture;
    }

    // function fetchReposts($userID)
    // {
    //     global $userModel;
    //     $posts = $userModel->fetchRepostsById($userID);
    //     return $posts;
    // }
}
