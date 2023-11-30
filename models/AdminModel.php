<?php

namespace models;

require_once 'BaseModel.php';

class AdminModel extends BaseModel
{



    function getContactInfo()
    {
        try {
            $cxn = $this->connectToDB();
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

            $cxn = $this->connectToDB();
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
            $cxn = $this->connectToDB();
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
            $cxn = $this->connectToDB();
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
            $cnx = $this->connectToDB();

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
    //         $cnx = $this->connectToDB();

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
            $cnx = $this->connectToDB();

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
            $cnx = $this->connectToDB();

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
            $cnx = $this->connectToDB();

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
