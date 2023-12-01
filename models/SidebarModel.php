<?php

namespace models;

use Exception;

require_once 'BaseModel.php';

class SidebarModel extends BaseModel
{

    private static ?SidebarModel $sidebarModel = null;
    public static function getSidebarModel(): SidebarModel
    {
        if (self::$sidebarModel === null) {
            self::$sidebarModel = new SidebarModel();
        }

        return self::$sidebarModel;
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

    function loadProfile()
    {
        header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/profile.php');
    }

    function loadCreatePost()
    {

        try {
            $cxn = $this->openDB();
            $getCategories = "CALL getCategories()";
            $handle_getCategories = $cxn->prepare($getCategories);
            $handle_getCategories->execute();
            $categories = $handle_getCategories->fetchAll(\PDO::FETCH_ASSOC);
            $cxn = $this->closeDB();
            return include("../views/newPost.php");
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }


        //header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/newPost.php');
    }


    function loadHomepage()
    {

        try {
            $cxn = $this->openDB();
            $getFeed = "CALL getFeed(:UserID)";
            $handle_getFeed = $cxn->prepare($getFeed);
            $handle_getFeed->bindParam(":UserID", $_SESSION["UserID"]);
            $handle_getFeed->execute();
            $results = $handle_getFeed->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($results as &$result) {
                $result["Images"] = [];

                // Fetch all images associated with the current post
                $query2 = "SELECT mediatable.ImgData FROM mediatable WHERE mediatable.PostID = :PostID ORDER BY mediatable.PostID;";
                $handle_getFeed = $cxn->prepare($query2);
                $handle_getFeed->bindParam(":PostID", $result["PostID"]);
                $handle_getFeed->execute();
                $imgData =  $handle_getFeed->fetchAll(\PDO::FETCH_ASSOC);

                // Add images to the 'Images' key in the $result array
                if (!empty($imgData)) {
                    $result["Images"] = $imgData;
                }
            }

            $cxn = $this->closeDB();
            return include("../views/feedOnly.php");
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }



        //header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/feed.php');
    }

    function loadCategories()
    {

        try {
            $cxn = $cxn = $this->openDB();
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



            $cxn = $this->closeDB();
            return include("../views/categoryPage.php");
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }

        //header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/categoryPage.php');
    }

    function loadAdminPage()
    {

        try {
            $cnx = $this->openDB();

            $request = "CALL getRules()";
            $handle_request = $cnx->prepare($request);
            $handle_request->execute();
            $rules = $handle_request->fetchAll(\PDO::FETCH_ASSOC);

            $handle_request->closeCursor();

            $aboutsql = "SELECT * FROM abouttable LIMIT 1";
            $prep = $cnx->prepare($aboutsql);
            $prep->execute();
            $aboutDescription = $prep->fetch(\PDO::FETCH_ASSOC);

            return include("../views/adminPage.php");

            $cnx = $this->closeDB();
        } catch (\PDOException $err) {
            print_r($err->getMessage());
        }

        //header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/adminPage.php');
    }

    function loadAboutUs()
    {
        header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/aboutUs.php');
    }

    function logOut()
    {
        session_destroy();
        header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/login.php');
    }

    function rules()
    {

        try {
            $cnx = $this->openDB();

            $request = "CALL getRules()";
            $handle_request = $cnx->prepare($request);
            $handle_request->execute();
            $rules = $handle_request->fetchAll(\PDO::FETCH_ASSOC);

            return include("../views/rules.php");

            $cnx = $this->closeDB();
        } catch (\PDOException $err) {
            print_r($err->getMessage());
        }
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
