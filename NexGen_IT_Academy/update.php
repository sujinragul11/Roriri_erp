<?php
session_start(); // Start the session

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topic_id = $_POST['topic_id'];
    $section = $_POST['section'];
    $sub_id = $_POST['sub_id'];
    //$subjects = $_POST['sub_id'];
   
    //var_dump($subjects);
    // Retrieve session variables
    $courseid = $_SESSION['courseid'];
    $userId = $_SESSION['user_id'];
    // $subject = $_SESSION['course_subject'];
    // $_SESSION['course_subject'] = $subjects;
    // Check if the topic_id already exists in the table
    $checkQuery = "SELECT * FROM evaluation_tbl WHERE topic_id='$topic_id'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // If topic_id exists, update the existing record
        $updateQuery = "UPDATE evaluation_tbl SET section='$section', course_id='$courseid', student_id='$userId', sub_id='$sub_id' WHERE topic_id='$topic_id'";
        $updateResult = mysqli_query($conn, $updateQuery);
        var_dump($updateResult);
        if ($updateResult) {
            echo "Record updated successfully.";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        // If topic_id does not exist, insert a new record
        $insertQuery = "INSERT INTO evaluation_tbl (section, course_id, student_id, sub_id, topic_id) VALUES ('$section', '$courseid', '$userId', '$sub_id', '$topic_id')";
        $insertResult = mysqli_query($conn, $insertQuery);
        if ($insertResult) {
            echo "Record inserted successfully.";
        } else {
            echo "Error inserting record: " . mysqli_error($conn);
        }
    }
} else {
    echo "Invalid input data";
}

$conn->close();
?>
