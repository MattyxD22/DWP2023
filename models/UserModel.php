<?php

namespace models;
require_once 'BaseModel.php';
class UserModel extends BaseModel
{

    function __construct()
    {
    }

    function create($username, $email, $password)
    {
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

    function login($userID, $password)
    {

        try {
            $userID = htmlspecialchars($userID);
            $userID = htmlspecialchars($password);
    
            $conn = parent::connectToDB();




            //code...
        } catch (\PDOException $err) {
            //throw $th;
        } finally{
            $conn = null;
        }

        



    }

    function logout($userID)
    {
    }

    function updateEmail($userID, $newEmail)
    {
    }

    function updatePassword($userID, $newPassword)
    {
    }
}
