<?php



require("../db/connection.php");
//require("mainBG.php");

$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);

//$db = mysqli_connect(DB_NAME, DB_USER, DB_PASS, DB_NAME) or die("error opening mysqli");
$db_conn = mysqli_select_db($connection, DB_NAME);
$data = mysqli_query($connection, "SELECT Title FROM CategoryTable");
$results = mysqli_fetch_all($data);

// foreach ($results as $key => $value) {
//     echo $value[0];
// }

?>

<div class="w-full h-full flex flex-col category_mainContainer">

    <?php if (isset($results) && !empty($results)) { ?>
        <?php foreach ($results as $key => $value) {

            $title = $value[0];

        ?>
            <div class="categoryRow flex flex-col py-3">

                <div class="categoryHeader pb-3 sticky left-0">
                    <label class="text-red-600">
                        <?php echo $title ?>
                    </label>
                </div>

                <div class="categoryContent flex flex-row">

                    <?php

                    for ($i = 0; $i < 10; $i++) { ?>

                        <div class="imageContainer flex flex-col px-2">
                            <div class="imagePlaceholder"></div>
                            <div class="imageContext flex flex-col">
                                <span class="flex text-red-600 flex-row">Title test <?php echo $i ?> </span>

                            </div>
                        </div>

                    <?php } ?>

                </div>
            </div>





        <?php } ?>
    <?php } ?>



</div>