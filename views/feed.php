<?php

//echo $_SESSION["UserID"];
require("../db/connection.php");

require("mainBG.php");


$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);

$query = "SELECT posttable.PostID, posttable.Title, posttable.Description, posttable.CreatedDate, usertable.Username FROM posttable LEFT JOIN usertable ON usertable.UserID = posttable.CreatedBy WHERE posttable.ParentID IS NULL";

//$db = mysqli_connect(DB_NAME, DB_USER, DB_PASS, DB_NAME) or die("error opening mysqli");
$db_conn = mysqli_select_db($connection, DB_NAME);
$data = mysqli_query($connection, $query);
$results = mysqli_fetch_all($data);
mysqli_close($connection);
?>

<div class="container-fluid flex flex-row w-full h-full">
    <div class="columns-2 w-full flex flex-row">
        <div class="sidebar_col">
            <?php include('../views/sideBar.php') ?>
        </div>
        <div class="feed_col w-full h-full flex flex-col overflow-y-auto py-3 px-3 state_col">
            <?php foreach ($results as $key => $value) {


                include('./feedItem.php');
            } ?>
        </div>
    </div>
</div>


<!--Copy paste for later -->
<!-- <div class=" container-fluid flex flex-row w-full h-full">
                                    <div class="columns-2 w-full flex flex-row">
                                        <div class="sidebar_col w-1/5">

                                        </div>
                                        <div class="feed_col w-4/5">

                                        </div>
                                    </div>
                            </div> -->