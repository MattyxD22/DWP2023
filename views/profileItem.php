<div class="profile_item flex flex-col w-full aspect-square py-2 px-2" data-id="<?php echo $post["PostID"]; ?>">

    <div class="profileItem_Header mb-auto"></div>
    <div class="profileItem_Content py-2">
        <h2><?php echo htmlspecialchars($title); ?></h2>
        <p><?php echo htmlspecialchars($description); ?></p>
    </div>
    <div class="profileItem_Footer flex flex-row py-2">
        <div class="actions_div flex flex-row my-auto">

            <div class="action_like flex flex-row pe-2">
                <i class="bi bi-hand-thumbs-up text-xl text-red-600 flex"></i>
                <i class="bi bi-hand-thumbs-up-fill text-xl text-red-600 cursor-pointer like_post" data-id="<?php echo $post["PostID"] ?>"></i>
                <span class="mx-2 text-red-600">0</span>
            </div>

            <div class="action_dislike flex flex-row pe-2">
                <i class="bi bi-hand-thumbs-down text-xl text-red-600 flex"></i>
                <i class="bi bi-hand-thumbs-down-fill text-xl text-red-600 cursor-pointer dislike_post" data-id="<?php echo $post["PostID"] ?>"></i>
                <span class="mx-2 text-red-600">0</span>
            </div>
        </div>
        <div class="flex flex-row repost_comment_container px-2" title="repost this comment">
            <i class="bi bi-chat-square-heart not_reposted"></i>
            <i class="bi bi-chat-square-heart-fill reposted"></i>
        </div>
    </div>

</div>


<!-- <div class="w-full bg-red-600 aspect-square">
    <div class="profile-item">
        <h2><?php echo htmlspecialchars($title); ?></h2>
        <p><?php echo htmlspecialchars($description); ?></p>
         more code for displaying the post
</div>
</div> -->