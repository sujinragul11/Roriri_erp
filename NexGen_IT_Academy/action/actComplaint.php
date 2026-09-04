<?php
// include("C:\\xampp\\htdocs\\RORIRI_ERP\\db\\dbConnection.php");
session_start();
include("../../db/dbConnection.php");
include "../class.php";
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Add Employee
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addComplaint') {
    // Sanitize and retrieve input
    $trainerNames = $_POST['trainerName'];  // This is an array
    $complaint = htmlspecialchars($_POST['complaint']); // Sanitize complaint text
    
    $from_id = $_SESSION['id'];

    // Convert trainerName array to JSON string for storing in DB
    $trainerNamesJSON = json_encode($trainerNames);

    // Insert into database
    $insQuery = "INSERT INTO `complaint_tbl`
                                (`com_from`, `com_to`, `com_details`) 
                                VALUES 
                                ('$from_id', '$trainerNamesJSON', '$complaint')";

    if ($conn->query($insQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Complaint details added successfully!";
    } else {
        $response['message'] = "Unexpected error in adding Complaint details! " . $conn->error;
    }

    echo json_encode($response);
    exit();
}

//Handles Update the clients details
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'editComplaint') {

    $complantId = $_POST['complantId'];
    $complaintReply = $_POST['complaintReply'];
    $currentDate = date('Y-m-d');

    // Corrected SQL query: Removed the extra comma
    $UpdateClient = "UPDATE `complaint_tbl`
    SET 
    `com_reply` = '$complaintReply',
    `reply_date` = '$currentDate'
    WHERE `com_id` = '$complantId'";

    $editResClient = mysqli_query($conn, $UpdateClient);

    if ($editResClient) {
        $_SESSION['message'] = "Complaint details updated successfully!";
        $response['success'] = true;
        $response['message'] = "Complaint details updated successfully!";
    } else {
        $response['success'] = false;
        $response['message'] = "Error updating database: " . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}


//Handles Fetching the Clients details for editing 
if (isset($_POST['editIdComplaint']) && $_POST['editIdComplaint'] != '') {
    $editId = $_POST['editIdComplaint'];

    $clientFetch="SELECT `com_id`, `com_from`, `com_to`, `com_details` FROM complaint_tbl WHERE com_id='$editId'";
    $fetchResult = mysqli_query($conn, $clientFetch);
    
    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);
        
        $clientDetails = array(
            'com_id' => $row['com_id'],
            'com_from' => $row['com_from'],
            'com_to' => $row['com_to'],
            'com_details' => $row['com_details']


        );
        echo json_encode($clientDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}


//---view page --------------------

//Handles Fetching the Clients details for editing 
if (isset($_POST['viewComplaint']) && $_POST['viewComplaint'] != '') {
    $editId = $_POST['viewComplaint'];

    $clientFetch="SELECT `com_id`, `com_from`, `com_to`, `com_details` ,`reply_date` ,`com_reply` FROM complaint_tbl WHERE com_id='$editId'";
    $fetchResult = mysqli_query($conn, $clientFetch);
    
    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);
        $com_to             = $row['com_to'];  
      
        // Decode JSON string into an array
        $com_to_ids = json_decode($com_to, true);  // Assuming $com_to is a JSON string

        // Convert the array of IDs into a comma-separated string
        $idString = '';
        if (!empty($com_to_ids)) {
            $idString = implode(', ', $com_to_ids);  // Convert IDs to a comma-separated string
        }

         // Check if the date is invalid and reset it if necessary
         if ($formattedDate == '30-11-0001') {
            $formattedDate = '';
        }
    
        $clientDetails = array(
            'com_id' => $row['com_id'],
            'com_from' => userNameOnly($row['com_from']),
            'com_to' => htmlspecialchars(userTrainerOnly($idString)),
            'com_details' => $row['com_details'],
            'reply_date' => $row['reply_date'],
            'com_reply' => $row['com_reply'],


        );
        echo json_encode($clientDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}



//Handles Deleting the client

if (isset($_POST['clientdeleteId'])) {
    $id = $_POST['clientdeleteId'];
    $queryDel = "UPDATE `client_tbl` SET client_status='Inactive'
    WHERE client_id='$id'";
    $reDel = mysqli_query($conn, $queryDel);

    if ($reDel) {
        $_SESSION['message'] = "Client details have been deleted successfully!";
        $response['success'] = true;
        $response['message'] = "Client details have been deleted successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in deleting Employee details!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}
