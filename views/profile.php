<?php 
require("../controllers/UserController.php");

use controllers\UserController;
// Create an instance of UserController
$userController = new UserController();

// Assuming you have the $userID you want to fetch followers for
// If you don't have a $userID yet, you need to set it to the appropriate value
$userID = $_SESSION['UserID'];

// Call the fetchFollowers method
$followerCount = $userController->fetchFollowers($userID);
$followingCount = $userController->fetchFollowing($userID);
$postCount = $userController->fetchPostsAmount($userID);
?>

<article class="text-white">
    <section class="flex w-full justify-around relative border-b border-red-600 border-solid py-10 ">
        <div class="flex justify-center items-center gap-8">
            <div class="bg-red-600 rounded-full w-14 h-14"></div>
            <h1>Username</h1>
        </div>
        <div>
            <h2><?= htmlspecialchars($postCount) ?></h2>
            <p>Posts</p>
        </div>
        <div>
            <h2 id="followerCount"><?= htmlspecialchars($followerCount) ?></h2>
            <p>Followers</p>
        </div>
        <div>
            <h2><?= htmlspecialchars($followingCount) ?></h2>
            <p>Following</p>
        </div>
    </section>
    
</article>
