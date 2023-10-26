<?php

require("../db/connection.php");
require("mainBG.php");

?>
<div class="text-white">Welcome to <span class="text-red-600">Bread</span>Tube, a <span class="text-red-600">rising</span> community.</div>
<form method="post" action="../controllers/UserController.php?action=login">

    <!--    since there was made changes to the controller, post requests require a "action" parameter,
            the parameter is not retrieved in the form, so below is a hackish solution                  -->
    <input readonly hidden name="action" type="text" value="login" style="visibility: hidden; display: none; pointer-events:none;">

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