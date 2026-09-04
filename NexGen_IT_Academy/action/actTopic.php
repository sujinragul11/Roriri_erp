<?php
session_start();
include("../../db/dbConnection.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Check if the form has been submitted
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addTopic') {
    // Retrieve form data
    $topic_name = $_POST['topic_name'];
    $topic_description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
    $topic_duration = $_POST['topic_duration'];
    $sub_id = $_POST['hdnSubId'];
    // SQL query to insert data
    $query = "INSERT INTO topic_tbl (topic_sub_id, topic_name, description, topic_duration) 
              VALUES ('$sub_id', '$topic_name', '$topic_description', '$topic_duration')";  
    $res = mysqli_query($conn, $query);
    
    // Check query result and set response message
    if ($res) {
        $_SESSION['message'] = "Topic details added successfully!";
        $response['success'] = true;
        $response['message'] = "Topic details added successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in adding Topic details!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    // Return response as JSON
    echo json_encode($response);
    exit();
}
// Handle updating Task details
if (isset($_POST['hdnEditAction']) && $_POST['hdnEditAction'] == 'hdnEditTopic') {
    $editid = $_POST['editId'];
    $edit_topic_name = $_POST['edit_topic_name'];
    $edit_description = htmlspecialchars($_POST['edit_description'], ENT_QUOTES, 'UTF-8');
    $edit_topic_duration = $_POST['edit_topic_duration'];
   

    $editQuery1 = " UPDATE topic_tbl
    SET 
        topic_name = '$edit_topic_name',
        description = '$edit_description',
        topic_duration = '$edit_topic_duration'
    WHERE 
        topic_id = '$editid'
    ";
    
    $editRes = mysqli_query($conn, $editQuery1);

    if ($editRes) {
        $_SESSION['message'] = "Topic details updated successfully!";
        $response['success'] = true;
        $response['message'] = "Topic details updated successfully!";
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
    $fetchId = $_POST['editId'];
    $selQuery = "SELECT * FROM topic_tbl WHERE topic_id= $fetchId";
    $result = mysqli_query($conn, $selQuery);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        
        $topicDetails = array(
            'topic_id'=>$row['topic_id'],
            'topic_name' => $row['topic_name'],
            'topic_description' => htmlspecialchars_decode($row['description'], ENT_QUOTES),
            'topic_duration' => $row['topic_duration']
        );
        $aa = json_encode($topicDetails);

        echo  $aa ;
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}
// Handle deleting a Task
if (isset($_POST['deleteId'])) {
    $id = $_POST['deleteId'];
    $queryDel = "UPDATE `topic_tbl` 
    SET topic_status = 'Inactive'
    WHERE topic_id = $id;";
    $reDel = mysqli_query($conn, $queryDel);

    if ($reDel) {
        $_SESSION['message'] = "Topic details have been deleted successfully!";
        $response['success'] = true;
        $response['message'] = "Topic details have been deleted successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in deleting Topic details!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}

$conn->close();
?>
