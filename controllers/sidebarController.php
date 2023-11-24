<?php

require("../models/SidebarModel.php");

use models\SidebarModel;

$sidebarModel = new SidebarModel();

if ($_POST) {
    // This checks if a request was send from $ajax/javascript. 
    $action = $_POST["action"];
} else if ($_GET) {
    // retrieve action parameter from _GET requests
    $action = $_GET["action"];
}

switch ($action) {

    case "newPost":
        return $sidebarModel->loadCreatePost();
        //redirect("http://localhost/DWP2023/views/newPost.php");
        //return $sidebarModel->loadCreatePost();
        break;
    case "homepage":
        $sidebarModel->loadHomepage();
        break;
    case 'category':
        $sidebarModel->loadCategories();
        break;
    case "profile":
        $sidebarModel->loadProfile();
        break;
    case "logout":
        $sidebarModel->logOut();
        break;
    case "admin":
        $sidebarModel->loadAdminPage();
        break;
    case "aboutUs":
        $sidebarModel->loadAboutUs();
        break;
}





// class SidebarController
// {
//     protected $action;

//     public function __construct()
//     {
//         if ($_POST) {
//             // This checks if a request was send from $ajax/javascript. 
//             $this->action = $_POST["action"];
//         } else if ($_GET) {
//             // retrieve action parameter from _GET requests
//             $this->action = $_GET["action"];
//         }

//         switch ($this->action) {

//             case "newPost":
//                 $this->redirect("http://localhost/DWP2023/views/newPost.php");
//                 //return $sidebarModel->loadCreatePost();
//                 break;
//         }
//     }

//     /**
//      * Render the template, returning it's content.
//      * @param array $data Data made available to the view.
//      * @return string The rendered template.
//      */
//     public function render(array $data)
//     {
//         extract($data);

//         ob_start();
//         include(APP_PATH . DIRECTORY_SEPARATOR . $this->template);
//         $content = ob_get_contents();
//         ob_end_clean();
//         return $content;
//     }
// }
