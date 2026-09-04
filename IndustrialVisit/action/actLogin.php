<?php

session_start();
include("../../db/dbConnection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['pass'];

    $sql = "SELECT * FROM admin_tbl WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header('Location: roririgroup.php');
        exit();
    } else {
        $_SESSION['error'] = "Invalid username or password";
        header('Location: login.php');
        exit();
    }
}
?>