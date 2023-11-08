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

            $sanitized_postID = htmlspecialchars($postID);

            $get_post = "CALL getPost(:postID)";
            $handle_getPost = $cxn->prepare($get_post);
            $handle_getPost->bindValue(":postID", $sanitized_postID);
            $handle_getPost->execute();
            $post = $handle_getPost->fetch(\PDO::FETCH_ASSOC);
            $cxn = null;
            //$cxn = parent::connectToDB();

            // $get_comments = "CALL getComments(:postID)";
            // $handle_getComments = $cxn->prepare($get_comments);
            // $handle_getComments->bindValue(":postID", $sanitized_postID);
            // $handle_getComments->execute();
            // $comments = $handle_getComments->fetch(\PDO::FETCH_ASSOC);

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

    function getComments($postID)
    {
        try {
            $cxn = parent::connectToDB();

            $sanitized_postID = htmlspecialchars($postID);

            $get_Comments = "CALL getComments(:postID)";
            $handle_getComment = $cxn->prepare($get_Comments);

            $handle_getComment->bindValue(":postID", $sanitized_postID);
            $handle_getComment->execute();
            $comments = $handle_getComment->fetchAll(\PDO::FETCH_ASSOC);
            $cnx = null;

            return include("../views/comments.php");
        } catch (\PDOException $err) {
            print($err->getMessage());
        }
    }

    function createComment($postID, $comment, $userID)
    {

        try {
            $cxn = parent::connectToDB();

            $sanitized_postID = htmlspecialchars($postID);
            $sanitized_description = htmlspecialchars($comment);
            $sanitized_userID = htmlspecialchars($userID);

            $create_Comment = "CALL createComment(:postID, :comment, :userID)";
            $handle_createComment = $cxn->prepare($create_Comment);

            $handle_createComment->bindValue(":postID", $sanitized_postID);
            $handle_createComment->bindValue(":comment", $sanitized_description);
            $handle_createComment->bindValue(":userID", $sanitized_userID);
            $handle_createComment->execute();
            $handle_createComment->fetch(\PDO::FETCH_ASSOC);
            $cnx = null;

            return "200";
        } catch (\PDOException $err) {
            print($err->getMessage());
        }
    }

    function addLike($postID, $userID)
    {
        try {

            $cxn = parent::connectToDB();

            $sanitized_postID = htmlspecialchars($postID);
            $sanitized_userID = htmlspecialchars($userID);


            $likeComment = "CALL updateLikePost(:postID, :userID, 1)";
            $handle_likeComment = $cxn->prepare($likeComment);

            $handle_likeComment->bindValue(":postID", $sanitized_postID);
            $handle_likeComment->bindValue(":userID", $sanitized_userID);
            $handle_likeComment->execute();
            $handle_likeComment->fetch(\PDO::FETCH_ASSOC);
            $cnx = null;
        } catch (\PDOException $err) {
            print($err->getMessage());
            return $err->getMessage();
        }
    }

    function addDislike($postID, $userID)
    {
        try {

            $cxn = parent::connectToDB();

            $sanitized_postID = htmlspecialchars($postID);
            $sanitized_userID = htmlspecialchars($userID);


            $likeComment = "CALL updateLikePost(:postID, :userID, 0)";
            $handle_likeComment = $cxn->prepare($likeComment);

            $handle_likeComment->bindValue(":postID", $sanitized_postID);
            $handle_likeComment->bindValue(":userID", $sanitized_userID);
            $handle_likeComment->execute();
            $handle_likeComment->fetch(\PDO::FETCH_ASSOC);
            $cnx = null;
        } catch (\PDOException $err) {
            print($err->getMessage());
        }
    }

    function removeLike($postID, $userID)
    {
        try {
            $cxn = parent::connectToDB();

            $sanitized_postID = htmlspecialchars($postID);
            $sanitized_userID = htmlspecialchars($userID);

            $likeComment = "CALL deleteFromLikesTable(:postID, :userID)";
            $handle_likeComment = $cxn->prepare($likeComment);

            $handle_likeComment->bindValue(":postID", $sanitized_postID);
            $handle_likeComment->bindValue(":userID", $sanitized_userID);
            $handle_likeComment->execute();
            $cnx = null;

            return "200";
        } catch (\PDOException $err) {
            print($err->getMessage());
        }
    }

    function addCategoryToPost($postID, $categoryID)
    {
    }
}
