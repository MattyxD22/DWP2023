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
    function uploadUserImage($userImage) {
        try {
            $cxn = $this->openDB();
            $sql = "CALL addFileToPost(:type, :postID, :file);";
            $query = $cxn->prepare($sql);
            $query->bindValue(":type", 1);
            $query->bindValue(":postID", NULL);
            $query->bindValue(":file", $userImage);
            $query->execute();

            $newId = $query->fetch(\PDO::FETCH_ASSOC);
            $newMediaID = $newId['NewMediaID'];
            $cxn = $this->closeDB();
            return $newMediaID;
        } catch (\Exception $e) {
            print($e->getMessage());
            return "";
        }
    }

    function updateUserAdmin($userID, $userBan, $userNewEmail, $userNewPassword, $userNewImage) {
        try {  
            if (!empty($userNewImage)) {
                $newMediaID = $this->uploadUserImage($userNewImage);
            } else {
                $newMediaID = "";
            }

            var_dump($newMediaID);

            $cxn = $this->openDB();
            $sql = "UPDATE UserTable
                    SET Banned = COALESCE(:userBan, Banned),
                        Email = COALESCE(NULLIF(:userNewEmail, ''), Email),
                        Password = COALESCE(NULLIF(:userNewPassword, ''), Password),
                        MediaID = COALESCE(NULLIF(:mediaID, ''), MediaID)
                    WHERE UserID = :userID;";
            $query = $cxn->prepare($sql);
            $query->bindParam(':userID', $userID);
            $query->bindParam(':userBan', $userBan);
            $query->bindParam(':userNewEmail', $userNewEmail);
            $query->bindParam(':userNewPassword', $userNewPassword);
            $query->bindParam(':mediaID', $newMediaID);
            $query->execute();
            $cxn = $this->closeDB();
        } catch (\Exception $e) {
            print($e->getMessage());
            $cnx = $this->closeDB();
            return false;
        }

    }

    function updateUser($userID, $userNewEmail, $userNewPassword, $userNewImage)
    {
        try {

            if (!empty($userNewImage)) {
                $newMediaID = $this->uploadUserImage($userNewImage);
            } else {
                $newMediaID = "";
            }

            $cxn = $this->openDB();
            $query = $cxn->prepare("UPDATE UserTable
                                    SET Email = COALESCE(NULLIF(:userNewEmail, ''), Email),
                                        Password = COALESCE(NULLIF(:userNewPassword, ''), Password),
                                        MediaID = COALESCE(NULLIF(:mediaID, ''), MediaID)
                                    WHERE UserID = :userID;");

            // Bind the parameters
            $query->bindParam(':userID', $userID);
            $query->bindParam(':userNewEmail', $userNewEmail);
            $query->bindParam(':userNewPassword', $userNewPassword);
            $query->bindParam(':mediaID', $newMediaID);
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

    function updateDescription($description) {
        try {
            $cnx = $this->connectToDB();
            $sql = "UPDATE abouttable SET Description = :description";
            $query = $cnx->prepare($sql);
            $query->bindParam(":description", $description);
            $query->execute();
            $cnx = null;
            return true;
        } catch (\PDOException $err) {
            print_r($err->getMessage());
            return false;
        }
    }
}
