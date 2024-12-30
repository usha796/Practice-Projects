<?php 
require_once("includes/classes/FormSanitizer.php");
session_start();


if(isset($_POST["submit"])){
    $token_query = "SELECT MAX(Token_number) AS max_token FROM vehicle_info";
    $token_result = mysqli_query($conn, $token_query);
    $row = mysqli_fetch_assoc($token_result);
    $next_token = ($row['max_token'] + 1); // Next available token number

    if($next_token <= 50) {
    $owner_name=FormSanitizer::sanitizeFormOwnerName($_POST["owner_name"]);
    $vehicle_name=FormSanitizer::sanitizeFormVehicleName($_POST["vehicle_name"]);
    $vehicle_number=FormSanitizer::sanitizeFormVehicleNumber($_POST["vehicle_number"]);
    $entry_date = $_POST['entry_date'];
    $token_number = $_POST['token']; 
    // $registered_by=$_SESSION["username"];


    $conn = mysqli_connect("localhost", "root", "", "parking_project") or die("Connection failed");

    // Use prepared statements to prevent SQL injection
    $sql = "INSERT INTO vehicle_info (Registered_by, Owner_name, Vehicle_name, Vehicle_number, Entry_date, Token_number) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, 'ssssss',$registered_by, $owner_name, $vehicle_name, $vehicle_number, $entry_date, $next_token);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header("location:index.php");
    mysqli_close($conn);
} else {
    echo "<script>alert('No parking space available.');</script>";
}

}
?>
