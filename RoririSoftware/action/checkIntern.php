<?php
// Database connection
include("../../db/dbConnection.php");

$response = ['success' => false, 'message' => ''];

if (isset($_POST['username'])) {
    $username = trim($_POST['username']);  // Trim spaces for extra safety
    
    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM internship_tbl WHERE username = ?");
    
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Check if username exists
        if ($row['count'] > 0) {
            echo json_encode(['exists' => true]);
        } else {
            echo json_encode(['exists' => false]);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare the statement']);
    }
    
    $conn->close();
} else {
    echo json_encode(['error' => 'Invalid request']);
}