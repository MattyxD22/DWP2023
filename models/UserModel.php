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

    function login($email, $password)
    {

        try {
            $email = htmlspecialchars($email);
            $password = htmlspecialchars($password);

            $conn = parent::connectToDB();
            $stmt = "SELECT usertable.Password, usertable.UserID FROM usertable WHERE usertable.Email = :email";
            $prepareSTM = $conn->prepare($stmt);
            $prepareSTM->bindParam(":email", $email);
            $prepareSTM->execute();

            //$resultSTM = $prepareSTM->fetchAll();

            $hashedPass = "";

            while ($row = $prepareSTM->fetch()) {

                $hashedPass = $row["Password"];
                $verifyPass = password_verify($password, $hashedPass);

                if ($verifyPass == 1) {
                    $_SESSION["UserID"] = $row["UserID"];
                    header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/feed.php');
                }
            }




            // foreach ($resultSTM as $key => $value) {
            //     echo $value;
            // }

        } catch (\PDOException $err) {
            foreach ($err as $key => $value) {
                echo $value[2];
            }
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
