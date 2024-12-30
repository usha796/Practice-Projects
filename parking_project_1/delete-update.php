<?php
$ID = $_GET['ID'];

// Establish connection using mysqli_connect instead of mysql_connect
$conn = mysqli_connect("localhost", "root", "", "parking_project") or die("Connection failed");

// Use mysqli_query instead of mysql_query
$sql = "DELETE FROM `vehicle_info` WHERE `ID`='{$ID}'";
$result = mysqli_query($conn, $sql) or die("Query failed");

// Uncomment the line below to redirect after successful deletion
header("Location:record.php");

// Display an alert message instead of redirecting
// echo "<script>alert('Record deleted successfully');</script>";

mysqli_close($conn);
?>
