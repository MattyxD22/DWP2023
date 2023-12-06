<?php

require("../models/PostModel.php");
require("../models/SidebarModel.php");

use models\PostModel;
use models\SidebarModel;

$postModel = PostModel::getPostModel();
$sidebarModel = SidebarModel::getSidebarModel();

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
        $description = base64_encode($_POST["description"]);
        $categories[] = $_POST["categories"];
        $userID = $_SESSION["UserID"];
        //$files = $_FILES["file"];

        $filesArr = [];

        $count = 0;
        foreach ($_FILES as $file) {



            $tmp = $file['tmp_name'];

            $extension = pathinfo($file["name"], PATHINFO_EXTENSION);
            print_r($extension);
            $tmp_name = file_get_contents($file['tmp_name']);

            $type = 1;

            if ($extension == "MP4" || $extension == "mp4") {
                $type = 2;
            }

            if ($extension == "WEBM" || $extension == "webm") {
                $type = 2;
            }



            $temp_arr = array('data' => $tmp_name, 'type' => $type);
            //print_r($temp_arr);

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

    case "repost":
        $postID = $_POST["postID"];
        $userID = $_SESSION["UserID"];
        $postModel->repost($postID, $userID);
        break;

    case "updatePost":

        $postID = $_POST["postID"];
        $title = $_POST["title"];
        $description = base64_encode($_POST["description"]);

        $postModel->updatePost($postID, $title, $description);
        return $postModel->openPost($postID);
        break;

    case "hidePost":


        $postID = $_POST["postID"];
        $postModel->hidePost($postID);

        //Return user to feed page after hiding post
        return $sidebarModel->loadHomepage();

        break;
    case "unhidePost":


        $postID = $_POST["postID"];
        $postModel->unhidePost($postID);
        return $postModel->openPost($postID);

        break;

    case "deletePost":


        $postID = $_POST["postID"];
        $postModel->deletePost($postID);
        //Return user to feed page after deleting post
        return $sidebarModel->loadHomepage();

        break;
}
