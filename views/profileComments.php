<div class="flex flex-col mb-2 profile_comment">

    <!-- <div class="py-1 px-2">
        <span><?php echo $comment["Title"] ?></span>
    </div> -->

    <div class="p-2 overflow-hidden">
        <pre class="comment_description" title="<?php echo base64_decode($comment["Description"]) ?>"><?php echo base64_decode($comment["Description"]) ?></pre>
    </div>

</div>