<?php

//echo $_SESSION["UserID"];
require("../db/connection.php");

require("mainBG.php");


//Check if user has a sesson
if (isset($_SESSION["UserID"])) {
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);

    $userID = $_SESSION["UserID"];

$query = "SELECT posttable.PostID, posttable.Title, posttable.Description, posttable.CreatedDate, usertable.Username, posttable.CreatedBy, mediaTable.ImgData, 
(SELECT COUNT(*) FROM posttable p2 WHERE p2.ParentID = posttable.PostID) AS 'Comments', 
(SELECT COUNT(*) FROM likestable WHERE likestable.PostID = posttable.PostID AND likestable.Type = 1) AS 'Likes', 
(SELECT COUNT(*) FROM likestable WHERE likestable.PostID = posttable.PostID AND likestable.Type = 0) AS 'Dislikes', 
(SELECT COUNT(*) FROM likestable WHERE likestable.UserID = " . $userID . " AND likestable.PostID = posttable.PostID AND likestable.Type = 1) AS 'UserLike', 
(SELECT COUNT(*) FROM likestable WHERE likestable.UserID = " . $userID . " AND likestable.PostID = posttable.PostID AND likestable.Type = 0) AS 'UserDislike',
(SELECT COUNT(*) FROM RepostTable WHERE RepostTable.PostID = posttable.PostID) AS 'Reposts',
(SELECT COUNT(*) FROM RepostTable WHERE RepostTable.UserID = UserID AND RepostTable.PostID = posttable.PostID) AS 'UserReposted',
posttable.CreatedDate
FROM posttable 
LEFT JOIN MediaTable ON MediaTable.PostID = PostTable.PostID 
LEFT JOIN usertable ON usertable.UserID = posttable.CreatedBy WHERE posttable.ParentID IS NULL ORDER BY posttable.CreatedDate DESC";

    //$query2 = "SELECT mediatable.ImgData FROM mediatable WHERE mediatable.PostID = ";

    //$db = mysqli_connect(DB_NAME, DB_USER, DB_PASS, DB_NAME) or die("error opening mysqli");
    $db_conn = mysqli_select_db($connection, DB_NAME);
    $data = mysqli_query($connection, $query);
    $results = mysqli_fetch_all($data);
    // $imgArray = [];

    // foreach ($results as $result) {
    //     $postID = $result[0];
    //     $imgArray[$postID] = [
    //         'PostID' => $postID,
    //         'Data' => []
    //     ];

    //     // Fetch images for the current post
    //     $query2 = "SELECT mediatable.ImgData FROM mediatable WHERE mediatable.PostID = $postID ORDER BY mediatable.PostID";
    //     $imgDataResult = mysqli_query($connection, $query2);

    //     while ($imgDataRow = mysqli_fetch_assoc($imgDataResult)) {
    //         $imgArray[$postID]['Data'][] = $imgDataRow['ImgData'];
    //     }
    // }

    foreach ($results as &$result) {
        $result["Images"] = [];

        // Fetch all images associated with the current post
        $query2 = "SELECT mediatable.ImgData FROM mediatable WHERE mediatable.PostID = " . $result[0] . " ORDER BY mediatable.PostID;";
        $data2 = mysqli_query($connection, $query2);
        $imgData = mysqli_fetch_all($data2);

        // Add images to the 'Images' key in the $result array
        if (!empty($imgData)) {
            $result["Images"] = $imgData;
        }
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
                <?php foreach ($results as $key => $post) {



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