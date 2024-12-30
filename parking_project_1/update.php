<?php
session_start();
$updated_by = $_SESSION["username"];
$ID = $_GET['ID'];

$conn = mysqli_connect("localhost", "root", "", "parking_project") or die("Connection failed");
$sql = "SELECT * FROM vehicle_info where ID='{$ID}' ";
$result = mysqli_query($conn, $sql) or die("Query Failed");
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
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
            <li><a href="logout.php">Logout '<?php echo $_SESSION['username']; ?>'</a></li>
        </ul>
    </div>
    <div class="container">
        <div class="register">
            <h2>Update exit-date form</h2>
            <form action="update_save.php?ID=<?php echo $ID; ?>" method="post" onsubmit="return validateDate()">
                <div class="input-container">
                    <div class="input-group">
                        <span class="input-label">Vehicle Owner Name:</span>
                        <input type="text" name="owner_name" value="<?php echo $row['Owner_name'];?>" class="form-control" required>
                    </div>
                    <div class="input-group">
                        <span class="input-label">Vehicle Name:</span>
                        <input type="text" name="vehicle_name" value="<?php echo $row['Vehicle_name'];?>" class="form-control" required>
                    </div>
                    <div class="input-group">
                        <span class="input-label">Vehicle Number:</span>
                        <input type="text" name="vehicle_number" value="<?php echo $row['Vehicle_number'];?>" class="form-control" required>
                    </div>
                    <div class="input-group">
                        <span class="input-label">Entry Date</span>
                        <input type="datetime-local" name="entry_date" id="entry_date" value="<?php echo $row['Entry_date'];?>" id="entry_date" class="form-control" required>
                    </div>
                    <div class="input-group">
                        <span class="input-label">Exit Date</span>
                        <input type="datetime-local" name="exit_date" id="exit_date"  class="form-control" required>
                        <script ></script>
                    </div>
                    <div class="input-group">
                        <span class="input-label">Token Number</span>
                        <input type="number" name="token"  value="<?php echo $row['Token_number'];?>" class="form-control" required>
                    </div>
                    <div class="input-group">
                        <span class="input-label">Charge</span>
                        <?php 
                        $currentCharge = $row['Charge'];
                        $options = ['Daily', 'Monthly'];
                        ?>
                        <select class="form-control" name="charge" required>
                            <?php foreach ($options as $option): ?>
                                <option value="<?php echo htmlspecialchars($option); ?>" 
                                    <?php echo ($currentCharge == $option) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($option); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="btn">
                    <input type="submit" class="btnbox" name="submit" value="SUBMIT">
                </div>  
            </form>
        </div>
    </div>
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
<script>
    // // Get the input elements
    var entryDateInput = document.getElementById('entry_date');
    var exitDateInput = document.getElementById('exit_date');

    // Add an event listener for input change
    exitDateInput.addEventListener('input', function () {
        // Get the value of the input
        var enteredExitDateTime = new Date(this.value);
        var enteredEntryDateTime = new Date(entryDateInput.value);
        var currentDateTime = new Date();

        // Compare the entered date with the current date
        if (enteredExitDateTime > currentDateTime || enteredExitDateTime < enteredEntryDateTime) {
            // If entered date is in the future or before entry date, show an alert and clear the input
            alert("Exit date cannot exceed the current date and time or be before the entry date.");
            this.value = ''; // Clear the input
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
    var exitDateInput = document.getElementById('exit_date');
    
    // Get the current date and time
    var currentDateTime = new Date();
    
    // Format the date and time as YYYY-MM-DDTHH:MM for the datetime-local input
    var formattedDateTime = currentDateTime.toISOString().slice(0, 16);
    
    // Set the value of the input to the current date and time
    exitDateInput.value = formattedDateTime;
});
</script>
</html>
<?php
    }
} else {
    echo  "No Data Found";
}
?>
