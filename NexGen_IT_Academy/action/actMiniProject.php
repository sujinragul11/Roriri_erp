<?php
session_start();
include("../../db/dbConnection.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Check if the form has been submitted
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addProject') {
    // Retrieve form data
    $course = $_POST['course'];
    $projectName = htmlspecialchars($_POST['projectName']);
    $duration = htmlspecialchars($_POST['duration']);
    $description = htmlspecialchars($_POST['description']);
    $userId = $_SESSION['id'];
    // SQL query to insert data
    $query = "INSERT INTO trainee_mini_project (course_id, project_name, duration, description, updated_by) 
              VALUES ('$course', '$projectName','$duration','$description', '$userId')";  
    $res = mysqli_query($conn, $query);
    
    // Check query result and set response message
    if ($res) {
        $_SESSION['message'] = "Mini Project added successfully!";
        $response['success'] = true;
        $response['message'] = "Mini Project added successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in adding Mini Project!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }
    // Return response as JSON
    echo json_encode($response);
    exit();
}
// Handle updating Task details
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'hdnEditProject') {
    
    $editId = $_POST['editId'];
    $courseEdit = $_POST['courseEdit'];
    $projectName = htmlspecialchars($_POST['projectNameEdit']);
    $duration = htmlspecialchars($_POST['durationEdit']);
    $description = htmlspecialchars($_POST['descriptionEdit']);
    $userId = $_SESSION['id'];

    $editQuery1 = "UPDATE trainee_mini_project SET 
                        course_id = '$courseEdit',
                        project_name = '$projectName',
                        duration = '$duration',
                        description = '$description', 
                        updated_by = '$userId'
                    WHERE 
                        project_id = '$editId';
    ";
    
    $editRes = mysqli_query($conn, $editQuery1);

    if ($editRes) {
        $_SESSION['message'] = "Mini Project details updated successfully!";
        $response['success'] = true;
        $response['message'] = "Mini Project details updated successfully!";
    } else {
        $response['success'] = false;
        $response['message'] = "Error: " . mysqli_error($conn);
    }
    
    echo json_encode($response);
    exit();
}


// ajax edit course
// Handle fetching Tak details for editing
if (isset($_POST['editId']) && $_POST['editId'] != '') {
    $fetchId = mysqli_real_escape_string($conn, $_POST['editId']);

    $selQuery = "SELECT * FROM trainee_mini_project WHERE project_id = $fetchId";
    $result = mysqli_query($conn, $selQuery);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        $studentDetails = array(
            'project_id' => $row['project_id'],
            'course_id' => $row['course_id'],
            'project_name' => $row['project_name'],
            'duration' => $row['duration'],
            'description' => $row['description']
        ); 

        echo json_encode($studentDetails);
    } else {
        $response = array('message' => "Error executing query: " . mysqli_error($conn));
        echo json_encode($response);
    }
    exit();
}

// Handle deleting a Task
if (isset($_POST['deleteId'])) {
    $id = $_POST['deleteId'];
    $queryDel = "UPDATE `trainee_mini_project` 
    SET status = 'Inactive'
    WHERE project_id = $id;";
    $reDel = mysqli_query($conn, $queryDel);

    if ($reDel) {
        $_SESSION['message'] = "Mini Project details have been deleted successfully!";
        $response['success'] = true;
        $response['message'] = "Mini Project details have been deleted successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in deleting Mini Project details!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}

if (isset($_GET['courseFilter']) || isset($_GET['empFilter'])) {

            $course   = isset($_GET['courseFilter']) ? $_GET['courseFilter'] : '';
            $employee = isset($_GET['empFilter']) ? $_GET['empFilter'] : '';

            // Build the base SQL query
            $filterquery = "SELECT
                                a.*,
                                b.course_name,
                                c.name AS empName
                            FROM
                                `trainee_mini_project` AS a
                            LEFT JOIN `academy_course_details` AS b
                            ON
                                a.course_id = b.id
                            LEFT JOIN `basic_details` AS c
                            ON
                                a.updated_by = c.id
                            WHERE
                                a.status = 'Active'"; 

            if (!empty($course)) {
                $filterquery .= " AND a.`course_id` = '$course'";
            }
            if (!empty($employee)) {
                $filterquery .= " AND a.`updated_by` = '$employee'";
            }
            $resFilter = mysqli_query($conn, $filterquery);
            
            $assets = [];
        
            while ($row = mysqli_fetch_assoc($resFilter)) {
                $assets[] = $row; // Collect the data
            }
        
            header('Content-Type: application/json');
            echo json_encode($assets);
            exit();
        }

?>