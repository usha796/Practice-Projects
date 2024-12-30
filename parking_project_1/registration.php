<?php
require_once("includes/classes/FormSanitizer.php");

  if(isset($_POST["submit"])){
    $username=FormSanitizer::sanitizeFormUsername($_POST["username"]);
    $pass=FormSanitizer::sanitizeFormPassword($_POST["password"]);
    $con_pass=FormSanitizer::sanitizeFormPassword($_POST["co-password"]);

    $salt="randomstring12345"; //Salt for password encryption
    $pass=sha1($salt.$pass); //Encrypting the password using sha1 
    $con_pass=sha1($salt.$con_pass);//Applying same salt to confirmation password
    
    if($pass ==  $con_pass){
        $conn= mysqli_connect("localhost","root","","parking_project") or die ("connection failed");
        $sql = "SELECT * FROM admin_info where username ='{$username}' && password ='{$pass}'";
        $result = mysqli_query($conn,$sql) or die ("query failed");
        $num = mysqli_num_rows($result);
        if($num==1){
            echo  "<script>alert('You have already exist in database');</script>";
        }
        else{
            $sql = "INSERT INTO admin_info VALUES ('{$username}', '{$pass}')";
            $result = mysqli_query($conn,$sql) or die ("query fail");
            mysqli_close($conn);
            header("location:index.php");
        }
    }else{
      echo "<script>alert('Your password and confirm password are not the same');</script>";
    }

  }


?>