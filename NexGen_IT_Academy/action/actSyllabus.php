<?php
session_start();
include("../../db/dbConnection.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];
$id = $_POST['id'];
$section = $_POST['section'];

// Update the section based on the provided section value
$sql = "UPDATE syllabus_tbl SET section = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $section, $id);

if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$stmt->close();
$conn->close();
?>


