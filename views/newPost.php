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
            <form class="h-full w-full flex flex-col" method="post" action="../controllers/">
                <div class="container newPost_container flex flex-col px-4 py-4 my-auto">
                    <div class="newPost_TitleCol flex flex-col h-1/8 py-2">
                        <span class="text-red-600 text-2xl font-bold mb-2">Title</span>
                        <input type="text" class="std_input h-[35px]">
                    </div>
                    <div class="newPost_DescriptionCol flex flex-col h-4/8 py-2">
                        <span class="text-red-600 text-2xl font-bold mb-2">Description</span>
                        <textarea class="std_input"></textarea>
                    </div>
                    <div class="newPost_CategoryCol flex flex-col h-1/8 py-2">
                        <span class="text-red-600 text-2xl font-bold mb-2">Select one or more categories</span>
                        <div class="relative inline-block text-left">
                            <div>
                                <button type="button" class="flex w-full justify-center gap-x-1.5 rounded-md bg-gray px-3 py-2  shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50" id="menu-button" aria-expanded="true" aria-haspopup="true">
                                    <span class="text-md font-semibold text-red-600 ms-auto">Categories</span>
                                    <svg class="-mr-1 ms-auto h-5 w-5 text-red-400" viewBox="0 0 15 15" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            <!--
    Dropdown menu, show/hide based on menu state.

    Entering: "transition ease-out duration-100"
      From: "transform opacity-0 scale-95"
      To: "transform opacity-100 scale-100"
    Leaving: "transition ease-in duration-75"
      From: "transform opacity-100 scale-100"
      To: "transform opacity-0 scale-95"
  -->
                            <div class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-gray shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                                <div class="py-1 flex flex-column" role="none">
                                    <div class="row_category flex flex-row" data-id="1">
                                        <div class="flex items-center mb-4">
                                            <input id="default-checkbox1" type="checkbox" value="" class="std_checkbox category_checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="default-checkbox1" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Category 1</label>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="newPost_MediaCol flex flex-col h-1/8 py-2">
                        <span class="text-red-600 text-2xl font-bold mb-2">Upload Image(s) or Video(s)</span>
                        <input multiple="true" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer dark:text-gray-400 focus:outline-none dark:border-gray-600 dark:placeholder-red-400 std_input h-[35px]" id="file_input" type="file">
                    </div>
                    <div class="newPost_CreateCol flex flex-row h-1/8 py-2 mt-auto justify-end">
                        <button class="std_button createNewPost_btn">
                            <span class="createPost_Span text-2xl font-bold text-red-600">Create</span>
                        </button>
                    </div>



                </div>
            </form>


        </div>
    </div>
</div>