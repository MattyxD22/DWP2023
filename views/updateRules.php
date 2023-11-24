<div class="flex flex-col overflow-auto ps-2 pe-3 py-3 overflow-auto h-full w-full rules_MainContainer">

    <div class="rules_col flex flex-col overflow-auto w-full h-full rules_ScrollContainer">
        <?php
        $count = 1;
        foreach ($rules as $key => $rule) {
        ?>

            <div class="flex flex-row rules_row py-2 rules_row">
                <div class="grid grid-cols-12 w-full">
                    <div class="col-span-1 text-center">
                        <span class="ruleNum"><?php echo $count ?></span>
                    </div>

                    <div class="col-span-9 px-1">
                        <textarea class="w-full std_input" rows="6"><?php echo $rule["Rule"] ?></textarea>
                    </div>

                    <div class="flex flex-col col-span-2 px-1 py-1 h-full justify-around">
                        <button type="button" data-rule="<?php echo $rule["RuleID"] ?>" class="std_button w-full update_rule">Update</button>

                        <button type="button" data-rule="<?php echo $rule["RuleID"] ?>" class="std_button w-full delete_rule">Delete</button>
                    </div>


                </div>
            </div>
        <?php
            $count++;
        } ?>
    </div>




    <div class="flex flex-row sticky justify-end py-2" style="bottom: -12px; background-color: #3d3d3d">
        <button type="button" class="std_button get_new_rule">Add new rule?</button>
    </div>


</div>