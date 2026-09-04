<?php
session_start();
include("../../db/dbConnection.php");

$id = (int)$_SESSION['id']; // Explicitly casting to integer for security

// Retrieve parameters from DataTables and ensure they're safe
$start = isset($_POST['start']) ? (int)$_POST['start'] : 0;
$length = isset($_POST['length']) ? (int)$_POST['length'] : 10;
$searchValue = isset($_POST['search']['value']) ? $conn->real_escape_string($_POST['search']['value']) : '';

// Base query
$query = "SELECT
                a.id,
                a.paid_date,
                a.reason,
                a.amount,
                a.pay_status,
                b.name
            FROM
                `iv_payment_tbl` AS a
            LEFT JOIN food_packages_tbl AS b
            ON
                a.food_id = b.id
            WHERE
                a.status = 'Active' AND a.visit_id = $id";

// Append search filter if a search value is provided
if (!empty($searchValue)) {
    $query .= " AND (a.reason LIKE '%$searchValue%' OR b.name LIKE '%$searchValue%')";
}

// Add ordering and pagination
$query .= " ORDER BY a.paid_date DESC LIMIT $start, $length";

$result = $conn->query($query);

// Fetch data for DataTables
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        "id" => $row['id'],
        "paid_date" => date("d-M-Y", strtotime($row['paid_date'])),
        "reason" => $row['reason'],
        "amount" => $row['amount'],
        "pay_status" => $row['pay_status'],
        "name" => $row['name'],
    ];
}

// Get total record count for pagination
$totalRecordsResult = $conn->query("SELECT COUNT(*) as count FROM iv_payment_tbl WHERE status = 'Active'");
$totalRecords = $totalRecordsResult->fetch_assoc()['count'];

// Calculate total filtered records based on search criteria
$filteredQuery = "SELECT COUNT(*) as count FROM iv_payment_tbl AS a
                  LEFT JOIN food_packages_tbl AS b ON a.food_id = b.id
                  WHERE a.status = 'Active' AND a.visit_id = $id";
if (!empty($searchValue)) {
    $filteredQuery .= " AND (a.reason LIKE '%$searchValue%' OR b.name LIKE '%$searchValue%')";
}

$filteredResult = $conn->query($filteredQuery);
$recordsFiltered = $filteredResult->fetch_assoc()['count'];

// Output in JSON format for DataTables
echo json_encode([
    "draw" => intval($_POST['draw']),
    "recordsTotal" => intval($totalRecords),
    "recordsFiltered" => intval($recordsFiltered),
    "data" => $data
]);

$conn->close();
?>
