<?php
session_start();
include "../db/dbConnection.php";

// Debugging: Check if subId is being posted and stored in session
if (isset($_POST['subId'])) {
    $_SESSION['subId'] = $_POST['subId'];
    echo $_SESSION['subId'];
    exit; // Optionally, echo the subId for debugging
} else {
    echo "No SubId provided";
    exit;
}

// Ensure database connection is established
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
