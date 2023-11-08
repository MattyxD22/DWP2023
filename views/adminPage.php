<?php 
require("../controllers/AdminController.php");
use controllers\AdminController;
$adminController = new AdminController();
session_start();
$users = [""];

?>

<article class="p-8 h-full text-white">   
    <section class="h-full w-full gap-8 flex flex-col" style="background-color: #3D3D3D;">

    <?php
        if ($_SESSION["isAdmin"]) {
            $users = $adminController->fetchUsers($_SESSION["UserID"]);
        ?>
        <section class="p-4 gap-2">
            <label for="users" class="mb-2">Select a user:</label>
            <select name="users" id="users" class="w-full text-black pl-4" onchange="updateBanStatus()">
                <?php foreach ($users as $user): ?>
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
        </section>

        <section class="flex justify-between px-4 gap-2">
            <span>Ban User</span>
            <label class="switch">
                <input type="checkbox" id="banCheckbox">
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
        }
        ?>

        
        <section class="flex flex-col px-4 gap-2">
            <span>Change User's Email</span>
            <input/>
        </section>

        <section class="flex flex-col px-4 gap-2">
            <span>Change User's Password</span>
            <input/>
        </section>
    </section>
</article>