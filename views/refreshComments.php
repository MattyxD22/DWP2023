<div class="comment_section flex flex-col">

    <?php getComments($orgID) ?>
</div>

<?php

use models\PostModel;

function getComments($postID)
{
    $postModel = new postModel();
    // $comments = 
    // $view = include("./comments.php");
    return $postModel->getComments($postID);
}

?>