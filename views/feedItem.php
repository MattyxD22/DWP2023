<div class="feed_item" data-id="<?php echo $value[0] ?>">

    <div class="feed_header h-1/6 align-center">
        <i class="bi bi-person-circle text-4xl"></i>
        <span class="ms-3 font-bold"><?php echo $value[4] ?></span>
    </div>
    <div class="feed_content flex flex-col h-4/6">

        <div class="feed_title_container py-2 px-2">
            <span><?php echo $value[1] ?></span>
        </div>

        <div class="feed_title_container py-2 px-2">
            <span><?php echo $value[2] ?></span>
        </div>


        <div class="feed_image_container h-full overflow-hidden flex">

            <?php if (!empty($value[5])) { ?>
                <div class="feed_img_container  h-full flex flex-row justify-center items-center my-auto mx-auto">
                    <img class="object-contain h-full" src="data:image/jpeg;base64,<?php echo base64_encode($value[5]); ?>">
                </div>
            <?php } ?>

        </div>


    </div>
    <div class="feed_footer h-1/6 pt-2">

        <div class="likes_div pe-4 my-auto">

            <span class="text-red-600 text-l font-bold"><?php echo $value[7] ?></span>
            <span class="text-white text-l font-bold ms-1">Likes</span>

        </div>

        <div class="dislikes_div pe-4 my-auto">
            <span class="text-red-600 text-l font-bold"><?php echo $value[8] ?></span>
            <span class="text-white text-l font-bold ms-1">Dislikes</span>
        </div>


        <div class="reposts_div pe-4 my-auto">
            <span class="text-red-600 text-l font-bold">10</span>
            <span class="text-white text-l font-bold ms-1">Reposts</span>
        </div>

        <div class="comments_div pe-4 my-auto">
            <span class="text-red-600 text-l font-bold"><?php echo $value[6] ?></span>
            <span class="text-white text-l font-bold ms-1">Comments</span>
        </div>

        <div class="actions_div flex flex-row ms-auto my-auto">

            <div class="action_like">
                <i class="bi bi-hand-thumbs-up text-xl text-red-600 flex"></i>
                <i class="bi bi-hand-thumbs-up-fill text-xl text-red-600 cursor-pointer like_post liked" data-user="<?php echo $_SESSION["UserID"] ?>" data-id="<?php echo $value[0] ?>"></i>

            </div>

            <div class="action_dislike">
                <i class="bi bi-hand-thumbs-down text-xl text-red-600 flex"></i>
                <i class="bi bi-hand-thumbs-down-fill text-xl text-red-600 cursor-pointer dislike_post" data-user="<?php echo $_SESSION["UserID"] ?>" data-id="<?php echo $value[0] ?>"></i>

            </div>

        </div>

    </div>

</div>