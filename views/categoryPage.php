<div class="w-full h-full flex flex-col category_mainContainer">

    <?php if (isset($results) && !empty($results)) { ?>
        <?php foreach ($results as $key => $value) {

            $title = $value["Title"];

        ?>
            <div class="categoryRow_categoryPage flex flex-col py-3">

                <div class="categoryHeader pb-3 sticky left-0">
                    <label class="text-red-600">
                        <?php echo $title ?>
                    </label>
                </div>

                <div class="categoryContent flex flex-row h-full">

                    <?php

                    foreach ($posts as $key => $post) {
                        //$arr = json_decode($post, true);
                        if ($post->CategoryID == $value["CategoryID"] && $post->PostID != null) {

                    ?>

                            <div class="imageContainer category_item flex flex-col px-2 py-2 mx-2 h-full" data-id="<?php echo $post->PostID ?>">
                                <div class="imagePlaceholder">
                                    <?php if ($post->ImgData != null) { ?>
                                        <img class="h-auto max-w-full mx-auto my-auto" src="data:image/jpeg;base64,<?php echo base64_encode($post["ImgData"]); ?>">
                                    <?php } ?>
                                </div>
                                <div class="imageContext flex flex-col">
                                    <div class="category_item_header py-2">
                                        <span class="flex text-red-600 flex-row font-bold  h-[3.5rem]"><?php echo $post->Title ?> </span>

                                    </div>
                                    <!-- <div class="category_item_content"></div> -->
                                    <div class="category_item_footer flex flex-row">
                                        <div class="actions_div flex flex-row my-auto">

                                            <div class="action_like flex flex-row pe-2 <?php echo $post->UserLike == 1 ? 'like' : ''; ?>">
                                                <i class="bi bi-hand-thumbs-up text-xl text-red-600 flex"></i>
                                                <i class="bi bi-hand-thumbs-up-fill text-xl text-red-600 cursor-pointer like_post" data-id="<?php echo $post->PostID ?>"></i>
                                                <span class="mx-2 text-red-600 likes_amount"><?php echo $post->Likes ?></span>
                                            </div>

                                            <div class="action_dislike flex flex-row pe-2 <?php echo $post->UserDislike == 1 ? 'dislike' : ''; ?>">
                                                <i class="bi bi-hand-thumbs-down text-xl text-red-600 flex"></i>
                                                <i class="bi bi-hand-thumbs-down-fill text-xl text-red-600 cursor-pointer dislike_post" data-id="<?php echo $post->PostID ?>"></i>
                                                <span class="mx-2 text-red-600 dislikes_amount"><?php echo $post->Dislikes ?></span>
                                            </div>
                                        </div>
                                        <!-- <div class="flex flex-row repost_comment_container px-2" title="repost this comment">
                                            <i class="bi bi-chat-square-heart not_reposted"></i>
                                            <i class="bi bi-chat-square-heart-fill reposted"></i>
                                        </div> -->
                                    </div>

                                </div>
                            </div>
                    <?php }
                    } ?>

                </div>
            </div>
    <?php }
    } ?>

    <div class="categoryRow_categoryPage flex flex-col py-3">

        <div class="categoryHeader pb-3 sticky left-0">
            <label class="text-red-600">
                Uncategorized
            </label>
        </div>

        <div class="categoryContent flex flex-row h-full">

            <?php
            foreach ($resultsUncatorized as $key => $post) { ?>
                <div class="imageContainer category_item flex flex-col px-2 py-2 mx-2 h-full" data-id="<?php echo $post["PostID"] ?>">
                    <div class="imagePlaceholder flex">

                        <?php if ($post["ImgData"] != null) { ?>
                            <img class="h-auto max-w-full mx-auto my-auto" src="data:image/jpeg;base64,<?php echo base64_encode($post["ImgData"]); ?>">
                        <?php } ?>



                    </div>
                    <div class="imageContext flex flex-col">
                        <div class="category_item_header py-2">
                            <span class="flex text-red-600 flex-row font-bold h-[3.5rem]"><?php echo $post["Title"] ?> </span>

                        </div>
                        <!-- <div class="category_item_content"></div> -->
                        <div class="category_item_footer flex flex-row">
                            <div class="actions_div flex flex-row my-auto">

                                <div class="action_like flex flex-row pe-2 <?php echo $post->UserLike == 1 ? 'like' : ''; ?>">
                                    <i class="bi bi-hand-thumbs-up text-xl text-red-600 flex like_post"></i>
                                    <i class="bi bi-hand-thumbs-up-fill text-xl text-red-600 cursor-pointer like_post" data-id="<?php echo $post["PostID"] ?>"></i>
                                    <span class="mx-2 text-red-600 likes_amount"><?php echo $post["Likes"] ?></span>
                                </div>

                                <div class="action_dislike flex flex-row pe-2 <?php echo $post->UserDislike == 1 ? 'dislike' : ''; ?>">
                                    <i class="bi bi-hand-thumbs-down text-xl text-red-600 flex dislike_post"></i>
                                    <i class="bi bi-hand-thumbs-down-fill text-xl text-red-600 cursor-pointer dislike_post" data-id="<?php echo $post["PostID"] ?>"></i>
                                    <span class="mx-2 text-red-600 dislikes_amount"><?php echo $post["Dislikes"] ?></span>
                                </div>
                            </div>
                            <!-- <div class="flex flex-row repost_comment_container px-2" title="repost this comment">
                                <i class="bi bi-chat-square-heart not_reposted"></i>
                                <i class="bi bi-chat-square-heart-fill reposted"></i>
                            </div> -->
                        </div>

                    </div>
                </div>
            <?php } ?>

        </div>
    </div>

</div>