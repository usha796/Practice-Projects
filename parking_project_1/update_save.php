<?php
require_once("includes/classes/FormSanitizer.php");
session_start();

if(isset($_POST["submit"])) {
    // Check if the session is started
    if (!isset($_SESSION["username"])) {
        echo "Session not started. Please log in.";
        exit(); // Stop further execution
    }
    // Check if the connection to the database is successful
    $conn = mysqli_connect("localhost", "root", "", "parking_project");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
// Sanitize form inputs
    $ID = FormSanitizer::sanitizeInt($_GET['ID']);
    $owner_name = FormSanitizer::sanitizeFormOwnerName($_POST["owner_name"]);
    $vehicle_name = FormSanitizer::sanitizeFormVehicleName($_POST["vehicle_name"]);
    $vehicle_number = FormSanitizer::sanitizeFormVehicleNumber($_POST["vehicle_number"]);
    $entry_date = $_POST['entry_date'];
    $exit_date = $_POST['exit_date'];
    $token_number = $_POST['token'];
    $charge = $_POST['charge'];    
    $updated_by = $_SESSION["username"];

    // Check if record already exists in vehicle_info
    $sql1 = "SELECT Registered_by FROM vehicle_info WHERE Vehicle_number = ? AND Entry_date = ?";
    $stmt1 = mysqli_prepare($conn, $sql1);
    mysqli_stmt_bind_param($stmt1, "ss", $vehicle_number, $entry_date);
    mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);
    $num = mysqli_num_rows($result1);

    // Assign registered_by based on the result
    $registered_by = '--'; // Default value
    if ($num == 1) {
        $row = mysqli_fetch_assoc($result1);
        $registered_by = $row['Registered_by'];
    }

    // Close the statement for the first query
    mysqli_stmt_close($stmt1);

    // Insert/update record in vehicle_info table
    $sql2 = "UPDATE vehicle_info SET Registered_by=?, Updated_by=?, Owner_name=?, Vehicle_name=?, Vehicle_number=?, Entry_date=?, Exit_date=?, Token_number=?, Charge=? WHERE ID=?";
    $stmt2 = mysqli_prepare($conn, $sql2);
    mysqli_stmt_bind_param($stmt2, "sssssssssi", $registered_by, $updated_by, $owner_name, $vehicle_name, $vehicle_number, $entry_date, $exit_date, $token_number,$charge, $ID);
    
    // Execute the insert/update query
    if (mysqli_stmt_execute($stmt2)) {
        mysqli_stmt_close($stmt2);
        mysqli_close($conn);
        echo "Updated successfully"; // Or you can redirect to a success page
        header("Location: record.php");
        exit();
    } else {
        echo "Error: " . mysqli_stmt_error($stmt2);
    }
}
?>
