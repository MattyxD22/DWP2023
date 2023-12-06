<div class="container w-full h-full flex flex-col post_Container px-4 py-4 mx-auto">
    <div class="post_header flex flex-row border-bottom-red pb-2">
        <i class="bi bi-person-circle text-4xl my-auto"></i>
        <span class="ms-3 my-auto font-bold"><?php echo $post["Username"] ?></span>


        <?php
        if ($post["CreatedBy"] == $_SESSION["UserID"]) {


        ?>
            <div class="edit_post_container relative ms-auto my-auto clickable">
                <i class="bi bi-three-dots ellipsis"></i>
                <div class="dropdown">

                    <span class="text-red-600 text-xl font-bold py-1 dropdown_item_post edit_post clickable">Edit Post</span>

                    <?php

                    if ($post["Hidden"] == 1) {



                    ?>

                        <span class="text-red-600 text-xl font-bold py-1 dropdown_item_post unhide_post clickable" data-post="<?php echo $post["PostID"] ?>">Unhide Post</span>
                    <?php  } else { ?>


                        <span class="text-red-600 text-xl font-bold py-1 dropdown_item_post hide_post clickable" data-post="<?php echo $post["PostID"] ?>">Hide Post</span>

                    <?php } ?>

                    <span class="text-red-600 text-xl font-bold py-1 dropdown_item_post delete_post clickable" data-post="<?php echo $post["PostID"] ?>">Delete Post</span>


                </div>
            </div>
        <?php  } else if ($post["CreatedBy"] != $_SESSION["UserID"] &&  $_SESSION["isAdmin"] == true) { ?>

            <div class="edit_post_container relative ms-auto my-auto clickable">
                <i class="bi bi-three-dots ellipsis"></i>
                <div class="dropdown">
                    <span class="text-red-600 text-xl font-bold py-1 dropdown_item_post edit_post clickable">Edit Post</span>
                    <span class="text-red-600 text-xl font-bold py-1 dropdown_item_post delete_post clickable" data-post="<?php echo $post["PostID"] ?>">Delete Post</span>
                </div>


            </div>

        <?php  } ?>




    </div>

    <div class="post_content flex flex-col py-2 h-full">
        <span class="text-red-600 text-2xl font-bold py-2 post_title_span"> <?php echo $post["Title"] ?></span>
        <input type="text" class="std_input edit_post_title hide my-1" value="<?php echo $post["Title"] ?>" />

        <pre class="text-red-600 py-2 post_description_span"><?php echo base64_decode($post["Description"]) ?></pre>

        <div class="edit_post_rte hide my-1">
            <?php echo base64_decode($post["Description"]) ?>
        </div>

        <!-- <textarea class="std_input edit_post_description h-full  hide my-1"><?php echo base64_decode($post["Description"]) ?></textarea> -->
        <button type="button" class="std_button btn_update_post my-1 ms-auto hide" data-post="<?php echo $post["PostID"] ?>"><span class="text-white text-lg">Update Post</span></button>
    </div>

    <div class="post_image_container h-full flex">

        <?php if (!empty($imgs)) { ?>



            <div class="feed_img_container flex flex-row justify-center items-center my-auto w-full">

                <div class="dialogContainer flex flex-col my-auto h-full w-full overflow-hidden">

                    <div class="dialogContainer_image pb-5 w-full flex flex-row h-full overflow-hidden">
                        <button class="direction_scroll" data-direction="back" type="button" data-te-target="#carouselExampleCrossfade" data-te-slide="prev">
                            <span class="inline-block h-8 w-8">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                </svg>
                            </span>
                            <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Previous</span>
                        </button>

                        <div class="dialogContainer_image flex flex-row justify-center mx-auto" style="max-height: 500px; min-height: 500px;">
                            <?php
                            $counter = 1;
                            foreach ($imgs as $key => $img) {

                                if ($counter == 1) { ?>
                                    <img class="object-contain h-full modalImg active" data-img="<?php echo $counter ?>" src="data:image/jpeg;base64,<?php echo base64_encode($img["ImgData"]); ?>">

                                <?php
                                } else if ($counter > 1) {
                                ?>
                                    <img class="object-contain h-full modalImg" data-img="<?php echo $counter ?>" src="data:image/jpeg;base64,<?php echo base64_encode($img["ImgData"]); ?>">
                                <?php
                                }
                                $counter++; ?>
                            <?php } ?>
                        </div>
                        <button class="direction_scroll" data-direction="forward" type="button" data-te-target="#carouselExampleCrossfade" data-te-slide="next">
                            <span class="inline-block h-8 w-8">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </span>
                            <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Next</span>
                        </button>
                    </div>
                    <div class="flex flex-row relative">
                        <!--Carousel indicators -->
                        <div class="absolute inset-x-0 bottom-0 z-[2] flex list-none justify-center p-0" data-te-carousel-indicators>

                            <?php
                            $x = 1;
                            while ($x < $counter) {

                                if ($x == 1) {
                            ?>
                                    <button type="button" class="imgIndicator active mx-1" data-img="<?php echo $x ?>"><i class="bi bi-circle-fill"></i></button>
                                <?php } else {
                                ?>
                                    <button type="button" class="imgIndicator mx-1" data-img="<?php echo $x ?>"><i class="bi bi-circle-fill"></i></button>
                            <?php
                                }
                                $x++;
                            }

                            ?>
                        </div>
                    </div>

                </div>
                <!-- <img class="h-auto max-w-full" src="data:image/jpeg;base64,<?php echo base64_encode($imgs["ImgData"]); ?>"> -->
            </div>
        <?php } ?>

    </div>

    <div class="post_comments_container flex flex-col px-3 py-3">

        <div class="RTE_comment w-full">

        </div>

        <!-- <textarea id="comment" rows="4" class="w-full std_input comment_textArea" placeholder="Write a comment..."></textarea> -->

        <div class="flex flex-row">
            <div class="likes_div pe-4 my-auto">

                <span class="text-red-600 text-l font-bold likes_amount"><?php echo $post["Likes"]; ?></span>
                <span class="text-white text-l font-bold ms-1">Likes</span>

            </div>

            <div class="dislikes_div pe-4 my-auto">
                <span class="text-red-600 text-l font-bold dislikes_amount"><?php echo $post["Dislikes"]; ?></span>
                <span class="text-white text-l font-bold ms-1">Dislikes</span>
            </div>


            <div class="reposts_div pe-4 my-auto">
                <span class="text-red-600 text-l font-bold repost_amount"><?php echo $post["Reposts"]; ?></span>
                <span class="text-white text-l font-bold ms-1">Reposts</span>
            </div>


            <div class="comments_div pe-4 my-auto">
                <span class="text-red-600 text-l font-bold"><?php echo $commentsSize; ?></span>
                <span class="text-white text-l font-bold ms-1">Comments</span>
            </div>

            <div class="actions_div flex flex-row ms-1 my-auto">

                <div>
                    <i class="bi bi-arrow-down-up text-xl text-red-600 flex repost_post cursor-pointer mx-1" data-user="<?php echo $_SESSION["UserID"] ?>" data-id="<?php echo $post["PostID"] ?>"></i>
                </div>

                <div class="action_like mx-1 <?php echo $post["UserLike"] == 1 ? 'like' : ''; ?>">
                    <i class=" bi bi-hand-thumbs-up text-xl text-red-600 flex like_post"></i>
                    <i class="bi bi-hand-thumbs-up-fill text-xl text-red-600 cursor-pointer like_post" data-user="<?php echo $_SESSION["UserID"] ?>" data-id="<?php echo $post["PostID"] ?>"></i>

                </div>

                <div class="action_dislike mx-1 <?php echo $post["UserDislike"] == 1 ? 'dislike' : ''; ?>">
                    <i class="bi bi-hand-thumbs-down text-xl text-red-600 flex dislike_post"></i>
                    <i class="bi bi-hand-thumbs-down-fill text-xl text-red-600 cursor-pointer dislike_post" data-user="<?php echo $_SESSION["UserID"] ?>" data-id="<?php echo $post["PostID"] ?>"></i>

                </div>

            </div>

            <button type="button" class="std_button submit_comment text-white ms-auto mt-2" data-id="<?php echo $post["PostID"] ?>">
                Post comment
            </button>
        </div>


    </div>

    <div class="comment_section flex flex-col">

        <?php getComments($post["PostID"]) ?>
    </div>
</div>


<?php

use models\PostModel;

function getComments($postID)
{
    $postModel = PostModel::getPostModel();
    // $comments = 
    // $view = include("./comments.php");
    $postID = (int) $postID;
    return $postModel->getComments($postID);
}

?>