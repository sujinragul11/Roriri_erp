<?php
// Include the database connection file
include("../../db/dbConnection.php");

header('Content-Type: application/json'); // Set content type to JSON

// Check if the request is POST and contains all the required fields
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get data from the AJAX request and sanitize it
    $visitDate = mysqli_real_escape_string($conn, $_POST['visitDate']);
    $department = mysqli_real_escape_string($conn, trim($_POST['department']));
    $batch = mysqli_real_escape_string($conn, trim($_POST['batch']));
    $studentCount = (int)$_POST['studentCount'];
    $staffCount = (int)$_POST['staffCount'];
    $inchargeName = mysqli_real_escape_string($conn, trim($_POST['inchargeName']));
    $inchargePhone = mysqli_real_escape_string($conn, trim($_POST['inchargePhone']));

    // Validate fields (e.g., phone number must be 10 digits)
    if (strlen($inchargePhone) != 10 || !ctype_digit($inchargePhone)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid phone number.']);
        exit;
    }

    // Example: Insert into database (assuming you have a table called 'visits')
    $insertQuery = "INSERT INTO visits (iv_date, department, batch, stu_count, staff_count, incharge_name, incharge_phone ,iv_status)
                    VALUES ('$visitDate', '$department', '$batch', $studentCount, $staffCount, '$inchargeName', '$inchargePhone' , 'Not Approved')";

    if (mysqli_query($conn, $insertQuery)) {
        // Return success response
        echo json_encode(['status' => 'success', 'message' => 'Visit data saved successfully!']);
    } else {
        // Return error response if the query failed
        echo json_encode(['status' => 'error', 'message' => 'Failed to save visit data.']);
    }
} else {
    // Return error if request is not POST
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}

// Close the database connection
mysqli_close($conn);
?>
