<?php
header('Content-Type: application/json');

// Database connection
include("../../db/dbConnection.php"); // Ensure you include your DB connection file

$response = ['success' => false, 'message' => ''];
// Check for phone and email validation
if (isset($_POST['phone']) || isset($_POST['email'])) {
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    $validateQuery = "SELECT * FROM basic_details WHERE (phone = '$phone' OR email = '$email') AND status='Active' ";
    $validateResult = mysqli_query($conn, $validateQuery);

    if ($validateResult) {
        $phoneExists = false;
        $emailExists = false;

        while ($row = mysqli_fetch_assoc($validateResult)) {
            if ($row['phone'] === $phone) {
                $phoneExists = true;
            }
            if ($row['email'] === $email) {
                $emailExists = true;
            }
        }

        if ($phoneExists || $emailExists) {
            $response['success'] = false;
            $response['message'] = 'Phone number or Email already exists.';
            $response['phoneExists'] = $phoneExists;
            $response['emailExists'] = $emailExists;
        } else {
            $response['success'] = true;
            $response['message'] = 'Phone number and Email are available.';
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'Database query failed: ' . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}
?>