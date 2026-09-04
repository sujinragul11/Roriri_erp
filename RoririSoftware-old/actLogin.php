<?php
session_start();
include("C:\\xampp\\htdocs\\ERP\\db\\dbConnection.php");

if (isset($_REQUEST['logout'])) {
    session_destroy();
    header("Location: logout.php");
}

if (isset($_POST['username']) && isset($_POST['username']) != '') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $stmt = mysqli_prepare($conn, "SELECT * FROM admin_tbl WHERE username = ? AND pass = ?");
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($res)) {
        $_SESSION['user']   = $row['name'];
        $_SESSION['userId'] = $row['user_id'];
        $_SESSION['role']   = $row['role'];
        header("Location: dashboard.php");
    } else {
        $_SESSION['message'] = "Invalid Credential!";
        header("Location: index.php");
    }
}
?>
