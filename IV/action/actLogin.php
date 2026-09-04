<?php

session_start();
include("../../db/dbConnection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "CALL GetLogin('$username', '$password')";
    $result = $conn->query($sql); 

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['username'] = $row['username'];
        header('Location: ../index.php');
        exit();
    } else {
        $_SESSION['error'] = "Invalid username or password";
        header('Location: ../login.php');
        exit();
    }
}
?>