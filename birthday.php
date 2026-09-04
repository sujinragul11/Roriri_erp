<?php 

// Include PHPMailer library
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database connection
include("db/dbConnection.php");

// Get current date
$currentDate = date('Y-m-d');

// Query to check if anyone has a birthday today
$sql = "SELECT id, name, email 
        FROM basic_details 
        WHERE dob IS NOT NULL 
          AND dob != ''
          AND DATE_FORMAT(dob, '%m-%d') = DATE_FORMAT(CONVERT_TZ(NOW(), '+00:00', '+05:30'), '%m-%d')";
$result = $conn->query($sql);

// Function to send the email
function sendBirthdayEmail($recipientEmail, $recipientName, $ccEmails) {
    $mail = new PHPMailer(true);

    try {
    $mail->isSMTP();
    $mail->SMTPDebug = 3; // Enable verbose debug output

    $mail->Host = '92.205.4.188';
    $mail->SMTPAuth = true;
    $mail->Username = 'admin@roririsoft.com';
    $mail->Password = 'Admin@Roririsoft.com';
    $mail->SMTPSecure = 'ssl'; // Or 'ssl' for port 465
    $mail->Port = 465; // Or 465 for SSL
    
    // Disable SSL certificate validation (if needed)
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

        // Sender info
        $mail->setFrom('admin@roririsoft.com', 'Roriri Software Solutions Pvt. Ltd.');

        // Recipient
        $mail->addAddress($recipientEmail, $recipientName);

        // CC the other recipients
        foreach ($ccEmails as $ccEmail) {
            if (filter_var($ccEmail, FILTER_VALIDATE_EMAIL)) {
                $mail->addCC($ccEmail);
            } else {
                echo "Invalid CC email: $ccEmail\n";
            }
        }

        // Dynamic content
        $mail->isHTML(true);
        $mail->Subject = 'Happy Birthday, ' . $recipientName . '!';
        $mail->Body    = "<h1>Happy Birthday, $recipientName!</h1><p>We hope you have a fantastic day!</p>";
        $mail->AltBody = "Happy Birthday, $recipientName! We hope you have a fantastic day!";

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Logic to handle email sending and database insertion
if ($result->num_rows > 0) {
    while ($birthdayPerson = $result->fetch_assoc()) {
        $birthdayEmail = $birthdayPerson['email'];
        $birthdayName = $birthdayPerson['name'];
        
        // Get all other users for CC
        $ccSql = "SELECT email FROM basic_details WHERE status = 'Active' AND id != " . $birthdayPerson['id'];
        $ccResult = $conn->query($ccSql);
        
        $ccEmails = [];
        while ($ccRow = $ccResult->fetch_assoc()) {
            if (!empty($ccRow['email']) && filter_var($ccRow['email'], FILTER_VALIDATE_EMAIL)) {
                $ccEmails[] = $ccRow['email'];
            }
        }

        // Debugging output
        echo "Birthday Email: $birthdayEmail\n";
        echo "Birthday Name: $birthdayName\n";

        // Send the email
        sendBirthdayEmail($birthdayEmail, $birthdayName, $ccEmails);

        // Insert into the log table (commented out for now)
        // $logSql = "INSERT INTO birthday_log (user_id, message, log_date) VALUES (" . $birthdayPerson['id'] . ", 'Happy Birthday to " . $birthdayName . "', NOW())";
        // $conn->query($logSql);
    }
} else {
    // No one has a birthday, insert log message
    // $logSql = "INSERT INTO birthday_log (user_id, message, log_date) VALUES (NULL, 'No one has a birthday today', NOW())";
    // $conn->query($logSql);
    echo "No one has a birthday today";
}

?>
