<?php
session_start();

include("../../db/dbConnection.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Add Room
if (isset($_POST['roomName']) && $_POST['roomName'] != '') {
    
    $roomName = htmlspecialchars($_POST['roomName'], ENT_QUOTES, 'UTF-8');
   
    $insQuery = "INSERT INTO `room_tbl`(`room_name`) VALUES ('$roomName')";

   if ($conn->query($insQuery) === TRUE) {
    $response['success'] = true;
    $response['message'] = "Room details added successfully!";
    } else {
    $response['message'] = "Unexpected error in adding Room details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

// Edit Room
if (isset($_POST['roomId']) && $_POST['roomId'] != '') {
    
    $roomId     = $_POST['roomId'];
    $editName = htmlspecialchars($_POST['editName'], ENT_QUOTES, 'UTF-8');
   
    $updateQuery = "UPDATE
                        `room_tbl`
                    SET
                        `room_name` = '$editName'
                    WHERE
                        `room_id` = '$roomId'";

   if ($conn->query($updateQuery) === TRUE) {
    $response['success'] = true;
    $response['message'] = "Room details updated successfully!";
    } else {
    $response['message'] = "Unexpected error in updating Room details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

// Delete Room
if (isset($_POST['delId']) && $_POST['delId'] != '') {
    
    $roomId     = $_POST['delId'];

    $deleteQuery = "UPDATE
                        `room_tbl`
                    SET
                        `room_status` = 'Inactive'
                    WHERE
                        `room_id` = '$roomId'";

   if ($conn->query($deleteQuery) === TRUE) {
    $response['success'] = true;
    $response['message'] = "Room details Deleted successfully!";
    } else {
    $response['message'] = "Unexpected error in deleting Room details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}
?>