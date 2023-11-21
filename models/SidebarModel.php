<?php

namespace models;

require_once 'BaseModel.php';

class SidebarModel extends BaseModel
{

    function loadProfile()
    {
        header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/profile.php');
    }

    function loadCreatePost()
    {

        try {
            $cxn = parent::connectToDB();
            $getCategories = "CALL getCategories()";
            $handle_getCategories = $cxn->prepare($getCategories);
            $handle_getCategories->execute();
            $categories = $handle_getCategories->fetchAll(\PDO::FETCH_ASSOC);

            return include("../views/newPost.php");
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }


        //header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/newPost.php');
    }


    function loadHomepage()
    {

        try {
            $cxn = parent::connectToDB();
            $getFeed = "CALL getFeed(:UserID)";
            $handle_getFeed = $cxn->prepare($getFeed);
            $handle_getFeed->bindParam(":UserID", $_SESSION["UserID"]);
            $handle_getFeed->execute();
            $results = $handle_getFeed->fetchAll(\PDO::FETCH_ASSOC);

            return include("../views/feedOnly.php");
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }



        //header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/feed.php');
    }

    function loadCategories()
    {

        try {
            $cxn = parent::connectToDB();
            $getCategories = "CALL getCategories()";
            $handle_getCategories = $cxn->prepare($getCategories);
            $handle_getCategories->execute();
            $results = $handle_getCategories->fetchAll(\PDO::FETCH_ASSOC);
            //echo sizeof($results);
            $handle_getCategories->closeCursor();

            $posts = [];

            foreach ($results as $key => $category) {

                $getPosts = "CALL getPostsInCategory(:CategoryID)";
                $handle_getPosts = $cxn->prepare($getPosts);
                $handle_getPosts->bindValue(":CategoryID", $category["CategoryID"]);
                $handle_getPosts->execute();
                $post = $handle_getPosts->fetchAll(\PDO::FETCH_ASSOC);

                foreach ($post as $key => $postVal) {
                    array_push($posts, (object)[
                        'CategoryID' => $category['CategoryID'],
                        'PostID' => $postVal["PostID"],
                        'CreatedDate' => $postVal['CreatedDate'],
                        'CreatedBy' => $postVal['CreatedBy'],
                        'Title' => $postVal['Title'],
                        'Username' => $postVal['Username'],
                        'Likes' => $postVal['Likes'],
                        'Dislikes' => $postVal['Dislikes'],
                        'Comments' => $postVal['Comments'],
                        'ImgData' => $postVal['ImgData'],
                    ]);
                }


                $handle_getPosts->closeCursor();
            }

            $getUncatorized = "CALL getUncatorizedPosts()";
            $handle_getUncatorized = $cxn->prepare($getUncatorized);
            $handle_getUncatorized->execute();
            $resultsUncatorized = $handle_getUncatorized->fetchAll(\PDO::FETCH_ASSOC);




            return include("../views/categoryPage.php");
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }

        //header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/categoryPage.php');
    }

    function loadAdminPage(){
        header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/adminPage.php');
    }

    function logOut()
    {
        session_destroy();
        header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/login.php');
    }
}

// class View
// {
//     function render($file, $variables = array())
//     {
//         extract($variables);

//         ob_start();
//         include $file;
//         $renderedView = ob_get_clean();

//         return $renderedView;
//     }
// }
