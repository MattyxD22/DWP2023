<div class="profile_item flex flex-col w-full aspect-square py-2 px-2" data-id="<?php echo $postID; ?>">

    <div class="profileItem_Header mb-auto">
        <div class="profileItem_image_container h-full overflow-hidden flex">

            <div class="profileItem_img_container  h-full flex flex-row justify-center items-center my-auto mx-auto">
                <?php if (!empty($img)) { ?>

                    <img class="object-contain h-full" src="data:image/jpeg;base64,<?php echo base64_encode($img); ?>">

                <?php } ?>
            </div>

        </div>
    </div>
    <div class="profileItem_Content py-2">
        <h2><?php echo htmlspecialchars($title); ?></h2>
        <pre><?php echo base64_decode(htmlspecialchars($description)) ?></pre>
    </div>
    <div class="profileItem_Footer flex flex-row py-2">
        <div class="actions_div post_actions flex flex-row my-auto">

            <div class="flex flex-row pe-2">
                <i class="bi bi-arrow-down-up text-xl text-red-600 flex repost_post cursor-pointer" data-id="<?php echo $postID ?>"></i>
                <span class="mx-2 text-red-600 <?php echo $userReposted == 1 ? 'underline' : ''; ?>"><?php echo $repostAmount; ?></span>
            </div>

            <div class="action_like flex flex-row pe-2 <?php echo $userLike == 1 ? 'like' : ''; ?>">
                <i class="bi bi-hand-thumbs-up text-xl text-red-600 flex like_post" data-id="<?php echo $postID ?>"></i>
                <i class="bi bi-hand-thumbs-up-fill text-xl text-red-600 cursor-pointer like_post" data-id="<?php echo $postID ?>"></i>
                <span class="mx-2 text-red-600 likes_amount " data-amount="<?php echo $likesAmount; ?>"><?php echo $likesAmount; ?></span>
            </div>

            <div class="action_dislike flex flex-row pe-2  <?php echo $userDislike == 1 ? 'dislike' : ''; ?>">
                <i class="bi bi-hand-thumbs-down text-xl text-red-600 flex dislike_post" data-id="<?php echo $postID ?>"></i>
                <i class="bi bi-hand-thumbs-down-fill text-xl text-red-600 cursor-pointer dislike_post" data-id="<?php echo $postID ?>"></i>
                <span class="mx-2 text-red-600 dislikes_amount" data-amount="<?php echo $dislikesAmount; ?>"><?php echo $dislikesAmount; ?></span>
            </div>
        </div>
        <!-- <div class="flex flex-row repost_comment_container px-2" title="repost this comment">
            <i class="bi bi-chat-square-heart not_reposted"></i>
            <i class="bi bi-chat-square-heart-fill reposted"></i>
        </div> -->
    </div>

</div>


<!-- <div class="w-full bg-red-600 aspect-square">
    <div class="profile-item">
        <h2><?php echo htmlspecialchars($title); ?></h2>
        <p><?php echo htmlspecialchars($description); ?></p>
         more code for displaying the post
</div>
</div> -->