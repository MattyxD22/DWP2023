<?php foreach ($results as $key => $post) { ?>

    <div class="feed_item" data-id="<?php echo $post["PostID"] ?>">

        <div class="feed_header h-1/6 align-center cursor-pointer open_profile_event" data-userid="<?php echo $post['UserID'] ?>">
            <i class="bi bi-person-circle text-4xl"></i>
            <span class="ms-3 font-bold"><?php echo $post["Username"] ?></span>
        </div>
        <div class="feed_content h-4/6 flex flex-col">
            <div class="feed_title_container py-2 px-2">
                <span class="text-red-600 text-2xl font-bold"><?php echo $post["Title"] ?></span>
            </div>

            <div class="feed_title_container py-2 px-2">
                <pre class="text-red-600"><?php echo base64_decode($post["Description"]) ?></pre>
            </div>

            <div class="feed_image_container h-full overflow-hidden flex">

                <?php if (sizeof($post["Images"])) {

                    //print_r($post["Images"][0]);

                ?>



                    <div class="feed_img_container  h-full flex flex-row justify-center items-center my-auto mx-auto">
                        <img class="object-contain h-full" src="data:image/jpeg;base64,<?php echo base64_encode($post["Images"][0]["ImgData"]); ?>">
                    </div>
                    <dialog class="imgDialog my-auto overflow-hidden">

                        <div class="dialogContainer flex flex-col my-auto h-full overflow-hidden">

                            <div class="dialogContainer_image flex flex-row h-full overflow-hidden">
                                <button class="direction_scroll" data-direction="back" type="button" data-te-target="#carouselExampleCrossfade" data-te-slide="prev">
                                    <span class="inline-block h-8 w-8">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                        </svg>
                                    </span>
                                    <span class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]">Previous</span>
                                </button>
                                <div class="dialogContainer_image flex flex-row w-full justify-center">



                                    <?php


                                    $counter = 1;
                                    //print_r($imgArray[$postID]);

                                    foreach ($post["Images"] as $key => $img) {


                                        //print_r($img);


                                        if ($counter == 1) {
                                    ?> <img class="object-contain h-full modalImg active" data-img="<?php echo $counter ?>" src="data:image/jpeg;base64,<?php echo base64_encode($img["ImgData"]); ?>">
                                        <?php
                                        } else {
                                        ?> <img class="object-contain h-full modalImg" data-img="<?php echo $counter ?>" src="data:image/jpeg;base64,<?php echo base64_encode($img["ImgData"]); ?>">
                                        <?php
                                        }
                                        $counter++;
                                        ?>
                                    <?php
                                        // }
                                    }

                                    ?>
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
                            <div class="flex flex-row">
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

                    </dialog>
                <?php } ?>

            </div>

        </div>


        <div class="feed_footer h-1/6 pt-2">

            <div class="likes_div pe-4 my-auto">

                <span class="text-red-600 text-l font-bold likes_amount <?php echo $post["UserLike"] == 1 ? 'underline' : ''; ?>"><?php echo $post["Likes"]; ?></span>
                <span class="text-white text-l font-bold ms-1">Likes</span>

            </div>

            <div class="dislikes_div pe-4 my-auto">
                <span class="text-red-600 text-l font-bold dislikes_amount <?php echo $post["UserDislike"] == 1 ? 'underline' : ''; ?>"><?php echo $post["Dislikes"]; ?></span>
                <span class="text-white text-l font-bold ms-1">Dislikes</span>
            </div>


            <div class="reposts_div pe-4 my-auto">
                <span class="text-red-600 text-l font-bold <?php echo $post["UserReposted"] == 1 ? 'underline' : ''; ?>"><?php echo $post["Reposts"]; ?></span>
                <span class="text-white text-l font-bold ms-1">Reposts</span>
            </div>

            <div class="comments_div pe-4 my-auto">
                <span class="text-red-600 text-l font-bold"><?php echo $post["Comments"] ?></span>
                <span class="text-white text-l font-bold ms-1">Comments</span>
            </div>

            <div class="actions_div flex flex-row ms-auto my-auto">

                <div>
                    <i class="bi bi-arrow-down-up text-xl text-red-600 flex repost_post cursor-pointer mx-1" data-user="<?php echo $_SESSION["UserID"] ?>" data-id="<?php echo $post["PostID"] ?>"></i>
                </div>

                <div class="action_like mx-1 <?php echo $post["UserLike"] == 1 ? 'like' : ''; ?>">
                    <i class=" bi bi-hand-thumbs-up text-xl text-red-600 flex like_post"></i>
                    <i class="bi bi-hand-thumbs-up-fill text-xl text-red-600 cursor-pointer like_post liked" data-user="<?php echo $_SESSION["UserID"] ?>" data-id="<?php echo $post["PostID"] ?>"></i>

                </div>

                <div class="action_dislike mx-1 <?php echo $post["UserDislike"] == 1 ? 'dislike' : ''; ?>">
                    <i class="bi bi-hand-thumbs-down text-xl text-red-600 flex dislike_post"></i>
                    <i class="bi bi-hand-thumbs-down-fill text-xl text-red-600 cursor-pointer dislike_post" data-user="<?php echo $_SESSION["UserID"] ?>" data-id="<?php echo $post["PostID"] ?>"></i>

                </div>

            </div>

        </div>

    </div>
    <!-- //include('./feedItem.php'); -->
<?php } ?>