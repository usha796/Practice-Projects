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
    <title>Export</title>
    <link rel="stylesheet" href="style.css">
    <style type="text/css">
        .box {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .box .header {
            justify-content: center;
            color: white;
        }
        table {
            border: 1px solid #ccc;
            border-collapse: collapse;
            width: 52%;
            border: 0.5px solid #002a324f;
            border-radius: 3%;
            background: rgba(255, 255, 255, 0.586);
            backdrop-filter: blur;
        }
        table th {
            color: #333;
            font-weight: 600;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
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
    <script>
        function displayDateTime() {
            const today = new Date();
            const date = today.getFullYear() + '-' + 
                         String(today.getMonth() + 1).padStart(2, '0') + '-' + 
                         String(today.getDate()).padStart(2, '0');
            const time = String(today.getHours()).padStart(2, '0') + ':' + 
                         String(today.getMinutes()).padStart(2, '0') + ':' + 
                         String(today.getSeconds()).padStart(2, '0');
            const dateTime = 'Printed on: ' + date + ' ' + time;
            document.getElementById('current-date').innerText = dateTime;
            document.getElementById('printed-by').innerText = 'Printed by: <?php echo htmlspecialchars($_SESSION['username']); ?>';
        }
        window.onload = displayDateTime;
    </script>
</head>
<body>
    <div class="box">
        <h1 class="header">Parking Receipt</h1><br>
        <table id="employee" cellspacing="0" cellpadding="0">
            <tr>
                <th colspan="2" style="text-align:center; padding-bottom:15px;">
                    Parking Receipt
                    <p id="current-date" style="text-align: right; padding-top:15px;"></p>
                    <p id="printed-by" style="text-align: right; padding-top:6px; padding-right:10px;"></p>
                </th>
            </tr>
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
                <th colspan="2">
                    Owner Name: <?php echo htmlspecialchars($row['Owner_name']); ?> <br>
                    Vehicle Name: <?php echo htmlspecialchars($row['Vehicle_name']); ?> 
                    <span style="padding-left:300px;">
                        Vehicle Number: <?php echo htmlspecialchars($row['Vehicle_number']); ?>
                    </span>
                </th>
            </tr>
            <tr>
                <th>Token</th>
                <td><?php echo htmlspecialchars($row['Token_number']); ?></td>            
            </tr>
            <tr>
                <th>Entry Date</th>
                <td><?php echo htmlspecialchars($row['Entry_date']); ?></td>
            </tr>
            <tr>
                <th>Exit Date</th>
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
        <br />
        <input type="button" id="export" value="Export"/>
    </div>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

    <script type="text/javascript">
        $("body").on("click", "#export", function () {
            html2canvas($('#employee')[0], {
                onrendered: function (canvas) {
                    var dataUrl = canvas.toDataURL();
                    var data = {
                        content: [{
                            image: dataUrl,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(data).download("receipt.pdf");
                }
            });
        });
    </script>
</body>
</html>
