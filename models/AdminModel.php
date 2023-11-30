<?php

namespace models;

use Exception;

require_once 'BaseModel.php';

class AdminModel extends BaseModel
{

    private static ?AdminModel $adminModel = null;
    public static function getAdminModel(): AdminModel
    {
        if (self::$adminModel === null) {
            self::$adminModel = new AdminModel();
        }

        return self::$adminModel;
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


    function getContactInfo()
    {
        try {
            $cxn = $this->openDB();
            $statement = "SELECT * FROM contactinfotable LIMIT 1";
            $query = $cxn->prepare($statement);
            $query->execute();
            $result = $query->fetch();
            $cnx = $this->closeDB();
            return $result;
        } catch (\Exception $e) {
            print($e->getMessage());
            $cnx = $this->closeDB();
            return false;
        }
    }

    function updateContact($contactData)
    {

        try {
            $fName = htmlspecialchars($contactData['fName']);
            $lName = htmlspecialchars($contactData['lName']);
            $email = htmlspecialchars($contactData['email']);
            $phoneNumber = htmlspecialchars($contactData['phoneNumber']);
            $city = htmlspecialchars($contactData['city']);
            $houseNumber = htmlspecialchars($contactData['houseNumber']);
            $streetName = htmlspecialchars($contactData['streetName']);

            $cxn = $this->openDB();
            $statement = "UPDATE contactinfotable SET Email = :email, FName = :fname, LName = :lname,
             PhoneNumber = :phoneNumber, City = :city, StreetName = :streetName, HouseNumber = :houseNumber;";
            $query = $cxn->prepare($statement);
            $query->bindParam(":fname", $fName);
            $query->bindParam(":email", $email);
            $query->bindParam(":lname", $lName);
            $query->bindParam(":phoneNumber", $phoneNumber);
            $query->bindParam(":city", $city);
            $query->bindParam(":houseNumber", $houseNumber);
            $query->bindParam(":streetName", $streetName);
            $query->execute();
            $cnx = $this->closeDB();
            return true;
        } catch (\Exception $e) {
            print($e->getMessage());
            return false;
        }
    }

    function getUser($userID)
    {
        try {
            $cxn = $this->openDB();
            $statement = "SELECT UserID, Username, FName, LName, Email, Banned FROM usertable WHERE IsAdmin = 0 OR UserID = :userID;";
            $query = $cxn->prepare($statement);
            $query->bindParam(":userID", $userID);
            $query->execute();
            $result = $query->fetchAll(\PDO::FETCH_ASSOC);
            $cnx = $this->closeDB();
            return $result;
        } catch (\Exception $e) {
            print($e->getMessage());
            $cnx = $this->closeDB();
            return false;
        }
    }

    function updateUser($userID, $userBan, $userNewEmail, $userNewPassword)
    {
        try {
            $cxn = $this->openDB();
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
                $cnx = $this->closeDB();
                return true;
            } else {
                $cnx = $this->closeDB();
                return false;
            }
        } catch (\Exception $e) {
            print($e->getMessage());
            $cnx = $this->closeDB();
            return false;
        }
    }

    function deleteRule($ruleID)
    {
        try {
            $cnx = $this->openDB();

            $request = "CALL deleteRule(:ruleID)";
            $handle_request = $cnx->prepare($request);
            $handle_request->bindParam(":ruleID", $ruleID);
            $handle_request->execute();
            $cnx = $this->closeDB();
        } catch (\PDOException $err) {
            print_r($err->getMessage());
        }
    }

    // function addRule($rule)
    // {
    //     try {
    //         $cnx = $this->openDB();

    //         $request = "CALL insertRule(:rule)";
    //         $handle_request = $cnx->prepare($request);
    //         $handle_request->bindParam(":rule", $rule);
    //         $handle_request->execute();
    //         $cnx = $this->closeDB();
    //     } catch (\PDOException $err) {
    //         print_r($err->getMessage());
    //     }
    // }

    function updateRule($ruleID, $ruleText)
    {
        try {
            $cnx = $this->openDB();

            $request = "CALL updateRule(:ruleID, :ruleText)";
            $handle_request = $cnx->prepare($request);
            $handle_request->bindParam(":ruleID", $ruleID);
            $handle_request->bindParam(":ruleText", $ruleText);
            $handle_request->execute();
            $cnx = $this->closeDB();
        } catch (\PDOException $err) {
            print_r($err->getMessage());
        }
    }

    function getNewRule()
    {
        return include('../views/new_rule.php');
    }

    function getRules()
    {
        try {
            $cnx = $this->openDB();

            $request = "CALL getRules()";
            $handle_request = $cnx->prepare($request);
            $handle_request->execute();
            $rules = $handle_request->fetchAll(\PDO::FETCH_ASSOC);
            return $rules;
            $cnx = $this->closeDB();
        } catch (\PDOException $err) {
            print_r($err->getMessage());
        }
    }

    function addNewRule($rule)
    {
        try {
            $cnx = $this->openDB();

            $ruleStmt = "CALL insertRule(:rule)";
            $handle_addRule = $cnx->prepare($ruleStmt);
            $handle_addRule->bindParam(":rule", $rule);
            $handle_addRule->execute();

            $request = "CALL getRules()";
            $handle_request = $cnx->prepare($request);
            $handle_request->execute();
            $rules = $handle_request->fetchAll(\PDO::FETCH_ASSOC);
            return include('../views/updateRules.php');
            $cnx = $this->closeDB();
        } catch (\PDOException $err) {
            print_r($err->getMessage());
        }
    }
}
