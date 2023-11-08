<?php

//echo $_SESSION["UserID"];
require("../db/connection.php");

require("mainBG.php");


$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);

$query =    "SELECT posttable.PostID, posttable.Title, posttable.Description, posttable.CreatedDate, usertable.Username FROM posttable LEFT JOIN usertable ON usertable.UserID = posttable.CreatedBy;";

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
        <div class="feed_col w-full h-full flex flex-col overflow-y-auto py-3 px-3 justify-center state_col">
            <?php foreach ($results as $key => $value) { ?>

                <div class="feed_item" data-id="<?php echo $value[0] ?>">

                    <div class="feed_header h-1/6 align-center">
                        <i class="bi bi-person-circle text-4xl"></i>
                        <span class="ms-3 font-bold"><?php echo $value[4] ?></span>
                    </div>
                    <div class="feed_content h-4/6">

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


                        <div class="reposts_div pe-4 my-auto">
                            <span class="text-red-600 text-l font-bold">10</span>
                            <span class="text-white text-l font-bold ms-1">Reposts</span>
                        </div>

                        <div class="comments_div pe-4 my-auto">
                            <span class="text-red-600 text-l font-bold">1024</span>
                            <span class="text-white text-l font-bold ms-1">Comments</span>
                        </div>

                        <div class="actions_div flex flex-row ms-auto my-auto">

                            <div class="action_like">
                                <i class="bi bi-hand-thumbs-up text-xl text-red-600 flex"></i>
                                <i class="bi bi-hand-thumbs-up-fill text-xl text-red-600 cursor-pointer" data-id="1"></i>

                            </div>

                            <div class="action_dislike">
                                <i class="bi bi-hand-thumbs-down text-xl text-red-600 flex"></i>
                                <i class="bi bi-hand-thumbs-down-fill text-xl text-red-600 cursor-pointer" data-id="1"></i>

                            </div>




                        </div>


                    </div>

                </div>

                <!-- //include('./feedItem.php'); -->
            <?php } ?>
        </div>
    </div>
</div>


<!--Copy paste for later -->
<!-- <div class="container-fluid flex flex-row w-full h-full">
    <div class="columns-2 w-full flex flex-row">
        <div class="sidebar_col w-1/5">

        </div>
        <div class="feed_col w-4/5">

        </div>
    </div>
</div> -->