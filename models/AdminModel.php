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

}