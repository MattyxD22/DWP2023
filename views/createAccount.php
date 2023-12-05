<?php

require("../db/connection.php");

require("mainBG.php");

$regXP = "/^[A-z0-9_-]+([.][A-z0-9_]+)*[@][A-z0-9_-]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";


?>
<form method="post" action="../controllers/UserController.php?action=create">

    <!--    since there was made changes to the controller, post requests require a "action" parameter,
            the parameter is not retrieved in the form, so below is a hackish solution                  -->
    <input readonly hidden name="action" type="text" value="create" style="visibility: hidden; display: none; pointer-events:none;">

    <div class="container mx-auto flex flex-col justify-center w-[500px]">
        <h1 class="text-white text-2xl font-bold mx-auto">Welcome to BreadTube, to join the fun, feel free to create an account.</h1>

        <div class="flex flex-col py-3">
            <span class="text-xl text-red-600">Username</span>
            <input type="text" id='username' name="username" class="std_input w-[100%]" required/>
        </div>

        <div class="flex flex-col py-3">
            <span class="text-xl text-red-600">Email</span>
            <input type="email" id='email' name="email" class="std_input w-[100%]" required/>
        </div>

        <div class="flex flex-col py-3">
            <span class="text-xl text-red-600">Password</span>
            <input type="password" id='password' name="password" class="std_input w-[100%]" />
        </div>

        <div class="g-recaptcha flex justify-center" 
                data-sitekey="<?php echo CAPTCHA_SITE_KEY;?>"> 
            </div> 

        <button type="submit" class="std_button flex flex-row mx-auto my-3">
            <span class="text-red-600 font-bold mr-2">Create </span>
            <span class="text-white font-bold">Account</span>
        </button>


    </div>
</form>