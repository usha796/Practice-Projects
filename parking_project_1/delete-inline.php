<?php
    $ID= $_GET['ID'];
    $conn = mysqli_connect("localhost", "root", "", "parking_project") or die("Connection failed");
    $sql="DELETE  FROM `vehicle_info` WHERE ID='{$ID}'";  //query to delete
    $result=mysqli_query($conn,$sql) or die("Query failed");
    header("location:index.php");
    mysqli_close($conn);
?>