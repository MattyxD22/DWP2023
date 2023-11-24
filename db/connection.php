<?php

namespace db;

require("constants.php");

use Exception;



class DBConnector
{

    private static ?DBConnector $dbConnector = null;
    public static function getDBConnector(): DBConnector
    {
        if (self::$dbConnector === null) {
            self::$dbConnector = new DBConnector();
        }

        return self::$dbConnector;
    }

    private $connection;

    public function getLink()
    {
        return $this->connection;
    }

    private function setLink($connStr)
    {
        $this->connection = $connStr;
    }

    function connectToDB()
    {
        $connStr = new \PDO(
            'mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASS,
            array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_PERSISTENT => false
            )
        );
        $this->setLink($connStr);

        return $this->getLink();
    }

    function closeDatabase()
    {
        $this->setLink(null);
        return null;
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
}
