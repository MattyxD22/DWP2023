<?php if (!empty($comments)) {
    $tempID = 0;

?>
    <?php foreach ($comments as $key => $comment) {

        $indent = 0;
    ?>
        <?php if ($comment["ParentID"] == $postID) {
            $tempID = $comment["PostID"];
        ?>
            <div class="comment_container flex flex-col">

                <div class="comment_headerr flex flex-row pb-2">

                    <i class="bi bi-person-circle text-4xl my-auto"></i>
                    <span class="ms-3 my-auto font-bold"><?php echo $comment["Username"] ?></span>
                </div>
                <div class="comment_content pb-4">

                    <!-- Keep content of "pre" on the same line, to keep it consistent -->
                    <pre class="comment_span"><?php echo base64_decode($comment["Description"]) ?></pre>

                </div>
                <div class="comment_footer flex flex-row py-2">

                    <div class="actions_div flex flex-row my-auto">

                        <div class="action_like flex flex-row pe-2">
                            <i class="bi bi-hand-thumbs-up text-xl text-red-600 flex"></i>
                            <i class="bi bi-hand-thumbs-up-fill text-xl text-red-600 cursor-pointer like_post" data-id="<?php echo $comment["PostID"] ?>"></i>
                            <span class="mx-2 text-red-600"><?php echo $comment["Dislikes"] ?></span>
                        </div>

                        <div class="action_dislike flex flex-row pe-2">
                            <i class="bi bi-hand-thumbs-down text-xl text-red-600 flex"></i>
                            <i class="bi bi-hand-thumbs-down-fill text-xl text-red-600 cursor-pointer dislike_post" data-id="<?php echo $comment["PostID"] ?>"></i>
                            <span class="mx-2 text-red-600"><?php echo $comment["Dislikes"] ?></span>
                        </div>
                    </div>

                    <div class="flex flex-row relative reply_comment_container cursor-pointer">
                        <span class="text-red-600">Comment</span>
                        <div class="reply_to_comment_container cursor-default absolute flex-col px-2 py-2">
                            <div class="reply_popup_header flex justify-end px-1 py-1">
                                <div class="close_popup flex flex-row cursor-pointer">
                                    <i class="bi bi-x-square"></i>
                                    <i class="bi bi-x-square-fill"></i>
                                </div>
                            </div>

                            <div class="reply_popup_content py-1 px-1 flex flex-row">
                                <textarea class="std_input w-[100%]" placeholder="Your reply Here"></textarea>
                            </div>

                            <div class="reply_popup_footer py-1 px-1 flex flex-row justify-end">
                                <button type="button" class="std_button submit_reply text-white" data-id="<?php echo $comment["PostID"] ?>">
                                    Post Reply
                                </button>
                            </div>


                        </div>
                    </div>

                    <div class="flex flex-row repost_comment_container px-2" title="repost this comment">
                        <i class="bi bi-chat-square-heart not_reposted"></i>
                        <i class="bi bi-chat-square-heart-fill reposted"></i>
                    </div>

                </div>
            </div>
        <?php } elseif ($comment["ParentID"] == $tempID) {
            $tempID = $comment["PostID"];
        ?>
            <!-- <div class="comment_container flex flex-col">

                <div class="comment_headerr flex flex-row pb-2">

                    <i class="bi bi-person-circle text-4xl my-auto"></i>
                    <span class="ms-3 my-auto font-bold"><?php echo $comment["Username"] ?></span>
                </div>
                <div class="comment_content pb-4">

                    <span class="comment_span">
                        <?php echo $comment["Description"] ?>
                    </span>

                </div>
                <div class="comment_footer flex flex-row py-2">

                    <div class="actions_div flex flex-row my-auto">

                        <div class="action_like flex flex-row pe-2">
                            <i class="bi bi-hand-thumbs-up text-xl text-red-600 flex"></i>
                            <i class="bi bi-hand-thumbs-up-fill text-xl text-red-600 cursor-pointer like_post" data-id="<?php echo $comment["PostID"] ?>"></i>
                            <span class="mx-2 text-red-600"><?php echo $comment["Dislikes"] ?></span>
                        </div>

                        <div class="action_dislike flex flex-row pe-2">
                            <i class="bi bi-hand-thumbs-down text-xl text-red-600 flex"></i>
                            <i class="bi bi-hand-thumbs-down-fill text-xl text-red-600 cursor-pointer dislike_post" data-id="<?php echo $comment["PostID"] ?>"></i>
                            <span class="mx-2 text-red-600"><?php echo $comment["Dislikes"] ?></span>
                        </div>
                    </div>

                    <div class="flex flex-row relative reply_comment_container cursor-pointer">
                        <span class="text-red-600">Comment</span>
                        <div class="reply_to_comment_container cursor-default absolute flex-col px-2 py-2">
                            <div class="reply_popup_header flex justify-end px-1 py-1">
                                <div class="close_popup flex flex-row cursor-pointer">
                                    <i class="bi bi-x-square"></i>
                                    <i class="bi bi-x-square-fill"></i>
                                </div>
                            </div>

                            <div class="reply_popup_content py-1 px-1 flex flex-row">
                                <textarea class="std_input w-[100%]" placeholder="Your reply Here"></textarea>
                            </div>

                            <div class="reply_popup_footer py-1 px-1 flex flex-row justify-end">
                                <button type="button" class="std_button submit_reply text-white" data-id="<?php echo $comment["PostID"] ?>">
                                    Post Reply
                                </button>
                            </div>


                        </div>
                    </div>

                    <div class="flex flex-row repost_comment_container px-2" title="repost this comment">
                        <i class="bi bi-chat-square-heart not_reposted"></i>
                        <i class="bi bi-chat-square-heart-fill reposted"></i>
                    </div>

                </div>
            </div> -->
        <?php } ?>



    <?php   } ?>

<?php   } ?>
<!-- 
<div class="comment_container flex flex-col">

    <div class="comment_headerr flex flex-row pb-2">

        <i class="bi bi-person-circle text-4xl my-auto"></i>
        <span class="ms-3 my-auto font-bold">Username test text</span>
    </div>
    <div class="comment_content">

        <span class="comment_span">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent hendrerit sapien non odio molestie, ut mollis lorem dapibus. Aenean at sem elit. Curabitur lectus quam, tristique egestas urna in, pharetra dictum tellus. Sed volutpat eros nulla, a viverra nunc laoreet non. Nullam enim arcu, viverra hendrerit consequat ut, ornare non turpis. Cras tincidunt eros ut ipsum bibendum, vitae dapibus erat rhoncus. Donec ac massa leo. Aenean imperdiet eu quam a ornare.
        </span>

    </div>
    <div class="comment_footer">

        <div class="actions_div flex flex-row ms-auto my-auto">

            <div class="action_like">
                <i class="bi bi-hand-thumbs-up text-xl text-red-600 flex"></i>
                <i class="bi bi-hand-thumbs-up-fill text-xl text-red-600 cursor-pointer" data-id=""></i>
            </div>

            <div class="action_dislike">
                <i class="bi bi-hand-thumbs-down text-xl text-red-600 flex"></i>
                <i class="bi bi-hand-thumbs-down-fill text-xl text-red-600 cursor-pointer" data-id=""></i>

            </div>
        </div>

    </div>
</div> -->