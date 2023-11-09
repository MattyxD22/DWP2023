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
            $getFeed = "CALL getFeed()";
            $handle_getFeed = $cxn->prepare($getFeed);
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
        header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/categoryPage.php');
    }

    function loadAdminPage()
    {
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
