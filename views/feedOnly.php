<?php foreach ($results as $key => $value) { ?>

    <div class="feed_item" data-id="<?php echo $value["PostID"] ?>">

        <div class="feed_header h-1/6 align-center">
            <i class="bi bi-person-circle text-4xl"></i>
            <span class="ms-3 font-bold"><?php echo $value["Username"] ?></span>
        </div>
        <div class="feed_content h-4/6">
            <div class="feed_title_container py-2 px-2">
                <span><?php echo $value["Title"] ?></span>
            </div>

            <div class="feed_title_container py-2 px-2">
                <span><?php echo $value["Description"] ?></span>
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
                    <i class="bi bi-hand-thumbs-up-fill text-xl text-red-600 cursor-pointer like_post" data-user="<?php echo $_SESSION["UserID"] ?>" data-id="<?php echo $value["PostID"] ?>"></i>

                </div>

                <div class="action_dislike">
                    <i class="bi bi-hand-thumbs-down text-xl text-red-600 flex"></i>
                    <i class="bi bi-hand-thumbs-down-fill text-xl text-red-600 cursor-pointer dislike_post" data-user="<?php echo $_SESSION["UserID"] ?>" data-id="<?php echo $value["PostID"] ?>"></i>

                </div>

            </div>

        </div>

    </div>
    <!-- //include('./feedItem.php'); -->
<?php } ?>