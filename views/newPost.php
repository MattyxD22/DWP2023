<?php

require("../db/connection.php");
require("mainBG.php");

?>

<div class="container-fluid flex flex-row w-full h-full">
    <div class="columns-2 w-full flex flex-row">
        <div class="sidebar_col">
            <?php include('../views/sideBar.php') ?>
        </div>
        <div class="newPost_col w-full h-full flex flex-col overflow-y-auto py-3 px-3 justify-center">
            <form class="h-full w-full flex flex-col">
                <div class="container newPost_container flex flex-col px-4 py-4">
                    <div class="newPost_TitleCol flex flex-col h-1/8 py-2">
                        <span class="text-red-600 text-2xl font-bold mb-2">Title</span>
                        <input type="text" class="std_input">
                    </div>
                    <div class="newPost_DescriptionCol flex flex-col h-4/8 py-2">
                        <span class="text-red-600 text-2xl font-bold mb-2">Description</span>
                        <textarea class="std_input"></textarea>
                    </div>
                    <div class="newPost_CategoryCol flex flex-col h-1/8 py-2">
                        <span class="text-red-600 text-2xl font-bold mb-2">Select one or more categories</span>
                        <select type="text" class="std_input"></select>
                    </div>
                    <div class="newPost_MediaCol flex flex-col h-1/8 py-2">
                        <span class="text-red-600 text-2xl font-bold mb-2">Upload Image(s) or Video(s)</span>
                        <input type="file" multiple="true" class="std_input">
                    </div>
                    <div class="newPost_CreateCol flex flex-row h-1/8 py-2 mt-auto justify-end">
                        <button class="std_button">
                            <span class="createPost_Span text-2xl font-bold text-red-600">Create</span>
                        </button>
                    </div>



                </div>
            </form>


        </div>
    </div>
</div>