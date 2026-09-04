<?php
session_start();
include("../../db/dbConnection.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Add Subject
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addSubject') {

    $name = $_POST['subject'];
    $duration = $_POST['duration'];
    $course_id = isset($_POST['course_id']) ? $_POST['course_id'] : '';

    $insQuery = "INSERT INTO `subject_tbl`( `subject_name`, `sub_name`, `duration`, `course_id`, `entity_id`) VALUES ('$name','$name','$duration'," . (($course_id !== '') ? "'$course_id'" : "NULL") . ", '2')";

    if ($conn->query($insQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Subject details added successfully!";
    } else {
        $response['message'] = "Unexpected error in adding Subject details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

// Update Subject
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'editSubject') {

    $editID = $_POST['editIdSubject'];
    $subjectE = $_POST['eSubject'];
    $durationE = $_POST['editDuration'];
    $courseE = $_POST['editCourse'];

    $UpdateSubject = "UPDATE `subject_tbl`
    SET 
    `subject_name`='$subjectE',
    `sub_name`='$subjectE',
    `duration`='$durationE',
    `course_id`=" . (($courseE !== '') ? "'$courseE'" : "NULL") . "
    WHERE `id`='$editID'";

    $editResSubject = mysqli_query($conn, $UpdateSubject);

    if ($editResSubject) {
        $_SESSION['message'] = "Subject details updated successfully!";
        $response['success'] = true;
        $response['message'] = "Subject details updated successfully!";
    } else {
        $response['success'] = false;
        $response['message'] = "Error updating database: " . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}

// Fetch Subject details for editing
if (isset($_POST['editId']) && $_POST['editId'] != '') {
    $editId = $_POST['editId'];

    $Fetch = "SELECT * FROM subject_tbl WHERE id='$editId'";
    $fetchResult = mysqli_query($conn, $Fetch);

    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);

        $clientDetails = array(
            'subject_id' => $row['id'],
            'subject_name' => $row['subject_name'],
            'duration' => $row['duration'],
            'course_id' => $row['course_id'],
        );
        echo json_encode($clientDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}

// Fetch college courses for dropdown
if (isset($_POST['getCourses'])) {
    $courses = [];
    $courseQ = mysqli_query($conn, "SELECT course_id, course_name FROM `course_tbl` WHERE status='Active' ORDER BY course_name");
    if ($courseQ) {
        while ($c = mysqli_fetch_assoc($courseQ)) {
            $courses[] = array('id' => $c['course_id'], 'name' => $c['course_name']);
        }
    }
    echo json_encode($courses);
    exit();
}

// Delete Subject
if (isset($_POST['deleteId'])) {
    $id = $_POST['deleteId'];
    $queryDel = "UPDATE `subject_tbl` SET status='Inactive' WHERE id='$id' AND entity_id='2'";
    $reDel = mysqli_query($conn, $queryDel);

    if ($reDel) {
        $_SESSION['message'] = "Subject details have been deleted successfully!";
        $response['success'] = true;
        $response['message'] = "Subject details have been deleted successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in deleting Subject details!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}
