<?php

require("../db/connection.php");
require("mainBG.php");
require("header.php");

?>
<article class="flex justify-center items-center flex-col">
    
    <div class="text-white text-2xl font-bold">Welcome to <span class="text-red-600">Bread</span>Tube, a <span class="text-red-600">rising</span> community.</div>
    <form method="post" action="<?php echo BASE_URL; ?>/controllers/UserController.php?action=login">
    <input readonly hidden name="action" type="text" value="login" style="visibility: hidden; display: none; pointer-events:none;">
        <div class="py-3 flex flex-col">
            <label class="text-red-600 text-xl" for="username">Username or email:</label><br>
            <input class="std_input w-[500px]" type="text" name="username">
        </div>
        <div class="py-3 flex flex-col">
            <label class="text-red-600 text-xl" for="password">Password:</label><br>
            <input class="std_input w-[500px]" type="password" name="password">
        </div>

        <div class="py-3 flex flex-row justify-around">
            <button type="submit" class="std_button text-white font-bold py-2 px-4 rounded">
                <span class="text-red-600">Log </span>
                <span>In</span>
            </button>
        </div>
    </form> 
    <form action="<?php echo BASE_URL; ?>/views/createAccount.php">
                <button type="submit" class="std_button text-white font-bold py-2 px-4 rounded">
                <span class="text-red-600">Create </span>
                <span>Account</span>
            </button>
            </form>
</article>
