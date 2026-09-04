<?php

include("../../db/dbConnection.php");
include("../../url.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Add Employee
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addCourse') {

    
    $name=$_POST['course'];
    $duration=$_POST['duration'];
    
    $insQuery="INSERT INTO `course_tbl`( `entity_id`, `course_name`, `duration`) VALUES ('$entity_id','$name','$duration')";

   if ($conn->query($insQuery) === TRUE) {
    $response['success'] = true;
    $response['message'] = "Course details added successfully!";
    } else {
    $response['message'] = "Unexpected error in adding Course details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

//Handles Update the clients details
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'editCourse') {

    $editID=$_POST['editIdCourse'];
    $courseE=$_POST['eCourse'];
    $durationE=$_POST['editDuration'];
    
    $UpdateCourse="UPDATE `course_tbl`
    SET 
    `course_name`='$courseE',
    `duration`='$durationE'
    
    
     WHERE `course_id`='$editID'";

         $editResClient = mysqli_query($conn, $UpdateCourse);

        if ($editResClient) {
            $_SESSION['message'] = "Course details updated successfully!";
            $response['success'] = true;
            $response['message'] = "Course details updated successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "Error updating database: " . mysqli_error($conn);
        }
         
        echo json_encode($response);
        exit();

}


//Handles Fetching the Clients details for editing 
if (isset($_POST['editId']) && $_POST['editId'] != '') {
    $editId = $_POST['editId'];

    $Fetch="SELECT * FROM course_tbl WHERE course_id='$editId'";
    $fetchResult = mysqli_query($conn, $Fetch);
    
    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);
        
        $clientDetails = array(
            'course_id' => $row['course_id'],
            'course_name' => $row['course_name'],
            'duration' => $row['duration'],          
            
        );
        echo json_encode($clientDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}
//Handles Deleting the client

if (isset($_POST['deleteId'])) {
    $id = $_POST['deleteId'];
    $queryDel = "UPDATE `course_tbl` SET status='Inactive'
    WHERE course_id='$id'";
    $reDel = mysqli_query($conn, $queryDel);

    if ($reDel) {
        $_SESSION['message'] = "Course details have been deleted successfully!";
        $response['success'] = true;
        $response['message'] = "Course details have been deleted successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in deleting Employee details!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}
