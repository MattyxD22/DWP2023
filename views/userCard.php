<div class="user-card shadow-md rounded-lg overflow-hidden cursor-pointer" data-userid="<?php echo $userID ?>">
    <div class="p-4">
        <div class="flex items-center space-x-4">
            <div class="flex-1">
                <h3 class="font-semibold text-lg text-white"><?php echo htmlspecialchars($username); ?></h3>
                <p class="text-white"><?php echo htmlspecialchars($fname) . ' ' . htmlspecialchars($lname); ?></p>
            </div>
        </div>
    </div>
</div>
