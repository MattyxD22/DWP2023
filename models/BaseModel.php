<?php

namespace models;

require_once __DIR__ . '/../db\connection.php';

use db\DBConnector;


session_start();


class BaseModel extends DBConnector
{

    function __construct()
    {
    }

    function openDB()
    {
        return $this::getDBConnector()->connectToDB();
    }

    function closeDB()
    {
        return $this::getDBConnector()->closeDatabase();
    }
}
