<?php

require("../db/connection.php");
require("mainBG.php");

?>
<article class="flex justify-center items-center flex-col">
    <div class="text-white text-2xl font-bold">Welcome to <span class="text-red-600">Bread</span>Tube, a <span class="text-red-600">rising</span> community.</div>
    <form>
        <div class="py-3 flex flex-col">
            <label class="text-red-600 text-xl" for="username">Username or email:</label><br>
            <input class="std_input w-[500px]" type="text" name="username">
        </div>
        <div class="py-3 flex flex-col">
            <label class="text-red-600 text-xl" for="password">Password:</label><br>
            <input class="std_input w-[500px]" type="password" name="password">
        </div>
        <div class="py-3 flex flex-col">
            <button type="submit" class="std_button text-white font-bold py-2 px-4 rounded">
                <span class="text-red-600">Log </span><span>In</span>
            </button>
        </div>
    </form> 
</article>