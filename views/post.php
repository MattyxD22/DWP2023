<div class="container w-full h-full flex flex-col post_Container px-4 py-4 mx-auto">
    <div class="post_header flex flex-row border-bottom-red pb-2">
        <i class="bi bi-person-circle text-4xl my-auto"></i>
        <span class="ms-3 my-auto font-bold"><?php echo $post["Username"] ?></span>

    </div>

    <div class="post_content flex flex-col py-2">
        <span class="text-red-600 text-2xl font-bold py-2"> <?php echo $post["Title"] ?></span>
        <span class="text-red-600 py-2"> <?php echo $post["Description"] ?> </span>
    </div>

    <div class="post_image_container h-full flex">

        <?php if (!empty($imgs)) { ?>
            <div class="feed_img_container flex flex-row justify-center items-center my-auto mx-auto">
                <img class="h-auto max-w-full" src="data:image/jpeg;base64,<?php echo base64_encode($imgs["ImgData"]); ?>">
            </div>
        <?php } ?>

    </div>

    <div class="post_comments_container flex flex-col px-3 py-3">

        <div class="RTE_comment w-full">

        </div>

        <!-- <textarea id="comment" rows="4" class="w-full std_input comment_textArea" placeholder="Write a comment..."></textarea> -->

        <button type="button" class="std_button submit_comment text-white ms-auto mt-2" data-id="<?php echo $post["PostID"] ?>">
            Post comment
        </button>

        <!-- <form>
            <div class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 postComment_Container">
                <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
                    <label for="comment" class="sr-only">Your comment</label>
                    <textarea id="comment" rows="4" class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400 comment_textArea" placeholder="Write a comment..." required></textarea>
                </div>
                <div class="flex items-center justify-end px-3 py-2 border-t dark:border-gray-600">
                    <button type="button" class="std_button submit_comment text-white" data-id="<?php echo $post["PostID"] ?>">
                        Post comment
                    </button>
                    <div class="flex pl-0 space-x-1 sm:pl-2">
                        <button type="button" class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 20">
                                <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M1 6v8a5 5 0 1 0 10 0V4.5a3.5 3.5 0 1 0-7 0V13a2 2 0 0 0 4 0V6" />
                            </svg>
                            <span class="sr-only">Attach file</span>
                        </button>
                        <button type="button" class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                                <path d="M8 0a7.992 7.992 0 0 0-6.583 12.535 1 1 0 0 0 .12.183l.12.146c.112.145.227.285.326.4l5.245 6.374a1 1 0 0 0 1.545-.003l5.092-6.205c.206-.222.4-.455.578-.7l.127-.155a.934.934 0 0 0 .122-.192A8.001 8.001 0 0 0 8 0Zm0 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                            </svg>
                            <span class="sr-only">Set location</span>
                        </button>
                        <button type="button" class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                                <path d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z" />
                            </svg>
                            <span class="sr-only">Upload image</span>
                        </button>
                    </div>
                </div>
            </div>
        </form> -->
    </div>

    <div class="comment_section flex flex-col">

        <?php getComments($post["PostID"]) ?>
    </div>
</div>


<?php

use models\PostModel;

function getComments($postID)
{
    $postModel = new postModel();
    // $comments = 
    // $view = include("./comments.php");
    $postID = (int) $postID;
    return $postModel->getComments($postID);
}

?>