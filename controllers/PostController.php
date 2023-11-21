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
        print_r($_FILES);
        print_r($_POST);
        $title = $_POST["title"];
        $description = $_POST["description"];
        $categories = $_POST["categories"];
        $userID = $_SESSION["UserID"];
        $file = $_FILES["file"]["tmp_name"];
        $fileData = file_get_contents($file);
        $returnDataTest = [
            'title' => $title,
            'description' => $description,
            'userID' => $userID,
            'file' => $file['name'],
        ];

        print_r($returnDataTest);

        // $userID = $_SESSION["UserID"];
        // $title = $_POST["title"];
        // $description = $_POST["description"];
        // $categories = $_POST["categories"];
        // $files = "";


        //return $returnDataTest;
        $postID = $postModel->createPost($userID, $title, $description, $categories, $fileData);

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
        $userID = $_SESSION["UserID"];

        $postModel->addLike($postID, $userID);


        break;

    case "addDislike":

        $postID = $_POST["postID"];
        $userID = $_SESSION["UserID"];

        $postModel->addDislike($postID, $userID);


        break;
    case "removeLike":

        $postID = $_POST["postID"];
        $userID = $_SESSION["UserID"];
        $postModel->removeLike($postID, $userID);

        break;
}
