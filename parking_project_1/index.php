<?php 
session_start();
// require_once __DIR__ . '/vendor/autoload.php';
require_once("includes/classes/FormSanitizer.php");

// Database connection
$conn = mysqli_connect("localhost", "root", "", "parking_project");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check user session
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}

// Handle form submission
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $owner_name = FormSanitizer::sanitizeFormOwnerName($_POST["owner_name"]);
    $vehicle_name = FormSanitizer::sanitizeFormVehicleName($_POST["vehicle_name"]);
    $vehicle_number = FormSanitizer::sanitizeFormVehicleNumber($_POST["vehicle_number"]);
    $entry_date = $_POST['entry_date'];
    $charge = $_POST['charge'];

    // Step 1: Get all token numbers that do not have an exit_date, sorted in ascending order
$token_query = "SELECT Token_number FROM vehicle_info WHERE exit_date IS NULL ORDER BY Token_number ASC";
$token_result = mysqli_query($conn, $token_query);
if (!$token_result) {
    die("Token query failed: " . mysqli_error($conn));
}

$tokens = [];
while ($row = mysqli_fetch_assoc($token_result)) {
    $tokens[] = $row['Token_number'];
}

// Step 2: Find the closest available token number
$next_token = 1; // Start with the first possible token number

foreach ($tokens as $token) {
    if ($token != $next_token) {
        // Found a gap
        break;
    }
    $next_token++;
}

    // Check available space
    if($next_token <= 50) { 
        // Check if vehicle is parked
        $check_query = "SELECT * FROM `vehicle_info` WHERE `Vehicle_number` = ? AND `Exit_date` IS NULL";
        $check_stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($check_stmt, "s", $vehicle_number);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);

        if(mysqli_num_rows($check_result) > 0) {
            echo "<script>alert('Vehicle with this number plate is already parked.');</script>";
        } else {
            // Insert new record
            $insert_query = "INSERT INTO `vehicle_info` (Registered_by, Owner_name, Vehicle_name, Vehicle_number, Entry_date, Token_number, Charge) VALUES (?, ?, ?, ?, ?, ?, ?)";            $insert_stmt = mysqli_prepare($conn, $insert_query);
            mysqli_stmt_bind_param($insert_stmt, "sssssis", $_SESSION["username"], $owner_name, $vehicle_name, $vehicle_number, $entry_date, $next_token, $charge);
            if (mysqli_stmt_execute($insert_stmt)) {
                // call function to print pdf
                // printPDF($owner_name, $vehicle_name, $vehicle_number, $entry_date, $next_token);

                header("Location: index.php");
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } 
    } else {
        echo "<script>alert('No parking space available.');</script>";
    }
}

// Close database connection
mysqli_close($conn);

// function printPDF($owner_name,$vehicle_name,$vehicle_number,$entry_date,$next_token){
//     $mpdf = new \Mpdf\Mpdf();
//     $mpdf->WriteHTML('<h1>Vehicle Parking Ticket</h1>');
//     $mpdf->WriteHTML('<p><b>Owner Name: </b>'.$owner_name.'</p>');
//     $mpdf->WriteHTML('<p><b>Vehicle Name: </b>'.$vehicle_name.'</p>');
//     $mpdf->WriteHTML('<p><b>Vehicle Number: </b>'.$vehicle_number.'</p>');
//     $mpdf->WriteHTML('<p><b>Entry Date: </b>'.$entry_date.'</p>');
//     $mpdf->WriteHTML('<p><b>Token Number: </b>'.$next_token.'</p>');
//     $mpdf->Output('ticekt.pdf','D');


// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car parking</title>
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
                <li><a href="logout.php">Logout '<?php echo $_SESSION['username']; ?>'</a></li>
            </ul>
        </div>
        <div class="container">
            <div class="register">
                <h2>Registration form</h2>
                <form action="" method="post">
                    <div class="input-container">
                        <div class="input-group">
                            <span class="input-label">Vehicle Owner Name</span>
                            <input type="text" name="owner_name" id="owner_name" class="form-control" placeholder="Ram Thapa" required>
                        </div>
                        <div class="input-group">
                            <span class="input-label">Vehicle Name</span>
                            <input type="text" name="vehicle_name" id="vehicle_name" class="form-control" placeholder="Toyota" required>
                        </div>
                        <div class="input-group">
                            <span class="input-label">Vehicle Number</span>
                            <input type="text" name="vehicle_number" id="vehicle_number" class="form-control" placeholder="BA 12 CHA 7544" required>
                        </div>
                        <div class="input-group">
                            <span class="input-label">Entry Date</span>
                            <input type="datetime-local" name="entry_date" id="entry_date" class="form-control" required>
                        </div>
                        <div class="input-group">
                            <span class="input-label">Charge</span>
                            <select class="form-control" name="charge" required>
                                <option selected>Select charge</option>
                                <option value="Daily">Daily</option>
                                <option value="Monthly">Monthly</option>
                            </select>
                        </div>
                    </div>
                    <div class="btn">
                        <input type="submit" class="btnbox" name="submit" value="SUBMIT">
                    </div>
                </form>
            </div>
            <div id="car">
                <?php
                $conn=mysqli_connect("localhost","root","","parking_project") or die(mysqli_connect_error());
                $sql="SELECT * FROM `vehicle_info` WHERE exit_date IS NULL order by ID desc";
                $result = mysqli_query($conn,$sql) or die("Query Failed");
                $num =  mysqli_num_rows($result);
                if($num!=50){
                ?>
                <h2>Parking Space Information</h2>
                <h3>Total Space: <span>50</span></h3>
                <h3>Total Booked Space: <span><?php echo $num?></span></h3>
                <h3>Total Space Available: <span><?php echo (50-$num)?></span></h3>
                <?php
                }else{
                    echo "<h3>No parking space available</h3>";
                }
                ?>
            </div>
        </div>
    </div>
    <section>
        <div class="records">
            <h2 class="title">Current Vehicles Records</h2>
            <div class="search-bar">
                <ion-icon name="search-outline" class="search-icon"></ion-icon>
                <input type="text" class="search-input" onkeyup="search()" id="text" placeholder="Search vehicle owner">
            </div>
            <div class="record-table">
                <table class="table table-stripped" id="table">
                    <?php 
                    $conn=mysqli_connect("localhost","root","","parking_project") or die(mysqli_connect_error());
                    $sql="SELECT * FROM  `vehicle_info` where Exit_date is null order by Entry_date desc ";
                    $result = mysqli_query($conn,$sql) or die("Query Failed");
                    if(mysqli_num_rows($result)>0){                        
                    ?>
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Owner Name</th>
                            <th>Vehicle Name</th>
                            <th>Vehicle Number</th>
                            <th>Entry Date</th>
                            <th>Token Number</th>
                            <th>Charge</th>
                            <th>Update Record</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $count=1;
                        while($row=mysqli_fetch_assoc($result)){?>
                        <tr>
                            <td><?php echo $count++;?></td>
                            <td><?php echo $row['Owner_name'];?></td>
                            <td><?php echo $row['Vehicle_name'];?></td>
                            <td><?php echo $row['Vehicle_number'];?></td>
                            <td><?php echo $row['Entry_date'];?></td>
                            <td><?php echo $row['Token_number'];?></td>
                            <td><?php echo $row['Charge'];?></td>
                            <td><a href="update.php?ID=<?php echo $row['ID']?>">Exit Date</a></td>
                        </tr>
                        <?php 
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
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
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    var text_value = td.textContent;
                    if (text_value.toUpperCase().indexOf(input_value) > -1) {
                        tr[i].style.display = ""
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
        // Get the input element
        var entryDateInput = document.getElementById('entry_date');
        // Add an event listener for input change
        entryDateInput.addEventListener('input', function () {
            // Get the value of the input
            var enteredDateTime = new Date(this.value);
            var currentDateTime = new Date();
            // Compare the entered date with the current date
            if (enteredDateTime > currentDateTime) {
                // If entered date is in the future, show an alert and clear the input
                alert("Entry date cannot exceed the current date and time.");
                this.value = ''; // Clear the input
            }
        });

        // vehicle name validate
        document.addEventListener('DOMContentLoaded', function () {
        var vehicleNameInput = document.getElementById('vehicle_name');
        
        vehicleNameInput.addEventListener('input', function () {
            var vehicleName = this.value;
            var regex = /^[A-Za-z0-9 ]+$/;

            if (vehicleName.length < 1 || vehicleName.length > 50 || !regex.test(vehicleName)) {
                alert("Vehicle name can only contain alphabets, numbers, and spaces, and must be between 1 and 50 characters.");
                this.value = ''; // Clear the input
            }
        });
    });

    // owner name
    document.addEventListener('DOMContentLoaded', function () {
    var vehicleNameInput = document.getElementById('owner_name');
    
    vehicleNameInput.addEventListener('input', function () {
        var vehicleName = this.value;
        var regex = /^[A-Za-z ]+$/;

        if (vehicleName.length < 1 || vehicleName.length > 50 || !regex.test(vehicleName)) {
            alert("Owner's name can only contain alphabets and spaces, and must be between 1 and 50 characters.");
            this.value = ''; // Clear the input
        }
    });
});

        // vehicle number
    document.addEventListener('DOMContentLoaded', function () {
    var vehicleNameInput = document.getElementById('vehicle_number');
    
    vehicleNameInput.addEventListener('input', function () {
        var vehicleName = this.value;
        var regex = /^[A-Za-z0-9 ]+$/;

        if (vehicleName.length < 1 || vehicleName.length > 50 || !regex.test(vehicleName)) {
            alert("Vehicle number can only contain alphabets, numbers, and spaces, and must be between 1 and 50 characters.");
            this.value = ''; // Clear the input
        }
    });
});


    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
<?php 
mysqli_close($conn);
    }
?>
