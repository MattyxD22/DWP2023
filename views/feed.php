<?php

//echo $_SESSION["UserID"];
require("../db/connection.php");

require("mainBG.php");


$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);


$query = "SELECT posttable.PostID, posttable.Title, posttable.Description, posttable.CreatedDate, usertable.Username, usertable.UserID FROM posttable LEFT JOIN usertable ON usertable.UserID = posttable.CreatedBy WHERE posttable.ParentID IS NULL";

//$db = mysqli_connect(DB_NAME, DB_USER, DB_PASS, DB_NAME) or die("error opening mysqli");
$db_conn = mysqli_select_db($connection, DB_NAME);
$data = mysqli_query($connection, $query);
$results = mysqli_fetch_all($data);

$imgObj = [];

foreach ($results as $result) {
    $img_prepare = mysqli_prepare($connection, "CALL getPostImgs(?)");
    $img_prepare->prepare($result[0]);

    $img_prepare->execute();
    $imgData = $img_prepare->fetch();
    
    $imgObj[] = $imgData;
}


mysqli_close($connection);
?>

<div class="container-fluid flex flex-row w-full h-full">
    <div class="columns-2 w-full flex flex-row">
        <div class="sidebar_col">
            <?php include('../views/sideBar.php') ?>
        </div>
        <div class="feed_col w-full h-full flex flex-col overflow-y-auto py-3 px-3 state_col">
            <?php foreach ($results as $key => $value) { ?>

                <div class="feed_item" data-id="<?php echo $value[0] ?>">

                    <div class="feed_header h-1/6 align-center cursor-pointer open_profile_event" data-userid="<?php echo $value[5] ?>">
                        <i class="bi bi-person-circle text-4xl"></i>
                        <span class="ms-3 font-bold"><?php echo $value[4] ?></span>
                    </div>
                    <div class="feed_content h-4/6">
                        <div class="feed_title_container py-2 px-2">
                            <span><?php echo $value[1] ?></span>
                        </div>
                        <div class="feed_title_container py-2 px-2">
                            <span><?php echo $value[2] ?></span>
                        </div>
                    </div>
                    <div class="feed_footer h-1/6 pt-2">

                        <div class="likes_div pe-4 my-auto">

                            <span class="text-red-600 text-l font-bold">600</span>
                            <span class="text-white text-l font-bold ms-1">Likes</span>

                        </div>

                        <div class="dislikes_div pe-4 my-auto">
                            <span class="text-red-600 text-l font-bold">32</span>
                            <span class="text-white text-l font-bold ms-1">Dislikes</span>
                        </div>

                    </div>
                </div>


                        <?php
                // include('./feedItem.php');
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