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
            $statement = "SELECT password, UserID FROM usertable WHERE username = :input LIMIT 1";
            $handle = $cxn->prepare($statement);
            $handle->bindParam(':input', $username);
            $handle->execute();
            $result = $handle->fetch(\PDO::FETCH_ASSOC);

            // If no match was found for username, try treating the input as an email
            if (!$result) {
                $statement = "SELECT password, UserID FROM usertable WHERE email = :input LIMIT 1";
                $handle = $cxn->prepare($statement);
                $handle->bindParam(':input', $username);
                $handle->execute();
                $result = $handle->fetch(\PDO::FETCH_ASSOC);
            }

            // Verify the password
            if ($result && password_verify($password, $result['password'])) {
                $_SESSION["UserID"] = $result["UserID"];
                session_write_close();
                header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/feed.php');
            } else {
                return 0;
            }
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
}
