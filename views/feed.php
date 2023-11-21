<?php

//echo $_SESSION["UserID"];
require("../db/connection.php");

require("mainBG.php");


$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);

$userID = $_SESSION["UserID"];

$query = "SELECT posttable.PostID, posttable.Title, posttable.Description, posttable.CreatedDate, usertable.Username, mediaTable.ImgData, 
(SELECT COUNT(*) FROM posttable p2 WHERE p2.ParentID = posttable.PostID) AS 'Comments', 
(SELECT COUNT(*) FROM likestable WHERE likestable.PostID = posttable.PostID AND likestable.Type = 1) AS 'Likes', 
(SELECT COUNT(*) FROM likestable WHERE likestable.PostID = posttable.PostID AND likestable.Type = 0) AS 'Dislikes', 
(SELECT COUNT(*) FROM likestable WHERE likestable.UserID = " . $userID . " AND likestable.PostID = posttable.PostID AND likestable.Type = 1) AS 'UserLike', 
(SELECT COUNT(*) FROM likestable WHERE likestable.UserID = " . $userID . " AND likestable.PostID = posttable.PostID AND likestable.Type = 0) AS 'UserDislike'
FROM posttable 
LEFT JOIN MediaTable ON MediaTable.PostID = PostTable.PostID 
LEFT JOIN usertable ON usertable.UserID = posttable.CreatedBy WHERE posttable.ParentID IS NULL";

//$db = mysqli_connect(DB_NAME, DB_USER, DB_PASS, DB_NAME) or die("error opening mysqli");
$db_conn = mysqli_select_db($connection, DB_NAME);
$data = mysqli_query($connection, $query);
$results = mysqli_fetch_all($data);

// $imgObj = [];

// foreach ($results as $result) {
//     $img_sql = mysqli_prepare($connection, "CALL getPostImgs(:postID)");
//     $img_prepare->prepare($img_sql);
//     $img_prepare->bind_param("i", $result["PostID"]);

//     $img_prepare->execute();
//     $imgData = $img_prepare->fetch();

//     $imgObj[] = $imgData;
// }


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