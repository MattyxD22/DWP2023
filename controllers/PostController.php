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
} else if ($_FILES) {
    // retrieve action parameter from _GET requests
    $action = $_FILES["action"];
} else {
    // debug/test
    $action = $_ACTION["action"];
}


switch ($action) {
    case "createPost":

        $title = $_FILES["name"]["title"];
        $description = $_FILES["description"];
        $userID = $_SESSION["UserID"];
        $file = $_FILES["file"];
        $returnDataTest = [
            'title' => $title,
            'description' => $description,
            'userID' => $userID,
            'file' => $file['name'],
        ];

        //return $returnDataTest;
        $postID = $postModel->createPost($userID, $title, $description, $file);

        //return "It works???";
        break;

    case "openPost":

        $postID = $_POST["postID"];

        return $postModel->openPost($postID);

        break;

    case "createComment":

        $postID = $_POST["postID"];
        $comment = $_POST["comment"];
        $userID = $_SESSION["UserID"];

        return $postModel->createComment($postID, $comment, $userID);

        break;

    case "addLike":

        $postID = $_POST["postID"];
        $postID = $_SESSION["UserID"];

        $postModel->addLike($postID, $userID);


        break;
    case "removeLike":

        $postID = $_POST["postID"];
        $postID = $_SESSION["UserID"];
        $postModel->removeLike($postID, $userID);

        break;
}
