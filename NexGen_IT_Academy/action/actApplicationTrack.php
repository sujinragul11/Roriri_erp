<?php
include("../../db/dbConnection.php");


session_start();
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Handle adding ledger data
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addApplicationTrack') {
    
    $application_status = htmlspecialchars($_POST['application_status'], ENT_QUOTES, 'UTF-8');
    $app_id = htmlspecialchars($_POST['app_id'], ENT_QUOTES, 'UTF-8');

    if(isset($_POST['traineeId']) && $_POST['traineeId'] != ''){
        $user_id = $_POST['traineeId'];
        $verified_id = $_SESSION['id'];
    }else{
        $user_id = $_SESSION['id'];
        $verified_id = $user_id;
    }
    // $user_id = $_SESSION['id'];
    $role =$_SESSION['role'];
    // Set the timezone to Indian Standard Time (IST)
    date_default_timezone_set('Asia/Kolkata');

    // New data to be added as a log entry
    $new_details = array(
        "user_id" => $user_id,
        "app_id" => $app_id,
        "verified_id" => $verified_id,
        "role" => $role,
        "status" => $application_status,
        "array_id" => uniqid(), // Adding a unique identifier to differentiate arrays
        "timestamp" => date("Y-m-d H:i:s") // Timestamp with date and time in IST
    );

    // First, check if the student ID already exists in the application_track table
    $check_sql = "SELECT `application_details` FROM `application_track` WHERE `student_id` = '$user_id'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // If the student ID exists, fetch the existing data
        $existing_data = $check_result->fetch_assoc();
        $existing_details = json_decode($existing_data['application_details'], true);

        // Ensure existing details is an array
        if (!is_array($existing_details)) {
            $existing_details = [];
        }

        // Append the new log entry to the existing details array
        $existing_details[] = $new_details;

        // Encode the combined data back to JSON format
        $json_details = json_encode($existing_details);

        // Update the existing record with the combined data
        $update_sql = "UPDATE `application_track` SET `application_details` = '$json_details' WHERE `student_id` = '$user_id'";
        if ($conn->query($update_sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = "Application track updated successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "Error updating application track: " . $conn->error;
        }
    } else {
        // If the student ID does not exist, insert a new record with the new data as the first entry
        $json_details = json_encode([$new_details]); // Initialize as an array with the new entry
        $insert_sql = "INSERT INTO `application_track`(`student_id`, `application_details`) VALUES ('$user_id', '$json_details')";
        if ($conn->query($insert_sql) === TRUE) {
            $response['success'] = true;
            $response['message'] = "Application track added successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "Error adding application track: " . $conn->error;
        }
    }

    echo json_encode($response);
    exit();
}


//----Handle adding a Ledger data add -- end ------------------------







            // Default response if no action specified
            $response['message'] = "Invalid action specified.";
            echo json_encode($response);
            exit();

