<?php

namespace models;

require_once __DIR__ . '/../db\connection.php';

use db\DBConnector;

class BaseModel extends DBConnector
{

    function __construct()
    {
    }
}
