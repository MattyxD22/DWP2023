<?php

require("../db/connection.php");
require("mainBG.php");

?>
<div class="text-white">Welcome to <span class="text-red-600">Bread</span>Tube, a <span class="text-red-600">rising</span> community.</div>
<form method="post" action="../controllers/UserController.php?action=login">
    <label class="text-red-600" for="username">Username or email:</label><br>
    <input class="std_input" type="text" name="Email">
    <br>
    <label class="text-red-600" for="password">Password:</label><br>
    <input class="std_input" type="password" name="Password">
    <br>
    <button type="submit" class="std_button text-white font-bold py-2 px-4 rounded">
        <span class="text-red-600">Log </span><span>In</span>
    </button>

</form>
