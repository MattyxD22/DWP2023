<?php

namespace models;

use Exception;

require_once 'BaseModel.php';
class PostModel extends BaseModel
{

    private static ?PostModel $postModel = null;
    public static function getPostModel(): PostModel
    {
        if (self::$postModel === null) {
            self::$postModel = new PostModel();
        }

        return self::$postModel;
    }

    /**
     * is not allowed to call from outside to prevent from creating multiple instances,
     * to use the singleton, you have to obtain the instance from Singleton::getInstance() instead
     */

    private function __construct()
    {
    }


    /**
     * prevent the instance from being cloned (which would create a second instance of it)
     */

    private function __clone()
    {
    }


    /**
     * prevent from being unserialized (which would create a second instance of it)
     * */

    public function __wakeup()

    {

        throw new Exception("Cannot unserialize singleton");
    }



    function createPost($userID, $title, $description, $categories, $filesArr)
    {

        try {
            $cxn = $this->openDB();

            $sanitized_title = htmlspecialchars($title);
            $sanitized_description = htmlspecialchars($description);

            $create_post = "CALL addNewPost(:description, :userID, :title)";
            $handleCreatePost = $cxn->prepare($create_post);
            $handleCreatePost->bindValue(":userID", $userID);
            $handleCreatePost->bindParam(":title", $sanitized_title);
            $handleCreatePost->bindParam(":description", $sanitized_description);
            $handleCreatePost->execute();
            $postID =  $handleCreatePost->fetch(\PDO::FETCH_ASSOC);
            $cxn = $this->closeDB();

            if (!empty($categories)) {

                foreach ($categories as $key => $category) {
                    $cxn = $this->openDB();
                    print_r($category);
                    $addCategory = "CALL addPostToCategory(:CategoryID, :postID)";
                    $handle_addCategory = $cxn->prepare($addCategory);
                    $handle_addCategory->bindValue(":CategoryID", $category);
                    $handle_addCategory->bindValue(":postID", $postID["PostID"]);
                    $handle_addCategory->execute();
                    $cxn = $this->closeDB();
                }
            }


            // Upload file to database if exists
            if (!empty($filesArr)) {


                // FileType / Type is currently hardcoded to 1, once there is time, create functions to determine filetype and adjust accordingly, 1 = img (for now)
                // PostID = ID which should be returned by previous database call
                // file = file to upload

                // Use foreach loop, if multiple files exists
                foreach ($filesArr as $key => $file) {
                    $cxn = $this->openDB();
                    print_r($file);
                    $addImg = "CALL addFileToPost(:type, :postID, :file)";
                    $handle_addImg = $cxn->prepare($addImg);
                    $handle_addImg->bindValue(":type", $file["type"]);
                    $handle_addImg->bindValue(":postID", $postID["PostID"]);
                    $handle_addImg->bindParam(":file", $file["data"]);
                    $handle_addImg->execute();
                    $cxn = $this->closeDB();
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
            $cxn = $this->openDB();

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
            
            $imgs = $handle_getPostImgs->fetchAll(\PDO::FETCH_ASSOC);


            $cxn = $this->closeDB();


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
            $cxn = $this->openDB();

            $sanitized_postID = htmlspecialchars($postID);

            $get_Comments = "CALL GetReplyChain(:postID)";
            $handle_getComment = $cxn->prepare($get_Comments);

            $handle_getComment->bindValue(":postID", $sanitized_postID);
            $handle_getComment->execute();
            $comments = $handle_getComment->fetchAll(\PDO::FETCH_ASSOC);

            $cnx = $this->closeDB();

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
            $cxn = $this->openDB();

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
            $cnx = $this->closeDB();

            return include("../views/refreshComments.php");
        } catch (\PDOException $err) {
            print($err->getMessage());
        }
    }

    function addLike($postID, $userID)
    {
        try {

            $cxn = $this->openDB();

            $sanitized_postID = htmlspecialchars($postID);
            $sanitized_userID = htmlspecialchars($userID);




            $likeComment = "CALL updateLikePost(:postID, :userID, 1)";
            $handle_likeComment = $cxn->prepare($likeComment);

            $handle_likeComment->bindValue(":postID", $sanitized_postID);
            $handle_likeComment->bindValue(":userID", $sanitized_userID);
            $handle_likeComment->execute();
            $plz = $handle_likeComment->fetch(\PDO::FETCH_ASSOC);
            $cnx = $this->closeDB();
            print_r($plz);
        } catch (\PDOException $err) {
            print($err->getMessage());
            return $err->getMessage();
        }
    }

    function addDislike($postID, $userID)
    {
        try {

            $cxn = $this->openDB();

            $sanitized_postID = htmlspecialchars($postID);
            $sanitized_userID = htmlspecialchars($userID);


            $likeComment = "CALL updateLikePost(:postID, :userID, 0)";
            $handle_likeComment = $cxn->prepare($likeComment);

            $handle_likeComment->bindValue(":postID", $sanitized_postID);
            $handle_likeComment->bindValue(":userID", $sanitized_userID);
            $handle_likeComment->execute();
            $handle_likeComment->fetch(\PDO::FETCH_ASSOC);
            $cnx = $this->closeDB();
        } catch (\PDOException $err) {
            print($err->getMessage());
        }
    }

    function removeLike($postID, $userID)
    {
        try {
            $cxn = $this->openDB();

            $sanitized_postID = htmlspecialchars($postID);
            $sanitized_userID = htmlspecialchars($userID);

            $likeComment = "CALL deleteFromLikesTable(:postID, :userID)";
            $handle_likeComment = $cxn->prepare($likeComment);

            $handle_likeComment->bindValue(":postID", $sanitized_postID);
            $handle_likeComment->bindValue(":userID", $sanitized_userID);
            $handle_likeComment->execute();
            $cnx = $this->closeDB();

            return "200";
        } catch (\PDOException $err) {
            print($err->getMessage());
        }
    }

    function repost($postID, $userID) {
        try  {
            $cxn = $this->openDB();

            $sanitized_postID = htmlspecialchars($postID);
            $sanitized_userID = htmlspecialchars($userID);

            $sql = "CALL repostPost(:postID, :userID);";
            $handle_repost = $cxn->prepare($sql);

            $handle_repost->bindValue(":postID", $sanitized_postID);
            $handle_repost->bindValue(":userID", $sanitized_userID);
            $handle_repost->execute();
            $cxn = $this->closeDB();
        } catch (\PDOException $err) {
            print($err->getMessage());
        }
    }

    function addCategoryToPost($postID, $categoryID)
    {
    }

    function updatePost($postID, $title, $description){
        try {
            $cxn = $this->openDB();

            $sanitized_Title = htmlspecialchars($title);
            $sanitized_Description = htmlspecialchars($description);

            $sql = "UPDATE PostTable SET PostTable.Title = :title, PostTable.Description = :description WHERE PostTable.PostID = :postID";
            $handle_sql = $cxn->prepare($sql);

            $handle_sql->bindValue(":postID", $postID);
            $handle_sql->bindValue(":title", $sanitized_Title);
            $handle_sql->bindValue(":description", $sanitized_Description);
            $handle_sql->execute();
            $cnx = $this->closeDB();

            return "200";
        } catch (\PDOException $err) {
            print($err->getMessage());
        }
    }

    function hidePost($postID){
        try {
            $cxn = $this->openDB();

            $sql = "UPDATE PostTable SET PostTable.Hidden = 1 WHERE PostTable.PostID = :postID";
            $handle_sql = $cxn->prepare($sql);

            $handle_sql->bindValue(":postID", $postID);
            $handle_sql->execute();
            $cnx = $this->closeDB();

            return "200";
        } catch (\PDOException $err) {
            print($err->getMessage());
        }
    }

    function unhidePost($postID){
        try {
            $cxn = $this->openDB();

            $sql = "UPDATE PostTable SET PostTable.Hidden = 0 WHERE PostTable.PostID = :postID";
            $handle_sql = $cxn->prepare($sql);

            $handle_sql->bindValue(":postID", $postID);
            $handle_sql->execute();
            $cnx = $this->closeDB();

            return "200";
        } catch (\PDOException $err) {
            print($err->getMessage());
        }
    }

    function deletePost($postID){
        try {
            $cxn = $this->openDB();

            $sql = "UPDATE PostTable SET PostTable.Deleted = 1 WHERE PostTable.PostID = :postID";
            $handle_sql = $cxn->prepare($sql);

            $handle_sql->bindValue(":postID", $postID);
            $handle_sql->execute();
            $cnx = $this->closeDB();

            return "200";
        } catch (\PDOException $err) {
            print($err->getMessage());
        }
    }
}
