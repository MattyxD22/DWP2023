<?php

namespace models;

require_once 'BaseModel.php';
class PostModel extends BaseModel
{
    function createPost($userID, $title, $description)
    {

        try {
            $cxn = parent::connectToDB();

            $sanitized_title = htmlspecialchars($title);
            $sanitized_description = htmlspecialchars($description);

            $create_post = "CALL addNewPost(:description, :userID, :title)";
            $handleCreatePost = $cxn->prepare($create_post);
            $handleCreatePost->bindValue(":userID", $userID);
            $handleCreatePost->bindParam(":title", $sanitized_title);
            $handleCreatePost->bindParam(":description", $sanitized_description);
            $handleCreatePost->execute();
            return $handleCreatePost->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $err) {
            print($err->getMessage());
        }
    }

    function openPost($postID)
    {

        try {
            $cxn = parent::connectToDB();

            $sanitized_title = htmlspecialchars($postID);

            $get_post = "CALL getPost(:postID)";
            $handle_getPost = $cxn->prepare($get_post);
            $handle_getPost->bindValue(":postID", $postID);
            $handle_getPost->execute();
            $post = $handle_getPost->fetch(\PDO::FETCH_ASSOC);
            return include("../views/post.php");
        } catch (\PDOException $err) {
            print($err->getMessage());
        }


        //header("Location: " . DOMAIN_NAME . BASE_URL . "../views/post.php");
    }

    function likePost($postID, $userID)
    {
    }

    function dislikePost($postID, $userID)
    {
    }

    function createComment($postID, $userID, $comment)
    {
    }

    function addCategoryToPost($postID, $categoryID)
    {
    }
}
