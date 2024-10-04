<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "complaint_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch complaints data
$sql = "SELECT * FROM complaints";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor Summary Sheet</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h2>Monitor Summary Sheet</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Employee Code</th>
            <th>Quarter No</th>
            <th>Problem Type</th>
            <th>Description</th>
            <th>Material Required</th>
            <th>Status</th>
            <th>Remarks</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['employee_code']}</td>
                        <td>{$row['quarter_no']}</td>
                        <td>{$row['problem_type']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['material_required']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['remarks']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No complaints found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
