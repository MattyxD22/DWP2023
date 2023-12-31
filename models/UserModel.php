<?php

namespace models;

use Exception;

require_once 'BaseModel.php';
class UserModel extends BaseModel
{

    private static ?UserModel $userModel = null;
    public static function getUserModel(): UserModel
    {
        if (self::$userModel === null) {
            self::$userModel = new UserModel();
        }

        return self::$userModel;
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

    function create($username, $email, $password)
    {
        try {
            $cxn = $this->openDB();

            $sanitized_username = htmlspecialchars($username);
            $sanitized_email = htmlspecialchars($email);
            $sanitized_password = htmlspecialchars($password);


            $checkUser = "SELECT COUNT(*) AS 'EXISTS' FROM UserTable WHERE UserTable.Username = :username OR UserTable.Email = :email";
            $handleCheckUser = $cxn->prepare($checkUser);
            $handleCheckUser->bindParam(":username", $sanitized_username);
            $handleCheckUser->bindParam(":email", $sanitized_email);
            $handleCheckUser->execute();
            $handleCheckUserResult = $handleCheckUser->fetch();


            // if username or email doesnt exist, continue to create user and send user to login page
            if ($handleCheckUserResult["EXISTS"] == 0) {
                $statement = "INSERT INTO UserTable (username, email, password) VALUES (:username, :email, :password);";

                $handle = $cxn->prepare($statement);
                $handle->bindParam(':username', $sanitized_username);
                $handle->bindParam(':email', $sanitized_email);
                $handle->bindParam(':password', $sanitized_password);

                $handle->execute();
                header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/login.php');
            } else {
                throw new \PDOException("Username or Email already Exists", 1);
            }


            $cxn = $this->closeDB();
        } catch (\PDOException $e) {
            print($e->getMessage());
        }
    }

    function login($username, $password)
    {
        try {
            $cxn = $this->openDB();




            // First, try treating the input as a username
            $statement = "SELECT UserID, IsAdmin, password FROM UserTable WHERE username = :input AND (Banned IS NULL OR Banned = 0) LIMIT 1";
            $handle = $cxn->prepare($statement);
            $handle->bindParam(':input', $username);
            $handle->execute();
            $result = $handle->fetch(\PDO::FETCH_ASSOC);

            // If no match was found for username, try treating the input as an email
            if (!$result) {
                $statement = "SELECT UserID, IsAdmin, password FROM UserTable WHERE email = :input AND (Banned IS NULL OR Banned = 0) LIMIT 1";
                $handle = $cxn->prepare($statement);
                $handle->bindParam(':input', $username);
                $handle->execute();
                $result = $handle->fetch(\PDO::FETCH_ASSOC);
            }

            // Verify the password
            if ($result && password_verify($password, $result['password'])) {
                $_SESSION["UserID"] = $result["UserID"];
                if ($result["IsAdmin"] == 1) {
                    $_SESSION["isAdmin"] = true;
                } else {
                    $_SESSION["isAdmin"] = false;
                }
                session_write_close();
                //return include("../views/feedOnly.php");
                header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/feed.php');
            } else {
                return 0;
            }
            $cxn = $this->closeDB();
        } catch (\PDOException $e) {
            print($e->getMessage());
            return false;
        }
    }

    function logout($userID)
    {
        //echo "logout done";
        $_SESSION["UserID"] = null;
        header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/login.php');
    }

    function updateEmail($userID, $newEmail)
    {
    }

    function updatePassword($userID, $newPassword)
    {
    }

    function fetchAmountOfFollowers($userID)
    {
        try {
            $cxn = $this->openDB();
            $statement = "SELECT COUNT(*) AS NumberOfFollowers FROM FollowingTable WHERE FollowingID = :userID";
            $query = $cxn->prepare($statement);
            $query->bindParam(":userID", $userID);
            $query->execute();
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            $cxn = $this->closeDB();
            return $result["NumberOfFollowers"];
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function fetchAmountOfFollowing($userID)
    {
        try {
            $cxn = $this->openDB();
            $statement = "SELECT COUNT(*) AS FollowingCount FROM FollowingTable WHERE UserID = :userID;";
            $query = $cxn->prepare($statement);
            $query->bindParam(":userID", $userID);
            $query->execute();
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            $cxn = $this->closeDB();
            return $result["FollowingCount"];
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function fetchAmountOfPosts($userID)
    {
        try {
            $cxn = $this->openDB();
            $statement = "SELECT COUNT(*) AS NumberOfPostsWithoutParent FROM PostTable WHERE CreatedBy = :userID AND ParentID IS NULL AND PostTable.Deleted = 0;";
            $query = $cxn->prepare($statement);
            $query->bindParam(":userID", $userID);
            $query->execute();
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            $cxn = $this->closeDB();
            return $result["NumberOfPostsWithoutParent"];
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function fetchUsernameById($userID)
    {
        try {
            $cxn = $this->openDB();
            $statement = "SELECT username FROM UserTable WHERE userid = :userID;";
            $query = $cxn->prepare($statement);
            $query->bindParam(":userID", $userID);
            $query->execute();
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            $cxn = $this->closeDB();
            return $result["username"];
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function fetchPostsById($userID)
    {
        try {
            $cxn = $this->openDB();
            //$statement = "SELECT PostID, Description, CreatedDate, CreatedBy, Title, CategoryID, MediaTable.ImgData FROM PostTable LEFT JOIN MediaTable ON MediaTable.PostID = PostTable.PostID WHERE ParentID IS NULL AND CreatedBy = :userID ORDER BY PostID DESC;";
            $statement = "CALL  fetchUserPosts(:userID)";
            $query = $cxn->prepare($statement);
            $query->bindParam(":userID", $userID);
            $query->execute();
            $result = $query->fetchAll(\PDO::FETCH_ASSOC);
            $cxn = $this->closeDB();
            $result["Image"] = [];

            foreach ($result as $post) {
                $cxn = $this->openDB();
                $statement2 = "SELECT MediaTable.ImgData FROM MediaTable WHERE MediaTable.PostID = :postID LIMIT 1";

                $query2 = $cxn->prepare($statement2);
                $query2->bindParam(":postID", $post["PostID"]);
                $query2->execute();
                $imgData = $query2->fetchAll(\PDO::FETCH_ASSOC);
                if (!empty($imgData)) {
                    $post["Image"] = $imgData;
                }
                //print_r($post["Image"]);

                $cxn = $this->closeDB();
            }



            return $result;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function fetchLikesById($userID)
    {
        try {
            $cxn = $this->openDB();

            $statement = "CALL fetchLikesByID(:UserID)";
            $query = $cxn->prepare($statement);
            $query->bindValue(":UserID", $userID);
            $query->execute();
            $likes = $query->fetchAll(\PDO::FETCH_ASSOC);

            // $statement = "CALL fetchLikesByID(:UserID)";
            // $query = $cxn->prepare($statement);
            // $query->bindValue(":userID", $userID);
            // $query->execute();
            // $result = $query->fetchAll(\PDO::FETCH_ASSOC);
            $cxn = $this->closeDB();
            return $likes;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function fetchDislikesById($userID)
    {
        try {
            $cxn = $this->openDB();

            $statement = "CALL fetchDislikesByID(:UserID)";
            $query = $cxn->prepare($statement);
            $query->bindValue(":UserID", $userID);
            $query->execute();
            $dislikes = $query->fetchAll(\PDO::FETCH_ASSOC);

            // $statement = "CALL fetchLikesByID(:UserID)";
            // $query = $cxn->prepare($statement);
            // $query->bindValue(":userID", $userID);
            // $query->execute();
            // $result = $query->fetchAll(\PDO::FETCH_ASSOC);
            $cxn = $this->closeDB();
            return $dislikes;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function fetchRepostsByUserID($userID)
    {
        try {
            $cxn = parent::connectToDB();

            $sql = "CALL fetchUserReposts(:userID);";
            $query = $cxn->prepare($sql);
            $query->bindValue(":userID", $userID);
            $query->execute();
            $reposts = $query->fetchALL(\PDO::FETCH_ASSOC);
            $cxn = null;
            return $reposts;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function fetchUserCommentsByID($userID)
    {
        try {
            $cxn = $this->openDB();

            $statement = "CALL fetchUserCommentsByID(:UserID)";
            $query = $cxn->prepare($statement);
            $query->bindValue(":UserID", $userID);
            $query->execute();
            $comments = $query->fetchAll(\PDO::FETCH_ASSOC);

            // $statement = "CALL fetchLikesByID(:UserID)";
            // $query = $cxn->prepare($statement);
            // $query->bindValue(":userID", $userID);
            // $query->execute();
            // $result = $query->fetchAll(\PDO::FETCH_ASSOC);
            $cxn = $this->closeDB();
            return $comments;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function userPage($userID)
    {
        header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/profile.php?userid=' . urlencode($userID));
    }

    function followUser($userID)
    {
        try {
            $currentUser = $_SESSION["UserID"];

            $cxn = $this->openDB();

            $checkStatement = "SELECT * FROM FollowingTable WHERE UserID = :currentUser AND FollowingID = :targetUser";
            $checkQuery = $cxn->prepare($checkStatement);
            $checkQuery->bindParam(":currentUser", $currentUser);
            $checkQuery->bindParam(":targetUser", $userID);
            $checkQuery->execute();

            if ($checkQuery->rowCount() > 0) {
                $statement = "DELETE FROM FollowingTable WHERE UserID = :currentUser AND FollowingID = :targetUser";
            } else {
                $statement = "INSERT INTO FollowingTable (UserID, FollowingID) VALUES (:currentUser, :targetUser)";
            }

            $query = $cxn->prepare($statement);
            $query->bindParam(":currentUser", $currentUser);
            $query->bindParam(":targetUser", $userID);
            $query->execute();
            $cxn = $this->closeDB();
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function fetchFollowingUsers($userID)
    {
        try {
            $cxn = $this->openDB();
            $sql = "CALL GetFollowingUsers(:userID);";
            $query = $cxn->prepare($sql);
            $query->bindParam(":userID", $userID);
            $query->execute();
            $followedUsers = $query->fetchAll(\PDO::FETCH_ASSOC);
            $cxn = $this->closeDB();
            return $followedUsers;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function blockUser($userID) {
        try {
            $currentUser = $_SESSION["UserID"];

            $cxn = $this->openDB();
            $sql = "CALL BlockUnblockUser(:userID, :userToBlock)";
            $query = $cxn->prepare($sql);
            $query->bindValue(":userID", $currentUser);
            $query->bindValue(":userToBlock", $userID);
            $query->execute();
            $cxn = $this->closeDB();

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function fetchBlockedUsers($userID) {
        try {
            $cxn = $this->openDB();
            $sql = "CALL GetBlockedUsers(:userID);";
            $query = $cxn->prepare($sql);
            $query->bindParam(":userID", $userID);
            $query->execute();
            $blockedUsers = $query->fetchAll(\PDO::FETCH_ASSOC);
            $cxn = $this->closeDB();
            return $blockedUsers;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function fecthIsUserBlocked($userID) {
        try {
            $currentUser = $_SESSION["UserID"];
            $cxn = $this->openDB();
            $sql = "CALL GetIsUserBlocked(:userID, :isBlockedUser, @isBlocked);";
            $query = $cxn->prepare($sql);
            $query->bindParam(":userID", $currentUser);
            $query->bindParam(":isBlockedUser", $userID);
            $query->execute();

            $sql = "SELECT @isBlocked AS isBlocked";
            $query = $cxn->prepare($sql);
            $query->execute();
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            $isBlocked = $result['isBlocked'];
            $cxn = $this->closeDB();
            return $isBlocked;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function fetchUserProfilePicture($userID) {
        try {
            $cxn = $this->openDB();
            $sql = "CALL GetMediaImgDataByUserID(:userID);";
            $query = $cxn->prepare($sql);
            $query->bindParam(":userID", $userID);
            $query->execute();
            $profilePicture = $query->fetch(\PDO::FETCH_ASSOC);
            $cxn = $this->closeDB();
            return $profilePicture;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}
