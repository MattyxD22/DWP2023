<?php

namespace models;

class UserModel extends BaseModel
{

    function __construct()
    {
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
