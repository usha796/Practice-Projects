<?php
// Function to calculate the total cost based on start and end date/time
function calculateRate($startTime, $endTime, $ratePerHour) {
    // Check if end time is not set or equals '0000-00-00 00:00:00'
    if (empty($endTime) || $endTime == '0000-00-00 00:00:00') {
        return 0; // Return 0 fare
    }

    $startDateTime = new DateTime($startTime);
    $endDateTime = new DateTime($endTime);

    $diff = $endDateTime->diff($startDateTime);

    // Calculate the total hours
    $totalHours = $diff->days * 24 + $diff->h + $diff->i / 60;

    // Calculate the total cost
    $totalCost = $totalHours * $ratePerHour;

    return $totalCost;
}

// Process the form when it is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startTime = $_POST["start_time"];
    $endTime = $_POST["end_time"];
    $ratePerHour = 15; // Replace with your actual rate per hour

    // Call the function to calculate the rate
    $totalCost = calculateRate($startTime, $endTime, $ratePerHour);

    // Display the result
    echo "Total Cost: $totalCost";
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="start_time">Start Date and Time:</label>
    <input type="datetime-local" id="start_time" name="start_time" required><br>

    <label for="end_time">End Date and Time:</label>
    <input type="datetime-local" id="end_time" name="end_time"><br>

    <input type="submit" value="Calculate">
</form>
