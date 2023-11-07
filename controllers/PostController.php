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
        $userID = 0;
        $postID = $postModel->createPost($userID, $title, $description);


        return json_encode("It works???");

        //return "It works???";
        break;

    case "openPost":

        $postID = $_POST["postID"];

        return $postModel->openPost($postID);

        break;
}

function render_view($path, array $args)
{
}
