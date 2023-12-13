<?php

//echo $_SESSION["UserID"];
require("../db/connection.php");

require("mainBG.php");


//Check if user has a sesson
if (isset($_SESSION["UserID"])) {
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);

    $userID = $_SESSION["UserID"];

$query = "SELECT PostView.PostID, PostView.Title, PostView.Description, PostView.CreatedDate, usertable.Username, PostView.CreatedBy, mediaTable.ImgData, 
(SELECT COUNT(*) FROM PostView p2 WHERE p2.ParentID = PostView.PostID) AS 'Comments', 
(SELECT COUNT(*) FROM likestable WHERE likestable.PostID = PostView.PostID AND likestable.Type = 1) AS 'Likes', 
(SELECT COUNT(*) FROM likestable WHERE likestable.PostID = PostView.PostID AND likestable.Type = 0) AS 'Dislikes', 
(SELECT COUNT(*) FROM likestable WHERE likestable.UserID = " . $userID . " AND likestable.PostID = PostView.PostID AND likestable.Type = 1) AS 'UserLike', 
(SELECT COUNT(*) FROM likestable WHERE likestable.UserID = " . $userID . " AND likestable.PostID = PostView.PostID AND likestable.Type = 0) AS 'UserDislike',
(SELECT COUNT(*) FROM RepostTable WHERE RepostTable.PostID = PostView.PostID) AS 'Reposts',
(SELECT COUNT(*) FROM RepostTable WHERE RepostTable.UserID = UserID AND RepostTable.PostID = PostView.PostID) AS 'UserReposted',
PostView.CreatedDate,
UserMedia.ImgData AS UserImgData
FROM 
    PostView 
LEFT JOIN 
    MediaTable ON MediaTable.PostID = PostView.PostID 
LEFT JOIN 
    UserTable ON UserTable.UserID = PostView.CreatedBy
LEFT JOIN 
    MediaTable AS UserMedia ON UserTable.MediaID = UserMedia.MediaID
WHERE 
    PostView.Hidden = 0 AND PostView.Deleted = 0 AND
        NOT EXISTS (
            SELECT 1 FROM BlockedTable
            WHERE BlockedTable.UserID = UserID AND BlockedTable.BlockedID = PostView.CreatedBy
        )
ORDER BY 
    PostView.CreatedDate DESC;";

    //$query2 = "SELECT MediaTable.ImgData FROM MediaTable WHERE MediaTable.PostID = ";

    //$db = mysqli_connect(DB_NAME, DB_USER, DB_PASS, DB_NAME) or die("error opening mysqli");
    $db_conn = mysqli_select_db($connection, DB_NAME);
    $data = mysqli_query($connection, $query);
    $results = mysqli_fetch_all($data);

    foreach ($results as &$result) {
        //print_r($result);
        $result["Images"] = [];

        // Fetch all images associated with the current post
        $query2 = "SELECT MediaTable.ImgData FROM MediaTable WHERE MediaTable.PostID = " . $result[0] . " ORDER BY MediaTable.PostID;";
        $data2 = mysqli_query($connection, $query2);
        $imgData = mysqli_fetch_all($data2);

        // Add images to the 'Images' key in the $result array
        if (!empty($imgData)) {
            $result["Images"] = $imgData;
        }

        //$results["Comments"] = [];

        // $query3 = "CALL getChainRepliesCount(". $result[0] .")";

        // $data3 = mysqli_query($connection, $query3);
        // $commentsData = mysqli_fetch_all($data3);

        // // Add images to the 'Images' key in the $result array
        // if (!empty($commentsData)) {
        //     $result["Comments"] = $commentsData;
        // }

    }

    //echo $imgArray;


    mysqli_close($connection);
?>

    <div class="container-fluid flex flex-row w-full h-full">
        <div class="columns-2 w-full flex flex-row">
            <div class="sidebar_col">
                <?php include('../views/sideBar.php') ?>
            </div>
            <div class="feed_col w-full h-full flex flex-col overflow-y-auto py-3 px-3 state_col">
                <?php
                foreach ($results as $key => $post) {



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
<?php } else {
    header('Location: ' . DOMAIN_NAME . BASE_URL . '/views/login.php');
} ?>