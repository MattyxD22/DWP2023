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
?>

<article class="text-white">
    <section class="flex w-full justify-around relative border-b border-red-600 border-solid py-10 ">
        <div class="flex justify-center items-center gap-8">
            <div class="bg-red-600 rounded-full w-14 h-14"></div>
            <h1><?= htmlspecialchars($username) ?></h1>
        </div>
        <div>
            <h2><?= htmlspecialchars($postCount) ?></h2>
            <p>Posts</p>
        </div>
        <div>
            <h2><?= htmlspecialchars($followerCount) ?></h2>
            <p>Followers</p>
        </div>
        <div>
            <h2><?= htmlspecialchars($followingCount) ?></h2>
            <p>Following</p>
        </div>
        <?php 
            if (isset($_GET['userid']) && $_SESSION['UserID'] != $userID) {
        ?>
        <div>
            <button type="button" class="std_button followUnfollowBtn">
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
    <?php // var_dump($userPosts); // Uncomment for debugging purposes ?>
    <div class="grid grid-cols-3 gap-4 p-8">
        <?php
        foreach ($userPosts as $post) {
            // Set variables with the information from the current post
            $title = $post['Title']; // Assuming 'Title' is the correct key
            $description = $post['Description']; // And so on for other variables
            
            // Now include the profileItem.php file, which will use the variables above
            include('./profileItem.php');
        }
        ?>
    </div>
</section>
</article>
