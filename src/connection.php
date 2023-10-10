<?php

require("constants.php");

$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);

if (!$connection) {
    die("Server not working :/");
}

$DB_SELECT = mysqli_select_db($connection, DB_NAME);

if (!$DB_SELECT) {
    die("Query not working :/" . mysqli_error($connection));
}
