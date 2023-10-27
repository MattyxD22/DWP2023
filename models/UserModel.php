<?php

namespace models;
require_once 'BaseModel.php';
class UserModel extends BaseModel
{

    function __construct()
    {
    }

    function create($username, $email, $password) {
        try {
            $cxn = parent::connectToDB();

            $statement = "INSERT INTO usertable (username, email, password) VALUES (:username, :email, :password);";

            $sanitized_username = htmlspecialchars($username); 
            $sanitized_email = htmlspecialchars($email); 
            $sanitized_password = htmlspecialchars($password); 

            $handle = $cxn->prepare($statement);
            $handle->bindParam(':username', $sanitized_username);
            $handle->bindParam(':email', $sanitized_email);
            $handle->bindParam(':password', $sanitized_password);

            $handle->execute();
            $cxn = null;
        } catch (\PDOException $e) {
            print($e->getMessage());
        }
    }

    function login($username, $password) {
        try {
            $cxn = parent::connectToDB();

            // First, try treating the input as a username
            $statement = "SELECT password FROM usertable WHERE username = :input LIMIT 1";
            $handle = $cxn->prepare($statement);
            $handle->bindParam(':input', $username);
            $handle->execute();
            $result = $handle->fetch(\PDO::FETCH_ASSOC);

            // If no match was found for username, try treating the input as an email
            if (!$result) {
                $statement = "SELECT password FROM usertable WHERE email = :input LIMIT 1";
                $handle = $cxn->prepare($statement);
                $handle->bindParam(':input', $username);
                $handle->execute();
                $result = $handle->fetch(\PDO::FETCH_ASSOC);
            }

            // Verify the password
            if ($result && password_verify($password, $result['password'])) {
                $_SESSION["UserID"] = $result["UserID"];
                header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/feed.php');
            } else {
                header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/login.php');
            }
        } catch (\PDOException $e) {
            print($e->getMessage());
            return false;
        }
    }

    function logout()
    {
    }

    function updateEmail($userID, $newEmail)
    {
    }

    function updatePassword($userID, $newPassword)
    {
    }
}
