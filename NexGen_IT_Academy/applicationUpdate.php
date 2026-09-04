<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_roriri(4)";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $application_id = $_POST['application_id'];

    $section = $_POST['section'];

    $courseid = $_SESSION['courseid'];
    $userId = $_SESSION['user_id'];
    
    // Check if the topic_id already exists in the table
    $checkQuery = "SELECT * FROM app_evaluation_tbl WHERE application_id='$application_id'";
    $checkResult = mysqli_query($conn, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        // If topic_id exists, update the existing record
        $updateQuery = "UPDATE app_evaluation_tbl SET section='$section', course_id='$courseid', student_id='$userId' WHERE application_id='$application_id'";
        $updateResult = mysqli_query($conn, $updateQuery);
        if ($updateResult) {
            echo "Record updated successfully.";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        // If topic_id does not exist, insert a new record
        $insertQuery = "INSERT INTO app_evaluation_tbl (section, course_id, student_id, application_id) VALUES ('$section', '$courseid', '$userId', '$application_id')";
        $insertResult = mysqli_query($conn, $insertQuery);
        if ($insertResult) {
            echo "Record inserted successfully.";
        } else {
            echo "Error inserting record: " . mysqli_error($conn);
        }
    }
}

// $topic_id = $_POST['topic_id'] ?? null;
// $sub_id = $_POST['sub_id'] ?? null;
// $section = $_POST['section'] ?? null;
// $topic_status = $_POST['topic_status'] ?? 'Active'; // Assuming default status is 'Active'

// if ($topic_name && $sub_id && $section) {
//     // Insert query
//     $sql = "INSERT INTO evaluation_tbl (section, sub_id, section, topic_status) VALUES (?, ?, ?, ?)";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("siss", $topic_name, $sub_id, $section, $topic_status);

//     if ($stmt->execute()) {
//         echo "New record created successfully";
//     } else {
//         echo "Error inserting record: " . $conn->error;
//     }

//     $stmt->close();
//} 
else {
    echo "Invalid input data";
}

$conn->close();
?>
