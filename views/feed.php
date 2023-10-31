<?php

require("../db/connection.php");

require("mainBG.php");
?>

<div class="container-fluid flex flex-row w-full h-full">
    <div class="columns-2 w-full flex flex-row">
        <div class="sidebar_col">
            <?php include('../views/sideBar.php') ?>
        </div>
        <div class="feed_col w-full h-full flex flex-col overflow-y-auto py-3 px-3 state_col">
            <?php

            for ($i = 0; $i < 15; $i++) {

                include('./feedItem.php');
            }

            ?>
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