<?php

require("../models/PostModel.php");

use models\PostModel;

$postModel = new PostModel();

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
    case "createPost":

        $title = $_POST["title"];
        $description = $_POST["description"];
        $userID = $_SESSION["UserID"];
        $postID = $postModel->createPost($userID, $title, $description);

        //return "It works???";
        break;

    case "openPost":

        $postID = $_POST["postID"];

        return $postModel->openPost($postID);

        break;

    case "createComment":

        $postID = $_POST["postID"];
        $comment = $_POST["comment"];
        $userID = 2;

        return $postModel->createComment($postID, $comment, $userID);

        break;

    case "addLike":

        $postID = $_POST["postID"];
        $postID = $_POST["userID"];

        $postModel->addLike($postID, $userID);


        break;
    case "removeLike":

        $postID = $_POST["postID"];
        $postID = $_POST["userID"];
        $postModel->removeLike($postID, $userID);

        break;
}
