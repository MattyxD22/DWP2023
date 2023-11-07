<?php

require("../db/connection.php")



?>


<div class="newPost_col w-full h-full flex flex-col overflow-y-auto py-3 px-3 justify-center">
    <form class="h-full w-full flex flex-col" method="post" action="../controllers/">
        <div class="container newPost_container flex flex-col px-4 py-4 my-auto">
            <div class="newPost_TitleCol flex flex-col h-1/8 py-2">
                <span class="text-red-600 text-2xl font-bold mb-2">Title</span>
                <input type="text" class="std_input newPost_Title h-[35px]">
            </div>
            <div class="newPost_DescriptionCol flex flex-col h-4/8 py-2">
                <span class="text-red-600 text-2xl font-bold mb-2">Description</span>
                <textarea class="std_input newPost_Textarea"></textarea>
            </div>
            <div class="newPost_CategoryCol flex flex-col h-1/8 py-2">
                <span class="text-red-600 text-2xl font-bold mb-2">Select one or more categories</span>

                <div class="categoryContainer content-center flex flex-row justify-center relative">

                    <span class="text-red-600 flex my-auto">Categories</span>
                    <i class="bi bi-chevron-down absolute text-red-600"></i>

                    <div class="categoryDropdownContainer">

                        <?php
                        $counter = 1;
                        while ($counter <= 10) {
                            echo '<div class="flex flex-row categoryRow py-1" data-id="' . $counter . '"><input  class="categoryCheckbox my-auto" type="checkbox"><span class="ms-2 my-auto flex text-red-600">Category ' . $counter . '</span></div>';
                            $counter++;
                        }
                        ?>

                    </div>

                </div>

            </div>
            <div class="newPost_MediaCol flex flex-col h-1/8 py-2">
                <span class="text-red-600 text-2xl font-bold mb-2">Upload Image(s) or Video(s)</span>
                <input multiple="true" accept=".png, .bmp, .jpg, .jpeg, .gif, .mp4" class="files_input_newPost block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer dark:text-gray-400 focus:outline-none dark:border-gray-600 dark:placeholder-red-400 std_input h-[35px]" id="file_input" type="file">
            </div>
            <div class="newPost_CreateCol flex flex-row h-1/8 py-2 mt-auto justify-end">
                <button type="button" class="std_button createNewPost_btn">
                    <span class="createPost_Span text-2xl font-bold text-red-600">Create</span>
                </button>
            </div>



        </div>
    </form>


</div>