<?php
// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer manually
require __DIR__ . '/libs/PHPMailer/src/Exception.php';
require __DIR__ . '/libs/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/libs/PHPMailer/src/SMTP.php';

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "complaint_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$employee_code = $_POST['employee_code'];
$quarter_no = $_POST['quarter_no'];
$problem_type = $_POST['problem_type'];
$description = $_POST['description'];
$material_required = $_POST['material_required'];
$status = $_POST['status'];
$remarks = $_POST['remarks'];

$sql = "INSERT INTO complaints (name, employee_code, quarter_no, problem_type, description, material_required, status, remarks) 
        VALUES ('$name', '$employee_code', '$quarter_no', '$problem_type', '$description', '$material_required', '$status', '$remarks')";

if ($conn->query($sql) === TRUE) {
    echo "New complaint submitted successfully";

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kartikeymishra.2018871@gmail.com'; // Use the sender's email
        $mail->Password = 'cbcerkhhpdepfwan';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Recipients
        $mail->setFrom('kartikeymishra.2018871@gmail.com', 'Colony Complaint Management');
        
        if ($problem_type == 'electrical') {
            $mail->addAddress('alok.jain@adityabirla.com');
        } else {
            $mail->addAddress('ajay.pandey@adityabirla.com');
        }

        // Content
        $mail->isHTML(true);
        $mail->Subject = "New Complaint: $problem_type Issue";
        $mail->Body    = "Name: $name<br>Employee Code: $employee_code<br>Quarter No: $quarter_no<br>Problem Type: $problem_type<br>Description: $description<br>Material Required: $material_required<br>Status: $status<br>Remarks: $remarks";

        $mail->send();
        echo " Email sent successfully.";
    } catch (Exception $e) {
        echo " Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
