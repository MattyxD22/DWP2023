<?php

namespace db;

require("constants.php");

class DBConnector
{
    function connectToDB()
    {
        $link = new \PDO(
            'mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASS,
            array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_PERSISTENT => false
            )
        );

        return $link;
    }
}


// <?php

// require("constants.php");

// $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);

// if (!$connection) {
//     die("Server not working :/");
// }

// $DB_SELECT = mysqli_select_db($connection, DB_NAME);

// if (!$DB_SELECT) {
//     die("Query not working :/" . mysqli_error($connection));
// }
