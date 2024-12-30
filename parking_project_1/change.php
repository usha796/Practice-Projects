<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin form</title>
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
                <li><a href="change.php">Change</a></li>
                <li><a href="admin.php">Create Parking admin</a></li>
                <li><a href="logout.php">Logout '<?php echo $_SESSION['username']; ?>'</a></li>
            </ul>
        </div>
        <div class="container">
            <div class="register">
                <h2>Make changes</h2>
                <form action=".php" method="post">
                    <!-- <div class="input-container">
                        <div class="input-group">
                            <span class="input-label">Username:</span>
                            <input type="text" name="username" placeholder="Username" class="form-control" required>
                        </div>
                        <div class="input-group">
                            <span class="input-label">Password:</span>
                            <input type="password" name="password" placeholder="Password" class="form-control" required>
                        </div>
                        <div class="input-group">
                            <span class="input-label">Confirm Password:</span>
                            <input type="password" name="co-password" placeholder="Confirm Password" class="form-control" required>
                        </div>
                    </div> -->
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

</html>
