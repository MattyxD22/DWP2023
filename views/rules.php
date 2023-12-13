<div class="flex h-full w-full px-2 py-2">
    <div class="rules_bg flex flex-col ps-2 pe-4 py-2 overflow-auto w-full">

        <?php
        $count = 1;
        foreach ($rules as $key => $rule) {
        ?>

            <div class="flex flex-row rules_row py-2">
                <div class="grid grid-cols-12 w-full">
                    <div class="col-span-1 text-center">
                        <span class="ruleNum"><?php echo $count ?></span>
                    </div>

                    <div class="col-span-11">
                        <span class="ruleText"><?php echo $rule["Rule"] ?></span>
                    </div>
                </div>
            </div>


        <?php
            $count++;
        } ?>

    </div>

</div>