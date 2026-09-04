<?php
include("../db/dbConnection.php");

$response = ['success' => false, 'message' => ''];

header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow only POST, GET, and OPTIONS requests
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Specify allowed headers

if (isset($_POST['inchargeName']) && $_POST['inchargeName'] != '') {

    $name    = htmlspecialchars($_POST['inchargeName'], ENT_QUOTES, 'UTF-8');
    $depart  = htmlspecialchars($_POST['department'], ENT_QUOTES, 'UTF-8');
    $contact = htmlspecialchars($_POST['contact'], ENT_QUOTES, 'UTF-8');
    $url     = htmlspecialchars($_POST['url'], ENT_QUOTES, 'UTF-8');
    
    $query = "INSERT INTO `official_contact`(
                    `name`,
                    `department`,
                    `contact`,
                    `url`
                )
                VALUES(
                    '$name',
                    '$depart',
                    '$contact',
                    '$url'
                )";

    if ($conn->query($query) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Contact Details submitted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error submitting Contact: ' . $conn->error]);
    }
}

if (isset($_POST['contactId']) && $_POST['contactId'] != '') {
    $contactId = $_POST['contactId'];

      $editFetch = "SELECT
                        `contact_id`,
                        `name`,
                        `department`,
                        `contact`,
                        `url`
                    FROM
                        `official_contact`
                    WHERE
                        `contact_id` = '$contactId'";
    $fetchResult = mysqli_query($conn, $editFetch);
    
    if ($fetchResult) {
        $row = mysqli_fetch_assoc($fetchResult);

        $expenseDetails = array(
            'id'            => $row['contact_id'],
            'name'          => $row['name'],
            'department'    => htmlspecialchars_decode($row['department'], ENT_QUOTES),
            'contact'       => htmlspecialchars_decode($row['contact'], ENT_QUOTES),
            'url'           => htmlspecialchars_decode($row['url'], ENT_QUOTES)
        );
        echo json_encode($expenseDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}

if (isset($_POST['inchargeNameEdit']) && $_POST['inchargeNameEdit'] != '') {

    $id      = htmlspecialchars($_POST['editContactId'], ENT_QUOTES, 'UTF-8');
    $name    = htmlspecialchars($_POST['inchargeNameEdit'], ENT_QUOTES, 'UTF-8');
    $depart  = htmlspecialchars($_POST['departmentEdit'], ENT_QUOTES, 'UTF-8');
    $contact = htmlspecialchars($_POST['contactEdit'], ENT_QUOTES, 'UTF-8');
    $url     = htmlspecialchars($_POST['urlEdit'], ENT_QUOTES, 'UTF-8');

    $editQuery = "UPDATE
                    `official_contact`
                SET
                    `name` = '$name',
                    `department` = '$depart',
                    `contact` = '$contact',
                    `url` = '$url'
                WHERE
                    `contact_id` = '$id'";

    if ($conn->query($editQuery) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Contact Details updated successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating Contact details: ' . $conn->error]);
    }
}

if (isset($_POST['delId']) && $_POST['delId'] != '') {
    
    $contactId = $_POST['delId'];

    $deleteQuery = "UPDATE
                        `official_contact`
                    SET
                        `status` = 'Inactive'
                    WHERE
                        `contact_id` = '$contactId'";

    if ($conn->query($deleteQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Contact details Deleted successfully!";
    } else {
        $response['message'] = "Unexpected error in deleting Contact details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

?>