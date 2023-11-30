<?php

namespace models;

require_once 'BaseModel.php';
class PostModel extends BaseModel
{
    function createPost($userID, $title, $description, $categories, $filesArr)
    {

        try {
            $cxn = $this->connectToDB();

            $sanitized_title = htmlspecialchars($title);
            $sanitized_description = htmlspecialchars($description);

            $create_post = "CALL addNewPost(:description, :userID, :title)";
            $handleCreatePost = $cxn->prepare($create_post);
            $handleCreatePost->bindValue(":userID", $userID);
            $handleCreatePost->bindParam(":title", $sanitized_title);
            $handleCreatePost->bindParam(":description", $sanitized_description);
            $handleCreatePost->execute();
            $postID =  $handleCreatePost->fetch(\PDO::FETCH_ASSOC);
            $cxn = $this->closeDatabase();

            if (!empty($categories)) {

                foreach ($categories as $key => $category) {
                    $cxn = $this->connectToDB();
                    print_r($category);
                    $addCategory = "CALL addPostToCategory(:CategoryID, :postID)";
                    $handle_addCategory = $cxn->prepare($addCategory);
                    $handle_addCategory->bindValue(":CategoryID", $category);
                    $handle_addCategory->bindValue(":postID", $postID["PostID"]);
                    $handle_addCategory->execute();
                    $cxn = $this->closeDatabase();
                }
            }


            // Upload file to database if exists
            if (!empty($filesArr)) {


                // FileType / Type is currently hardcoded to 1, once there is time, create functions to determine filetype and adjust accordingly, 1 = img (for now)
                // PostID = ID which should be returned by previous database call
                // file = file to upload

                // Use foreach loop, if multiple files exists
                foreach ($filesArr as $key => $file) {
                    $cxn = $this->connectToDB();
                    $addImg = "CALL addFileToPost(:type, :postID, :file)";
                    $handle_addImg = $cxn->prepare($addImg);
                    $handle_addImg->bindValue(":type", 1);
                    $handle_addImg->bindValue(":postID", $postID["PostID"]);
                    $handle_addImg->bindParam(":file", $file["data"]);
                    $handle_addImg->execute();
                    $cxn = $this->closeDatabase();
                }
            }
            //return
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

            $handle_getPost->closeCursor();

            $get_postImgs = "CALL getPostImgs(:postID)";
            $handle_getPostImgs = $cxn->prepare($get_postImgs);
            $handle_getPostImgs->bindValue(":postID", $sanitized_postID);
            $handle_getPostImgs->execute();
            //header("content-type: image/jpeg");
            $imgs = $handle_getPostImgs->fetch(\PDO::FETCH_ASSOC);
            //print_r($imgs["ImgData"]);

            $cxn = null;
            //$cxn = parent::connectToDB();

            // $get_comments = "CALL getComments(:postID)";
            // $handle_getComments = $cxn->prepare($get_comments);
            // $handle_getComments->bindValue(":postID", $sanitized_postID);
            // $handle_getComments->execute();
            // $comments = $handle_getComments->fetch(\PDO::FETCH_ASSOC);

            // $content = [
            //     'data' => $post,
            //     'view' => include("../views/post.php")
            // ];

            return include("../views/post.php");
            //return $content;
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

            $get_Comments = "CALL GetReplyChain(:postID)";
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

    /**
     * orgID Is the original post ID, it is needed to refresh the comments when creating a reply
     */
    function createComment($postID, $comment, $userID, $orgID)
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

            return include("../views/refreshComments.php");
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
            $plz = $handle_likeComment->fetch(\PDO::FETCH_ASSOC);
            $cnx = null;
            print_r($plz);
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
