<?php
function validateVehicleName($vehicleName) {
    // Define the regular expression for a valid vehicle name
    $regex = '/^[A-Za-z0-9 ]+$/';

    // Check if the vehicle name matches the regex and is within length limits
    if (strlen($vehicleName) < 1 || strlen($vehicleName) > 50) {
        return false;
    }
    return preg_match($regex, $vehicleName);
}

// Example usage:
$vehicleName1 = "Tesla Model S";
$vehicleName2 = "Ford 123";
$vehicleName3 = "Honda@Civic";  // Invalid due to special character

echo validateVehicleName($vehicleName1) ? 'true' : 'false'; // true
echo "\n";
echo validateVehicleName($vehicleName2) ? 'true' : 'false'; // true
echo "\n";
echo validateVehicleName($vehicleName3) ? 'true' : 'false'; // false
?>
