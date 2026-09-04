<?php
session_start();
// include("C:\xampp\htdocs\RORIRI_ERP\db\dbConnection.php");
include("../../db/dbConnection.php");
header('Content-Type: application/json');
include "../class.php";

$response = ['success' => false, 'message' => ''];

if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addDepartment') {
    $dept_id = $_POST['dept_id'];
    $newCoordinatorIds = $_POST['coordinatorName']; // Selected coordinators
    $id = $_SESSION['id'];

    // Set the timezone to Asia/Kolkata
    date_default_timezone_set('Asia/Kolkata');

    // Fetch existing coordinators from the database
    $existingQuery = "SELECT `log` FROM `coordinator` WHERE `id` = '$dept_id'";
    $existingResult = $conn->query($existingQuery);
    $existingCoordinators = [];

    if ($existingResult && $existingResult->num_rows > 0) {
        $row = $existingResult->fetch_assoc();
        $existingCoordinators = json_decode($row['log'], true); // Decode JSON log into an array
    }

    $updatedCoordinators = [];

    // Process existing coordinators
    foreach ($existingCoordinators as $coordinator) {
        // Check if the coordinator is in the new selection
        if (in_array($coordinator['id'], $newCoordinatorIds)) {
            // If they are selected again, keep them as is
            $updatedCoordinators[] = $coordinator;
        } else {
            // If removed, change status to inactive
            $coordinator['status'] = 'inactive';
            $coordinator['change_time'] = date('Y-m-d H:i:s');
            $updatedCoordinators[] = $coordinator; // Keep record with status updated
        }
    }

    // Add new coordinators who are selected
    foreach ($newCoordinatorIds as $newCoordinatorId) {
        // Check if the coordinator is already in the updated list
        $exists = false;
        foreach ($updatedCoordinators as $coordinator) {
            if ($coordinator['id'] == $newCoordinatorId && $coordinator['status'] === 'active') {
                $exists = true; // Already exists as active
                break;
            }
        }

        // If the coordinator is not in the active list, add as new entry
        if (!$exists) {
            $newCoordinator = [
                'id' => $newCoordinatorId,
                'assign_time' => date('Y-m-d H:i:s'),
                'change_time' => null,
                'status' => 'active',
                'alter_by' => $id
            ];
            $updatedCoordinators[] = $newCoordinator;
        }
    }

    // Convert updated coordinators list to JSON format
    $updatedCoordinatorsJson = json_encode($updatedCoordinators);

    // Update the log in the database
    $updateQuery = "UPDATE `coordinator` 
                    SET `log` = '$updatedCoordinatorsJson'
                    WHERE `id` = '$dept_id'";

    if ($conn->query($updateQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Coordinator details updated successfully!";
    } else {
        $response['message'] = "Error updating coordinator details! " . $conn->error;
    }

    // Return the response
    echo json_encode($response);
    exit();
}

    // Edit data and load coordinator name
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'getDepartmentDetails') {

    $dept_id = $_POST['dept_id'];

    // Query to get the department and coordinator details
    $query = "SELECT `log`, `roles_res` FROM `coordinator` WHERE `id` = '$dept_id'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Fetch the log data and roles_res
        $row = $result->fetch_assoc();
        $log = json_decode($row['log'], true); // Decode the JSON log data
        $roles_res = $row['roles_res']; // Fetch the roles_res data

        // Prepare response with the details
        $response = [
            'success' => true,
            'coordinator' => $log,        // Log details as JSON array
            'roles_res' => $roles_res     // Add roles_res to the response
        ];
    } else {
        $response = [
            'success' => false,
            'message' => "No coordinator details found for this department!"
        ];
    }

    echo json_encode($response);
    exit();
}


if (isset($_POST['viewId']) && $_POST['viewId'] != '') {

    $dept_id = $_POST['viewId'];

    // Query to get the department and coordinator details
    $queryView = "SELECT `name`, `log`, `roles_res` FROM `coordinator` WHERE `id` = '$dept_id'";
    $resultView = $conn->query($queryView);

    if ($resultView->num_rows > 0) {
        // Fetch the log data and roles_res
        $row = $resultView->fetch_assoc();
        $name = $row['name'];
        $log = json_decode($row['log'], true); // Decode the JSON log data
        $roles_res = $row['roles_res']; // Fetch the roles_res data

        // Initialize an empty string to hold active coordinator IDs
        $idString = '';

        // Check if the log is a valid array and contains coordinators
        if (is_array($log)) {
            // Filter coordinators with 'status' == 'active'
            $activeCoordinators = array_filter($log, function($coordinator) {
                return isset($coordinator['status']) && $coordinator['status'] === 'active';
            });

            // Extract the IDs of active coordinators
            $coordinatorIds = array_column($activeCoordinators, 'id');
            
            // Convert the IDs array to a comma-separated string
            if (!empty($coordinatorIds)) {
                $idString = implode(', ', $coordinatorIds);
            }
        }

        // Prepare response with the details
        $response = [
            'success' => true,
            'dept' => $name,
            'coordinator' => userNameOnly($idString),        // Log details as JSON array
            'roles_res' => $roles_res     // Add roles_res to the response
        ];
    } else {
        $response = [
            'success' => false,
            'message' => "No coordinator details found for this department!"
        ];
    }

    echo json_encode($response);
    exit();
}

if (isset($_POST['hisId'])) {
    $coordinatorId = $_POST['hisId'];

    // Query to fetch the coordinator's history
    $query = "SELECT `id`, `name`, `log` FROM `coordinator` WHERE `id` = ?";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $coordinatorId);  // Bind the ID parameter
        $stmt->execute();
        $result = $stmt->get_result();
        
        $history = [];

        // Fetch the data and prepare it for JSON response
        while ($row = $result->fetch_assoc()) {
            $log = json_decode($row['log'], true); // Decode the JSON log data

            // Convert IDs to names
            foreach ($log as &$entry) {
                $entry['user_name'] = userNameOnly($entry['id']); // Add user name to each log entry
            }
            $history[] = $row;
            $history[count($history) - 1]['log'] = $log; // Update log with user names
        }

        // Return the data as a JSON object
        echo json_encode([
            'success' => true,
            'data' => $history
        ]);
    } else {
        // In case of error
        echo json_encode([
            'success' => false,
            'message' => 'Query failed'
        ]);
    }
} else {
    // No ID was passed in the request
    echo json_encode([
        'success' => false,
        'message' => 'No ID provided'
    ]);
}

?>

