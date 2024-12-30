<?php 
session_start();
if(!isset($_SESSION['username'])){
    header("location:login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Parking</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="box">
        <div class="header">
            <div class="title">
                <h4>Parking Lot<br>Management System</h4>
            </div>
            <ul class="nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="record.php">Records</a></li>
                <li><a href="report.php">Report</a></li>
                <li><a href="admin.php">Create Parking admin</a></li>
                <li><a href="logout.php">Logout '<?php echo htmlspecialchars($_SESSION['username']); ?>'</a></li>
            </ul>
        </div>
        <section class="Vehiclerecords">
            <div class="records">
                <h2 class="title">Vehicles Detail</h2>
                <div class="record-table">
                    <table class="table table-stripped" id="table">
                        <?php 
                            $conn = mysqli_connect("localhost", "root", "", "parking_project");
                            if (!$conn) {
                                die("Connection failed: " . mysqli_connect_error());
                            }

                            $ID = $_GET['ID'];
                            $sql = "SELECT * FROM vehicle_info WHERE ID = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $ID);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {                        
                                while ($row = $result->fetch_assoc()) {
                            ?>
                             <tr>
                                <th>Token</th>
                                <td><?php echo htmlspecialchars($row['Token_number']); ?></td>
                            </tr>
                            <tr>
                                <th>Registered by</th>
                                <td><?php echo htmlspecialchars($row['Registered_by']); ?></td>
                            </tr>
                            <tr>
                                <th>Updated by</th>
                                <td><?php echo htmlspecialchars($row['Updated_by']); ?></td>
                            </tr>
                            <tr>
                                <th>Owner name</th>
                                <td><?php echo htmlspecialchars($row['Owner_name']); ?></td>
                            </tr>                        
                            <tr>
                                <th>Vehicle name</th>
                                <td><?php echo htmlspecialchars($row['Vehicle_name']); ?></td>
                            </tr>
                            <tr>
                                <th>Vehicle number</th>
                                <td><?php echo htmlspecialchars($row['Vehicle_number']); ?></td>
                            </tr>
                            <tr>
                                <th>Entry date</th>
                                <td><?php echo htmlspecialchars($row['Entry_date']); ?></td>
                            </tr>
                            <tr>
                                <th>Exit date</th>
                                <td><?php echo htmlspecialchars($row['Exit_date']); ?></td>
                            </tr>
                            <tr>
                                <th>Charge</th>
                                <td><?php echo htmlspecialchars($row['Charge']); ?></td>
                            </tr>
                            <tr>
                                <th>Fare</th>
                                <td><?php echo htmlspecialchars($row['Fare']); ?></td>
                            </tr>
                        <?php 
                                }
                            } else {
                                echo "<tr><td colspan='2'>No Data Found.</td></tr>";
                            }
                            $stmt->close();
                            mysqli_close($conn);
                        ?>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <footer>
        <div class="footer-content">
            <p>&copy; 2024 Parking Lot Management System</p>
            <ul>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Service</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>
<?php 

?>
