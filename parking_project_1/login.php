<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> Car Parking</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="box">
        <div class="header" style="text-align: center;">
                <div class="title">
                    <h4 style="display: inline-block;">Parking Lot<br>Management System</h4>
                </div>
        </div>
        <div class="container">
            <div class="register">
                <h2>Admin Login</h2>
                <form action="validate.php" method="post">
                    <div class="input-container">
                        <div class="input-group">
                            <span class="input-label">Username:</span>
                            <input type="text" name="username" placeholder="Username" class="form-control" required>
                        </div>
                        <div class="input-group">
                            <span class="input-label">Password:</span>
                            <input type="password" name="password" placeholder="Password" class="form-control" required>
                        </div>
                    </div>
                    <div class="btn">
                        <input type="submit" class="btnbox" name="submit" value="LOGIN">
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