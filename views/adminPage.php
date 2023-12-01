<?php
require("../controllers/AdminController.php");

use controllers\AdminController;

$adminController = new AdminController();
$users = [""];
?>

<article class="p-8 h-full text-white">
    <section class="h-full w-full gap-8 flex flex-col updateUserContainer profile_page" style="background-color: #3D3D3D;">

        <?php
        if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == 1) {
            $users = AdminController::fetchUsers($_SESSION["UserID"]);
        ?>
            <div class="profile_tab_container admin px-1 pt-2 flex flex-row w-full justify-between h-24">
                <div class="tab_elem admin selected" data-type="1">
                    <span class="tab_first_text me-2">Update</span>
                    <span>User</span>
                </div>
                <div class="tab_elem admin" data-type="2">
                    <span class="tab_first_text me-2">Update</span>
                    <span>Rules</span>
                </div>
                <div class="tab_elem admin" data-type="3">
                    <span class="tab_first_text me-2">Update</span>
                    <span>Contact</span>
                </div>
                <div class="tab_elem admin" data-type="4">
                    <span class="tab_first_text me-2">Update</span>
                    <span>Description</span>
                </div>
            </div>
            <section class="p-4 gap-2 selected profile_content" data-type="1">
                <label for="users" class="mb-2">Select a user:</label>
                <select name="users" id="users" class="w-full text-black pl-4 selectedUserToUpdate" onchange="updateBanStatus()">
                    <?php foreach ($users as $user) : ?>
                        <option value='<?php echo htmlspecialchars(json_encode($user), ENT_QUOTES, 'UTF-8'); ?>'>
                            <?php
                            // Display username, first name, and last name
                            echo htmlspecialchars($user['Username'], ENT_QUOTES, 'UTF-8');
                            if (!empty($user['FName']) && !empty($user['LName'])) {
                                echo " ({$user['FName']} {$user['LName']})";
                            }
                            if ($_SESSION["UserID"] === $user["UserID"]) {
                                echo ' (You)';
                            }
                            ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <section class="flex flex-col w-full gap-8">
                    <section class="flex justify-between px-4 gap-2">
                        <span>Ban User</span>
                        <label class="switch">
                            <input type="checkbox" id="banCheckbox" class="selectedUserBanStatus">
                            <span class="slider round"></span>
                        </label>
                    </section>

                    <script>
                        function updateBanStatus() {
                            var select = document.getElementById('users');
                            var user = JSON.parse(select.options[select.selectedIndex].value);
                            // Assuming 'Banned' is 1 when the user is banned and 0 or null otherwise
                            document.getElementById('banCheckbox').checked = user.Banned == 1;
                        }
                    </script>

                    <?php
                    echo '
                    <section class="flex flex-col px-4 gap-2">
                        <span>Change Email</span>
                        <input type="text" id="NewEmail" class="newEmail text-red-600">
                    </section>

                    <section class="flex flex-col px-4 gap-2">
                        <span>Change Password</span>
                        <input type="password" id="newPassword" class="newPassword text-red-600">
                    </section>

                    <section class="flex justify-center">
                        <button type="button" class="std_button updateUserBtn">
                                <span class="createPost_Span text-2xl font-bold text-red-600">Save</span>
                        </button>
                    </section>';
                ?>
            </section>
        </section>
    
        <section class="p-4 gap-2 profile_content" data-type="2">
            <?php 
                include("../views/updateRules.php");
            ?>
        </section>

        <section class="p-4 gap-2 profile_content" data-type="3">
            <?php 
                include("../views/updateContact.php");
            ?>
        </section>

        <section class="p-4 gap-2 profile_content" data-type="4">
            <?php 
                include("../views/updateDescription.php");
            ?>
        </section>

        <?php
        }
        ?>


        <?php
        if (!isset($_SESSION["isAdmin"]) || $_SESSION["isAdmin"] != 1) {
            echo '
                    <section class="flex flex-col px-4 gap-2">
                        <span>Change Email</span>
                        <input type="text" id="NewEmail" class="newEmail text-red-600">
                    </section>

                    <section class="flex flex-col px-4 gap-2">
                        <span>Change Password</span>
                        <input type="password" id="newPassword" class="newPassword text-red-600">
                    </section>

                    <section class="flex justify-center">
                        <button type="button" class="std_button updateUserBtn">
                                <span class="createPost_Span text-2xl font-bold text-red-600">Save</span>
                        </button>
                    </section>';
        }
        ?>

    </section>
</article>