<?php

namespace models;

require_once 'BaseModel.php';
class SidebarModel extends BaseModel
{

    function loadProfile()
    {
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

    function loadAdminPage()
    {
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
