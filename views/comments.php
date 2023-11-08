<?php if (!empty($comments)) { ?>

    <?php foreach ($comments as $key => $comment) { ?>

        <div class="flex flex-col comment_container">
            <span> <?php echo $comment[0] ?></span>

        </div>


    <?php } ?>

<?php } ?>