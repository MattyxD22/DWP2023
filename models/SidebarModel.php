<?php

namespace models;

require_once 'BaseModel.php';
session_start();
class SidebarModel extends BaseModel
{

    function loadProfile()
    {
        header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/profile.php');
    }

    function loadCreatePost()
    {
        header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/newPost.php');
    }


    function loadHomepage()
    {
        header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/feed.php');
    }

    function loadCategories()
    {
        header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/categoryPage.php');
    }

    function loadAdminPage(){
        header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/adminPage.php');
    }

    function logOut() {
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
