<?php

namespace models;

require_once 'BaseModel.php';
class UserModel extends BaseModel
{
    function create($username, $email, $password)
    {
        try {
            $cxn = parent::connectToDB();

            $sanitized_username = htmlspecialchars($username);
            $sanitized_email = htmlspecialchars($email);
            $sanitized_password = htmlspecialchars($password);


            $checkUser = "SELECT COUNT(*) AS 'EXISTS' FROM usertable WHERE usertable.Username = :username OR usertable.Email = :email";
            $handleCheckUser = $cxn->prepare($checkUser);
            $handleCheckUser->bindParam(":username", $sanitized_username);
            $handleCheckUser->bindParam(":email", $sanitized_email);
            $handleCheckUser->execute();
            $handleCheckUserResult = $handleCheckUser->fetch();


            // if username or email doesnt exist, continue to create user and send user to login page
            if ($handleCheckUserResult["EXISTS"] == 0) {
                $statement = "INSERT INTO usertable (username, email, password) VALUES (:username, :email, :password);";

                $handle = $cxn->prepare($statement);
                $handle->bindParam(':username', $sanitized_username);
                $handle->bindParam(':email', $sanitized_email);
                $handle->bindParam(':password', $sanitized_password);

                $handle->execute();
                header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/login.php');
            } else {
                throw new \PDOException("Username or Email already Exists", 1);
            }


            $cxn = null;
        } catch (\PDOException $e) {
            print($e->getMessage());
        }
    }

    function login($username, $password)
    {
        try {
            $cxn = parent::connectToDB();




            // First, try treating the input as a username
            $statement = "SELECT UserID, IsAdmin, password FROM usertable WHERE username = :input AND (Banned IS NULL OR Banned = 0) LIMIT 1";
            $handle = $cxn->prepare($statement);
            $handle->bindParam(':input', $username);
            $handle->execute();
            $result = $handle->fetch(\PDO::FETCH_ASSOC);

            // If no match was found for username, try treating the input as an email
            if (!$result) {
                $statement = "SELECT UserID, IsAdmin, password FROM usertable WHERE email = :input AND (Banned IS NULL OR Banned = 0) LIMIT 1";
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
            $cxn = null;
        } catch (\PDOException $e) {
            print($e->getMessage());
            return false;
        }
    }

    function logout($userID)
    {
        //echo "logout done";
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
            $cxn = parent::connectToDB();
            $statement = "SELECT COUNT(*) AS NumberOfFollowers FROM FollowingTable WHERE FollowingID = :userID";
            $query = $cxn->prepare($statement);
            $query->bindParam(":userID", $userID);
            $query->execute();
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            $cxn = null;
            return $result["NumberOfFollowers"];
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function fetchAmountOfFollowing($userID)
    {
        try {
            $cxn = parent::connectToDB();
            $statement = "SELECT COUNT(*) AS FollowingCount FROM FollowingTable WHERE UserID = :userID;";
            $query = $cxn->prepare($statement);
            $query->bindParam(":userID", $userID);
            $query->execute();
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            $cxn = null;
            return $result["FollowingCount"];
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function fetchAmountOfPosts($userID)
    {
        try {
            $cxn = parent::connectToDB();
            $statement = "SELECT COUNT(*) AS NumberOfPostsWithoutParent FROM PostTable WHERE CreatedBy = :userID AND ParentID IS NULL;";
            $query = $cxn->prepare($statement);
            $query->bindParam(":userID", $userID);
            $query->execute();
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            $cxn = null;
            return $result["NumberOfPostsWithoutParent"];
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function fetchUsernameById($userID)
    {
        try {
            $cxn = parent::connectToDB();
            $statement = "SELECT username FROM usertable WHERE userid = :userID;";
            $query = $cxn->prepare($statement);
            $query->bindParam(":userID", $userID);
            $query->execute();
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            $cxn = null;
            return $result["username"];
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function fetchPostsById($userID)
    {
        try {
            $cxn = parent::connectToDB();
            $statement = "CALL fetchUserPosts(:userID);";
            $query = $cxn->prepare($statement);
            $query->bindParam(":userID", $userID);
            $query->execute();
            $result = $query->fetchAll(\PDO::FETCH_ASSOC);
            $cxn = null;
            return $result;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }        
    }

    function fetchLikesById($userID)
    {
        try {
            $cxn = parent::connectToDB();

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
            $cxn = null;
            return $likes;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function fetchDislikesById($userID)
    {
        try {
            $cxn = parent::connectToDB();

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
            $cxn = null;
            return $dislikes;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function fetchRepostsByUserID($userID) {
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
            $cxn = parent::connectToDB();

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
            $cxn = null;
            return $comments;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function userPage($userID)
    {
        header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/profile.php?userid=' . urlencode($userID));
    }  
    
    function followUser($userID) {
    try {
        $currentUser = $_SESSION["UserID"];

        $cxn = parent::connectToDB();

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

    } catch (\PDOException $e) {
        echo $e->getMessage();
    }
}

function fetchFollowingUsers($userID) {
    try {
        $cxn = parent::connectToDB();
        $sql = "CALL GetFollowingUsers(:userID);";
        $query = $cxn->prepare($sql);
        $query->bindParam(":userID", $userID);
        $query->execute();
        $followedUsers = $query->fetchAll(\PDO::FETCH_ASSOC);
        $cxn = null;
        return $followedUsers;
    } catch (\PDOException $e) {
        echo $e->getMessage();
    }
}

}
