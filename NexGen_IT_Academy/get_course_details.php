<?php
include("../db/dbConnection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_id = $_POST['course_id'];
    $duration = $_POST['duration'];

    // Example query to fetch course details based on course ID and duration
    $query = "SELECT course_fees, course_subject FROM academy_course_details WHERE course_id = '$course_id' AND course_duration = '$duration'";
    $result = mysqli_query($conn, $query);

    // Debug: Print the SQL query
    if (!$result) {
        echo json_encode(['error' => 'Failed to fetch course details', 'sql_error' => mysqli_error($conn)]);
        exit;
    }

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            $response = [
                'course_fees' => $row['course_fees'],
                'course_subject' => explode(',', $row['course_subject']) // Assuming subjects are stored as a comma-separated string
            ];
            echo json_encode($response);
        } else {
            echo json_encode(['error' => 'No course details found']);
        }
    } else {
        echo json_encode(['error' => 'Failed to fetch course details']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
 