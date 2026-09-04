<?php
session_start();
include("../db/dbConnection.php");

// Client portal session guard
if (!isset($_SESSION['client_id'])) {
    header("Location: login.php");
    exit();
}

// Load current client
$clientId = (int)$_SESSION['client_id'];
$meQ = mysqli_query($conn, "SELECT * FROM client_tbl WHERE client_id=$clientId AND client_status='Active'");
$me = mysqli_fetch_assoc($meQ);
if (!$me) {
    session_destroy();
    header("Location: login.php");
    exit();
}
$_SESSION['client_name'] = $me['client_name'];
$_SESSION['client_company'] = $me['client_company'];
