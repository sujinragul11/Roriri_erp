<?php
session_start();
include("../../db/dbConnection.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Check if the form has been submitted
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addCourse') {
    // Retrieve form data
    $course_name = $_POST['course_name'];
    $course_subject = implode(',', $_POST['subject']); 
    // SQL query to insert data
    $query = "INSERT INTO academy_course_details (course_name,subject_id) 
              VALUES ('$course_name','$course_subject')";  
    $res = mysqli_query($conn, $query);
    
    // Check query result and set response message
    if ($res) {
        $_SESSION['message'] = "Course added successfully!";
        $response['success'] = true;
        $response['message'] = "Course added successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in adding Course!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }
    // Return response as JSON
    echo json_encode($response);
    exit();
}
// Handle updating Task details
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'hdnEditCourse') {
    $editId = $_POST['editId'];
    $editcourse_name = $_POST['edit_name'];
    $editSubjects = isset($_POST['subject']) ? $_POST['subject'] : [];
    $subjectsString = implode(',', $editSubjects); // Convert array to comma-separated string

    // Ensure to escape input data to prevent SQL injection
    // $editcourse_name = mysqli_real_escape_string($conn, $editcourse_name);
    // $subjectsString = mysqli_real_escape_string($conn, $subjectsString);

    // Update query
    $editQuery = "
        UPDATE academy_course_details
        SET
            course_name = '$editcourse_name',
            subject_id = '$subjectsString'
        WHERE
            id = $editId
    ";

    $editRes = mysqli_query($conn, $editQuery);

    $response = [];
    if ($editRes) {
        $_SESSION['message'] = "Course details updated successfully!";
        $response['success'] = true;
        $response['message'] = "Course details updated successfully!";
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
    $fetchId = intval($_POST['editId']);
    
    $selQuery = "SELECT c.id AS course_id, c.course_name, GROUP_CONCAT(s.id) AS subject_ids FROM academy_course_details c JOIN subject_tbl s ON FIND_IN_SET(s.id, c.subject_id) > 0 WHERE c.id = $fetchId GROUP BY c.id";
    
    $result = mysqli_query($conn, $selQuery);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        
        $courseDetails = array(
            'course_id' => $row['course_id'],
            'course_name' => $row['course_name'],
            'selected_subjects' => explode(',', $row['subject_ids'])
        );

        header('Content-Type: application/json'); // Ensure proper content type
        echo json_encode($courseDetails);
    } else {
        $response = array('message' => "Error executing query: " . mysqli_error($conn));
        header('Content-Type: application/json'); // Ensure proper content type
        echo json_encode($response);
    }
    exit();
}



// delete the course
if (isset($_POST['deleteId'])) {
    $id = $_POST['deleteId'];
    $queryDel = "UPDATE `academy_course_details` 
    SET status = 'Inactive'
    WHERE id = $id;";
    $reDel = mysqli_query($conn, $queryDel);

    if ($reDel) {
        $_SESSION['message'] = "Course details have been deleted successfully!";
        $response['success'] = true;
        $response['message'] = "Course details have been deleted successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in deleting Course details!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}
// course details 
// if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addCourseDetails') {

//     $course_name = $_POST['course_name'];
//     $course_duration = $_POST['course_duration'];
//     $course_fees = $_POST['course_fees'];
//     $course_subject = implode(',', $_POST['subject']);
//     $query = "INSERT INTO coursedetails_tbl (course_id,course_duration, course_fees,course_subject) 
//               VALUES ('$course_name','$course_duration', '$course_fees','$course_subject')"; 
              
//     $res = mysqli_query($conn, $query);
    

//     if ($res) {
//         $_SESSION['message'] = "Course details added successfully!";
//         $response['success'] = true;
//         $response['message'] = "Course details added successfully!";
//     } else {
//         $_SESSION['message'] = "Unexpected error in adding Task details!";
//         $response['message'] = "Error: " . mysqli_error($conn);
//     }

//     echo json_encode($response);
//     exit();
// }
?>
