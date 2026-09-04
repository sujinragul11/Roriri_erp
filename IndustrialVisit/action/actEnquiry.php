<?php
include("../../db/dbConnection.php");
// header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow only POST, GET, and OPTIONS requests
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Specify allowed headers

// Check if the form data is sent via POST method
if (isset($_POST['name']) && $_POST['name'] != '') {

    // Retrieve form data
    $college_name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone']);
    $date = trim($_POST['date']);
    $description = trim($_POST['description']);

    // Sanitize inputs to avoid SQL injection
    $college_name = $conn->real_escape_string($college_name);
    $email = $conn->real_escape_string($email);
    $phone_number = $conn->real_escape_string($phone_number);
    $date = $conn->real_escape_string($date);
    $description = $conn->real_escape_string($description);

    // Insert the form data into the database
    $query = "INSERT INTO iv_enquiry_tbl (college_name, email, phone_number, enquiry_date, description) 
              VALUES ('$college_name', '$email', '$phone_number', '$date', '$description')";

    // Execute the query
    if ($conn->query($query) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Enquiry submitted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error submitting enquiry: ' . $conn->error]);
    }

    // Close the database connection
    $conn->close();
}

if (isset($_POST['editEnquiryId']) && $_POST['editEnquiryId'] !== '') {
    
    $id = $_POST['editEnquiryId'];
        
    $enqFetchquery = "SELECT
                        `id`,
                        `college_name`,
                        `email`,
                        `phone_number`,
                        `enquiry_date`,
                        `description`
                    FROM
                        `iv_enquiry_tbl`
                    WHERE
                        `id` = '$id'"; 
                
    $resultEnq = $conn->query($enqFetchquery);
    
    $enquiryDetails = [];
    if ($resultEnq) {
        while ($row = $resultEnq->fetch_assoc()) {
            $enquiryDetails =array(
             'id' => $row['id'],
             'name' => $row['college_name'],
             'phone' => $row['phone_number'],
             'email' => $row['email'],
             'date' => $row['enquiry_date'],
             'descriptionEdit' => $row['description']
            );
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($enquiryDetails);
    exit();
}

if (isset($_POST['nameEdit']) && $_POST['nameEdit'] !== '') {
    $enquiry_id     = htmlspecialchars($_POST['enquiryId'], ENT_QUOTES, 'UTF-8');
    $college_name   = htmlspecialchars($_POST['nameEdit'], ENT_QUOTES, 'UTF-8');
    $email          = htmlspecialchars($_POST['emailEdit'], ENT_QUOTES, 'UTF-8');
    $phone_number   = htmlspecialchars($_POST['phoneEdit'], ENT_QUOTES, 'UTF-8');
    $date           = htmlspecialchars($_POST['dateEdit'], ENT_QUOTES, 'UTF-8');
    $description    = htmlspecialchars($_POST['descriptionEdit'], ENT_QUOTES, 'UTF-8');

        $enqEditQuery = "UPDATE
                            `iv_enquiry_tbl`
                        SET
                            `college_name` = '$college_name',
                            `phone_number` = '$phone_number',
                            `email` = '$email',
                            `enquiry_date` = '$date',
                            `description` = '$description'
                        WHERE
                            `id` = '$enquiry_id'";
                                    
        if ($conn->query($enqEditQuery) === TRUE) {
            $response['success'] = true;
            $response['message'] = "Enquiry details Updated successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "Unexpected error in updating Enquiry details! " . $conn->error;
        }

    echo json_encode($response);
    exit();
}

if (isset($_POST['delId']) && $_POST['delId'] != '') {
    
    $enqId = $_POST['delId'];

    $deleteQuery = "UPDATE
                        `iv_enquiry_tbl`
                    SET
                        `status` = 'Inactive'
                    WHERE
                        `id` = '$enqId'";

    if ($conn->query($deleteQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Enquiry details Deleted successfully!";
    } else {
        $response['message'] = "Unexpected error in deleting Enquiry details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

?>