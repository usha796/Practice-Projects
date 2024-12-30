<!-- 02-26  -->
<?php

// Initialize an array to track the availability of numbers
$availableNumbers = range(1, 5);

// Function to reserve a number for a user
function reserveNumber($user) {
    global $availableNumbers;

    // Check if there are available numbers
    if (!empty($availableNumbers)) {
        // Get the first available number
        $reservedNumber = array_shift($availableNumbers);

        echo " $user reserved number $reservedNumber.<br>";
    } else {
        echo "No available numbers.<br>";
    }
}

// Function to release a reserved number
function releaseNumber($user, $number) {
    global $availableNumbers;

    // Check if the number is within the valid range
    if ($number >= 1 && $number <= 50) {
        // Check if the number is reserved by the user
        if (($key = array_search($number, $availableNumbers)) === false) {
            // Release the number
            $availableNumbers[] = $number;
            echo "$user released number $number.<br>";
        } else {
            echo "$number is not reserved by user $user.<br>";
        }
    } else {
        echo "Invalid number.<br>";
    }
}

// Example usage
reserveNumber("User1");
reserveNumber("User2");
releaseNumber("User2", 2);  //user 2 releases number 2
reserveNumber("User3");
reserveNumber("User4");
reserveNumber("User5");
reserveNumber("User6");     //no.2 is available to  be reserved again


// You can print or use the $availableNumbers array to see the current availability

?>
