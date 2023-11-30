<?php
require("../controllers/UserController.php");

use controllers\UserController;
// Create an instance of UserController
$userController = new UserController();

// Assuming you have the $userID you want to fetch followers for
// If you don't have a $userID yet, you need to set it to the appropriate value
if (isset($_GET['userid'])) {
    $userID = $_GET['userid'];
} else {
    $userID = $_SESSION['UserID'];
}


// Call the fetchFollowers method
$followerCount = $userController->fetchFollowers($userID);
$followingCount = $userController->fetchFollowing($userID);
$postCount = $userController->fetchPostsAmount($userID);
$username = $userController->fetchUsername($userID);
$userPosts = $userController->fetchPosts($userID);
$userLikes = $userController->fetchLikes($userID);
$userDislikes = $userController->fetchDislikes($userID);
$userComments = $userController->fetchUserComments($userID);
?>

<article class="text-white profile_page">
    <section class="flex w-full justify-around relative border-b border-red-600 border-solid py-10 flex-wrap">
        <div class="flex justify-center items-center gap-8">
            <div class="bg-red-600 rounded-full w-14 h-14"></div>
            <h1><?= htmlspecialchars($username) ?></h1>
        </div>
        <div class="flex flex-row">
            <div class="px-2">
                <h2><?= htmlspecialchars($postCount) ?></h2>
                <p>Posts</p>
            </div>
            <div class="px-2">
                <h2><?= htmlspecialchars($followerCount) ?></h2>
                <p>Followers</p>
            </div>
            <div class="px-2">
                <h2><?= htmlspecialchars($followingCount) ?></h2>
                <p>Following</p>
            </div>
        </div>
        <?php
        if (isset($_GET['userid']) && $_SESSION['UserID'] != $userID) {
        ?>
            <div>
                <button type="button" class="std_button followUnfollowBtn" data-userid="<?php echo $userID ?>">
                    <span class="createPost_Span text-2xl font-bold text-red-600">Follow</span>
                </button>
            </div>
        <?php
        } else {
        ?>
            <button type="button" class="std_button opacity-0">
                <span class="createPost_Span text-2xl font-bold text-red-600">Follow</span>
            </button>
            </div>
        <?php
        }
        ?>

    </section>
    <section>
        <?php // var_dump($userPosts); // Uncomment for debugging purposes 
        ?>

        <div class="flex flex-col">

            <div class="profile_tab_container px-1 pt-2 flex flex-row w-full justify-between">

                <div class="tab_elem selected" data-type="1">
                    <!-- <span class="tab_first_text me-2">Your</span> -->
                    <span>Posts</span>
                </div>

                <div class="tab_elem" data-type="2">
                    <!-- <span class="tab_first_text me-2">Your</span> -->
                    <span>Likes</span>
                </div>

                <div class="tab_elem" data-type="3">
                    <!-- <span class="tab_first_text me-2">Your</span> -->
                    <span>Dislikes</span>
                </div>

                <div class="tab_elem" data-type="4">
                    <!-- <span class="tab_first_text me-2">Your</span> -->
                    <span>Comments</span>
                </div>

                <div class="tab_elem" data-type="5">
                    <!-- <span class="tab_first_text me-2">Your</span> -->
                    <span>Reposts</span>
                </div>

                <div class="tab_elem" data-type="6">
                    <!-- <span class="tab_first_text me-2">Your</span> -->
                    <span>Following</span>
                </div>


            </div>

            <div class="profile_content selected" data-type="1">

                <div class="grid grid-cols-3 gap-4 p-8 ">

                    <?php
                    foreach ($userPosts as $post) {
                        // Set variables with the information from the current post
                        $title = $post['Title']; // Assuming 'Title' is the correct key
                        $description = $post['Description']; // And so on for other variables
                        $img = ""; //$post["ImgData"];
                        $postID = $post["PostID"];

                        // Now include the profileItem.php file, which will use the variables above
                        include('./profileItem.php');
                    }
                    ?>
                </div>
            </div>

            <div class="profile_content" data-type="2">
                <div class="grid grid-cols-3 gap-4 p-8 ">

                    <?php
                    foreach ($userLikes as $key => $like) {
                        // Set variables with the information from the current post
                        $title = $like['Title']; // Assuming 'Title' is the correct key
                        $description = $like['Description']; // And so on for other variables
                        $img = $like["ImgData"];
                        $postID = $like["PostID"];

                        // Now include the profileItem.php file, which will use the variables above
                        include('./profileItem.php');
                    }

                    ?>
                </div>
            </div>

            <div class="profile_content" data-type="3">
                <div class="grid grid-cols-3 gap-4 p-8 ">

                    <?php
                    foreach ($userDislikes as $key => $dislike) {
                        // Set variables with the information from the current post
                        $title = $dislike['Title']; // Assuming 'Title' is the correct key
                        $description = $dislike['Description']; // And so on for other variables
                        $img = $dislike["ImgData"];
                        $postID = $dislike["PostID"];

                        // Now include the profileItem.php file, which will use the variables above
                        include('./profileItem.php');
                    }

                    ?>
                </div>
            </div>

            <div class="profile_content" data-type="4">
                <div class="grid grid-cols-1 gap-4 p-8 ">

                    <?php
                    foreach ($userComments as $key => $comment) {
                        // Set variables with the information from the current post
                        $title = ""; //$comment['Title']; // Assuming 'Title' is the correct key
                        $description = $comment['Description']; // And so on for other variables
                        //$img = $comment["ImgData"];

                        $postID = $comment["PostID"];

                        // Now include the profileItem.php file, which will use the variables above
                        include('./profileComments.php');
                    }

                    ?>
                </div>
            </div>

            <div class="profile_content" data-type="5">

            </div>

            <div class="profile_content" data-type="6">

            </div>

        </div>


    </section>
</article>