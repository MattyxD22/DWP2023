<?php
require("../controllers/InfoController.php");

use controllers\InfoController;

$infoController = new InfoController();

$infoObj = $infoController->fetchAboutUsDetails();

$fName = $infoObj["FName"];
$lName = $infoObj["LName"];
$email = $infoObj["Email"];
$city = $infoObj["City"];
$streetName = $infoObj["StreetName"];
$houseNumber = $infoObj["HouseNumber"];
$phoneNumber = $infoObj["PhoneNumber"];

    $aboutUsDescription = base64_decode($infoController->fetchAboutUsDescription());

?>

<article class="text-red-600 about_us_wrapper rounded-md h-full">
    <section  class="flex flex-col items-center justify-center pt-16">
        <?php echo $aboutUsDescription ?>
    </section>

    <section class="w-full flex justify-center items-center text-xl pt-16 font-black">
        <h1>Come in contact with us</h1>
    </section>

    <section class="flex flex-col p-16">
        <span class="flex gap-1">Name: <div class="text-white"><?php echo $fName . " " . $lName ?></div></span>
        <span class="flex gap-1">Email: <div class="text-white"><?php echo $email ?></div></span>
        <span class="flex gap-1">Phone number: <div class="text-white"><?php echo $phoneNumber ?></div></span>
        <div class="flex gap-1">
            <span class="flex gap-1">Address: <div class="text-white"><?php echo $streetName . " " . $houseNumber . "," ?></div> </span>
            <span class="text-white"><?php echo $city ?></span>
        </div>

    </section>
</article>