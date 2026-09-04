<?php
header('Content-Type: application/json');

// Database connection
// include("C:\\xampp\\htdocs\\RORIRI_ERP\\db\\dbConnection.php"); // Ensure you include your DB connection file
include("../../db/dbConnection.php");
$response = ['success' => false, 'message' => ''];
// Check for phone and email validation
if (isset($_POST['phone']) || isset($_POST['pemail'])) {
    $phone = $_POST['phone'];
    $email = $_POST['pemail'];

    $validateQuery = "SELECT a.phone, a.email FROM basic_details AS a LEFT JOIN additional_details AS b ON a.id = b.basic_id WHERE a.phone = '$phone' AND a.email = '$email' AND b.role != 10";
    $validateResult = mysqli_query($conn, $validateQuery);

    if ($validateResult) {
        if (mysqli_num_rows($validateResult) > 0) {
            $row = mysqli_fetch_assoc($validateResult);
            $response['success'] = false;
            $response['message'] = 'Phone number or Email already exists.';
            if ($row['phone'] === $phone) {
                $response['phoneExists'] = true;
            }
            if ($row['email'] === $email) {
                $response['emailExists'] = true;
            }
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