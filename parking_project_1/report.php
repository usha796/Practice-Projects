<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "parking_project");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(!isset($_SESSION['username'])){
    header("location:login.php");
    exit();
}
// Get the current month name
$current_month = date('F');

// Calculate daily revenue
$stmt_daily = $conn->prepare("SELECT SUM(Fare) AS daily_revenue FROM vehicle_info WHERE DATE(Exit_date) = CURDATE()");
$stmt_daily->execute();
$result_daily = $stmt_daily->get_result();
$row_daily = $result_daily->fetch_assoc();
$daily_revenue = $row_daily['daily_revenue'] ?? 0;

// Calculate weekly revenue
$stmt_weekly = $conn->prepare("SELECT SUM(Fare) AS weekly_revenue FROM vehicle_info WHERE WEEK(Exit_date) = WEEK(CURDATE())");
$stmt_weekly->execute();
$result_weekly = $stmt_weekly->get_result();
$row_weekly = $result_weekly->fetch_assoc();
$weekly_revenue = $row_weekly['weekly_revenue'] ?? 0;

// Calculate monthly revenue
$stmt_monthly = $conn->prepare("SELECT SUM(Fare) AS monthly_revenue FROM vehicle_info WHERE MONTH(Exit_date) = MONTH(CURDATE())");
$stmt_monthly->execute();
$result_monthly = $stmt_monthly->get_result();
$row_monthly = $result_monthly->fetch_assoc();
$monthly_revenue = $row_monthly['monthly_revenue'] ?? 0;

// Close the prepared statements
$stmt_daily->close();
$stmt_weekly->close();
$stmt_monthly->close();

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Revenue Report</title>
    <style>
      .container{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
         
        }
        .container h1{
            margin-top: 7%;
        }
        table {
            border-collapse: collapse;
            width: 50%;
            margin-top: 2%;

        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            color:white;
        }
        th {
            background:grey;
        }
        #export {
            width: 100px;
            padding: 10px;
            border-radius: 8px;
            font-weight: 700;
        }
        #export:hover {
            background: #b96e1de6;
        }
    </style>
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

        <table id="table">
        <h1>Revenue Report - <?php echo $current_month; ?></h1>
        <tr>
            <th>Period</th>
            <th>Revenue (Rs.)</th>
        </tr>
        <tr>
            <td>Daily</td>
            <td><?php echo $daily_revenue; ?></td>
        </tr>
        <tr>
            <td>Weekly</td>
            <td><?php echo $weekly_revenue; ?></td>
        </tr>
        <tr>
            <td>Monthly</td>
            <td><?php echo $monthly_revenue; ?></td>
        </tr>
    </table>
    <input type="button" id="export" value="Export"/>
   
    </div>
    </div>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

    <script type="text/javascript">
        $("body").on("click", "#export", function () {
            html2canvas($('#table')[0], {
                onrendered: function (canvas) {
                    var dataUrl = canvas.toDataURL();
                    var data = {
                        content: [{
                            image: dataUrl,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(data).download("report.pdf");
                }
            });
        });
    </script>

</body>
</html>
