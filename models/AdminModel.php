<?php

namespace models;

require_once 'BaseModel.php';

class AdminModel extends BaseModel{

    function getUser($userID) {
        try {
            $cxn = parent::connectToDB();
            $statement = "SELECT UserID, Username, FName, LName, Email, Banned FROM usertable WHERE IsAdmin = 0 OR UserID = :userID;";
            $query = $cxn->prepare($statement);
            $query->bindParam(":userID", $userID);
            $query->execute();
            $result = $query->fetchAll(\PDO::FETCH_ASSOC);
            $cxn = null;
            return $result;
        } catch (\Exception $e) {
            print($e->getMessage());
            $cxn = null;
            return false;
        }
    }

    function updateUser($userID, $userBan, $userNewEmail, $userNewPassword) {
        try {
            $cxn = parent::connectToDB();
            $query = $cxn->prepare("UPDATE UserTable
                                SET Banned = :userBan,
                                    Email = :userNewEmail,
                                    Password = :userNewPassword
                                WHERE UserID = :userID");
        
            // Bind the parameters
            $query->bindParam(':userID', $userID);
            $query->bindParam(':userBan', $userBan);
            $query->bindParam(':userNewEmail', $userNewEmail);
            $query->bindParam(':userNewPassword', $userNewPassword);
            $query->execute();
            if ($query->rowCount() > 0) {
            $cxn = null;
            return true;
            } else {
                $cxn = null;
                return false;
            }
        } catch (\Exception $e) {
            print($e->getMessage());
            $cxn = null;
            return false;
        }
    }

}