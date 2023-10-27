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
        //return "../views/newPost.php"->create_View;

        // $view = new View();
        // return $view->render('../views/newPost.php', array('foo' => 'bar'));
    }
    function loadCategories()
    {
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
