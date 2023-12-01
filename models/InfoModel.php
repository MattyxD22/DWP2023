<?php

namespace models;

use Exception;

require_once 'BaseModel.php';

class InfoModel extends BaseModel
{


    private static ?InfoModel $infoModel = null;
    public static function getInfoModel(): InfoModel
    {
        if (self::$infoModel === null) {
            self::$infoModel = new InfoModel();
        }

        return self::$infoModel;
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

    function fetchAboutUsDetails()
    {

        try {
            $cxn = $this->openDB();
            $sql = "SELECT * FROM contactinfotable LIMIT 1";
            $query = $cxn->prepare($sql);
            $query->execute();
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            print_r($result);
            $cxn = $this->closeDB();
            return $result;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    function fetchAboutUsDescription() {
        try {
            $cxn = $this->openDB();
            $sql = "SELECT * FROM abouttable LIMIT 1";
            $query = $cxn->prepare($sql);
            $query->execute();
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            print_r($result);
            $cxn = $this->closeDB();
            return $result["Description"];
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

}
