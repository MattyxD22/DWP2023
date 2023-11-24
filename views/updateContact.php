<?php
    $contactInfo = $adminController->fetchContact();

    $fName = htmlspecialchars($contactInfo['FName']);
    $lName = htmlspecialchars($contactInfo['LName']);
    $email = htmlspecialchars($contactInfo['Email']);
    $phoneNumber = htmlspecialchars($contactInfo['PhoneNumber']);
    $city = htmlspecialchars($contactInfo['City']);
    $streetName = htmlspecialchars($contactInfo['StreetName']);
    $houseNumber = htmlspecialchars($contactInfo['HouseNumber']);
?>

<article class="w-full">
    <form class="flex flex-col gap-4 text-black justify-center w-full items-center updateContact">
        <section class="flex flex-col">
            <label class="text-red-600 text-xl" for="firstName">First name</label>
            <input class="input_password std_input w-[500px] contactInfoFirstName" id="firstName" name="firstName" type="text" value="<?php echo $fName; ?>">
        </section>

        <section class="flex flex-col">
            <label class="text-red-600 text-xl" for="lastName">Last name</label>
            <input class="input_password std_input w-[500px] contactInfoLastName" id="lastName" name="lastName" type="text" value="<?php echo $lName; ?>">
        </section>

        <section class="flex flex-col">
            <label class="text-red-600 text-xl" for="email">Email</label>
            <input class="input_password std_input w-[500px] contactInfoEmail" id="email" name="email" type="email" value="<?php echo $email; ?>">
        </section>

        <section class="flex flex-col">
            <label class="text-red-600 text-xl" for="phoneNumber">Phone number</label>
            <input class="input_password std_input w-[500px] contactInfoPhoneNumber" id="phoneNumber" name="phoneNumber" type="tel" value="<?php echo $phoneNumber; ?>">
        </section>

        <section class="flex flex-col">
            <label class="text-red-600 text-xl" for="city">City</label>
            <input class="input_password std_input w-[500px] contactInfoCity" id="city" name="city" type="text" value="<?php echo $city; ?>">
        </section>
        
        <section class="flex flex-col">
            <label class="text-red-600 text-xl" for="streetName">Street name</label>
            <input class="input_password std_input w-[500px] contactInfoStreetName" id="streetName" name="streetName" type="text" value="<?php echo $streetName; ?>">
        </section>

        <section class="flex flex-col">
            <label class="text-red-600 text-xl" for="houseNumber">House number</label>
            <input class="input_password std_input w-[500px] contactInfoHouseNumber" id="houseNumber" name="houseNumber" type="text" value="<?php echo $houseNumber; ?>">
        </section>
        
        <section class="flex justify-center">
            <button type="button" class="std_button updateContactBtn">
                <span class="createPost_Span text-2xl font-bold text-red-600">Save</span>
            </button>
        </section>
    </form>
</article>
