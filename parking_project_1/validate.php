<?php
	session_start();
	require_once("includes/classes/FormSanitizer.php");


	$name =  FormSanitizer::sanitizeFormOwnerName($_POST["username"]);
	$pass = $_POST["password"];
	$salt="randomstring12345"; //Salt for password encryption
	$pass=sha1($salt.$pass); //Encrypting the password using sha1 

	$conn = mysqli_connect("localhost", "root", "", "parking_project") or die("Connection failed");
	$sql = "SELECT * FROM admin_info WHERE username = '{$name}' AND password = '{$pass}'";
	$result = mysqli_query($conn, $sql) or die("Query failed");

	$num = mysqli_num_rows($result);
	if ($num == 1) {
		$_SESSION["username"] = $name;
		// echo "<script>alert('Username and password is correct!'); window.location.href='login.php';</script>";
		echo "<script>window.location.href='index.php';</script>";
		// header("location: index.php");
		exit();
	} else {
		echo "<script>alert('Username or password is incorrect!'); window.location.href='login.php';</script>";
		// header("location: login.php");
		exit();
	}
	mysqli_close($conn);
?>
