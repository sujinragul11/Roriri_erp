<?php
include("../db/dbConnection.php"); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);

    $query = "SELECT * FROM student_tbl WHERE id = $id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $trainee = $result->fetch_assoc();
        
    
        echo json_encode(['success' => true, 'trainee' => $trainee]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Trainee not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
  