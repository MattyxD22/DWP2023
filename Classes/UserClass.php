<?php

class User
{
    protected $id;
    public $userName;
    public $email;
    private $admin;
    public $profilePicture;

    private static ?User $user = null;

    public static function getInstance(): User
    {
        if (self::$user === null) {
            self::$user = new User();
        }

        return self::$user;
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
     */

    public function __wakeup()

    {

        throw new Exception("Cannot unserialize singleton");
    }


    public function getUsername()
    {
        return $this->userName;
    }

    public function setUsername($userName)
    {
        $this->userName = $userName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getAdmin(){
        return $this->admin;
    }

    public function setAdmin($admin){
        $this->admin = $admin;
    }
}
