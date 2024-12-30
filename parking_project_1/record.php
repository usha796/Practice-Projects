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
                <h2 class="title">All Vehicles Entry Records</h2>
                <div class="search-bar">
                    <ion-icon name="search-outline" class="search-icon"></ion-icon>
                    <input type="text" class="search-input" onkeyup="search()" id="text" placeholder="Search vehicle owner">
                </div>
                <div class="record-table">
                    <table class="table table-stripped" id="table">
                        <?php 
                            $conn = mysqli_connect("localhost", "root", "", "parking_project");
                            if (!$conn) {
                                die("Connection failed: " . mysqli_connect_error());
                            }

                            $sql = "SELECT * FROM vehicle_info ORDER BY Exit_date DESC";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {                        
                        ?>
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Registered By</th>
                                <th>Updated By</th>
                                <th>Owner Name</th>
                                <th>Vehicle Name</th>
                                <th>Vehicle Number</th>
                                <!-- <th>Entry Date</th> -->
                                <!-- <th>Exit Date</th> -->
                                <th>Token Number</th>
                                <th>Fare</th>
                                <th>Receipt</th>
                                <th>View Detail</th>
                                <th>Delete Record</th>
                            </tr>
                        </thead>
                        <?php 
                            // Move the function declaration outside of the loop
                            function calculateRate($startTime, $endTime, $ratePerHour) {
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

                            $count = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tbody>
                            <tr>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo htmlspecialchars($row['Registered_by']); ?></td>
                                <td><?php echo htmlspecialchars($row['Updated_by']); ?></td>
                                <td><?php echo htmlspecialchars($row['Owner_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['Vehicle_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['Vehicle_number']); ?></td>
                                <td><?php echo htmlspecialchars($row['Token_number']); ?></td>
                                <td>
                                    <?php 
                                            $startTime = $row['Entry_date'];
                                            $endTime = $row['Exit_date'];
                                            $charge = $row['Charge'];
                                            $ratePerHour = ($charge == "Daily") ? 15 : 10;
                                            
                                            // Call the function to calculate the rate
                                            $totalCost = calculateRate($startTime, $endTime, $ratePerHour);
                                            
                                            // Round the total cost
                                            $totalCost = round($totalCost);
                                            
                                            // Display the result
                                            echo htmlspecialchars($totalCost);

                                            // Code to insert in table vehicle_info
                                            $updateSql = "UPDATE vehicle_info SET Fare = ? WHERE ID = ?";
                                            $stmt = $conn->prepare($updateSql);
                                            $stmt->bind_param("di", $totalCost, $row['ID']);

                                            if ($stmt->execute()) {
                                                // Optionally display a success message, but avoid duplicate messages in a loop
                                            } else {
                                                echo "Error updating total cost: " . htmlspecialchars($conn->error);
                                            }

                                            $stmt->close();
                                        ?>
                                </td>
                                <td><a href="receipt.php?ID=<?php echo htmlspecialchars($row['ID']); ?>">Receipt</a></td>
                                <td><a href="view_detail.php?ID=<?php echo htmlspecialchars($row['ID']); ?>">View</a></td>
                                <td><a href="delete-update.php?ID=<?php echo htmlspecialchars($row['ID']); ?>">Delete</a></td>
                            </tr>
                        </tbody>
                        <?php 
                                } // End while loop
                            } else {
                                echo "<tr><td colspan='12'>No Data Found.</td></tr>";
                            }
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
    <script>
        const search = () => {
            var input_value = document.getElementById("text").value.toUpperCase();
            var table = document.getElementById("table");
            var tr = table.getElementsByTagName("tr");
            for (var i = 0; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName("td")[3];
                if (td) {
                    var text_value = td.textContent || td.innerText;
                    if (text_value.toUpperCase().indexOf(input_value) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>
