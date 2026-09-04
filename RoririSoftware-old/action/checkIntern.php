<?php
header('Content-Type: application/json');

// Database connection
include("../../db/dbConnection.php"); // Ensure you include your DB connection file

$response = ['success' => false, 'message' => ''];



if (isset($_POST['username'])) {
    $username = $_POST['username'];

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM intern_tbl WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }

    $stmt->close();
    $conn->close();
}

?>