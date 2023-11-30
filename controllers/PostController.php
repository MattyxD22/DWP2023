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
        //print_r($_FILES);
        //print_r($_POST);
        $title = $_POST["title"];
        $description = $_POST["description"];
        $categories[] = $_POST["categories"];
        $userID = $_SESSION["UserID"];
        //$files = $_FILES["file"];

        $filesArr = [];

        $count = 0;
        foreach ($_FILES as $file) {

            $tmp = $file['tmp_name'];
            $tmp_name = file_get_contents($file["tmp_name"]);

            $temp_arr = array('data' => $tmp_name);
            print_r($temp_arr);

            array_push($filesArr, $temp_arr);

            $tmp_name = '';
            $tmp = '';
        }

        $postID = $postModel->createPost($userID, $title, $description, $categories, $filesArr);

        //return "It works???";
        break;

    case "openPost":

        $postID = $_POST["postID"];

        return $postModel->openPost($postID);

        break;

    case "createComment":

        $postID = $_POST["postID"];
        $comment = $_POST["comment"];
        $orgID = $_POST["orgID"];
        $userID = $_SESSION["UserID"];

        $enc_Comment = base64_encode($comment);

        //print_r(base64_encode($enc_Comment));

        return $postModel->createComment($postID, $enc_Comment, $userID, $orgID);

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
