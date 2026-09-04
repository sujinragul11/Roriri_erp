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
    $id =1;

                // Call the stored procedure
                $callProcedure = "CALL insert_iv_details( '$visitDate', '$department', '$batch', $studentCount, $staffCount, '$inchargeName', '$inchargePhone' ,'$id')";

            if (mysqli_query($conn, $callProcedure)) {
                    // Return success response
                    echo json_encode(['status' => 'success', 'message' => 'Visit data saved successfully!']);
                } else {
                    // Return error response if the query failed
                    echo json_encode(['status' => 'error', 'message' => 'Failed to save visit data: ' . mysqli_error($conn)]);
                }
            } else {
                // Return error if request is not POST
                echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
            }

// Close the database connection
mysqli_close($conn);
?>
