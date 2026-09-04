<?php
include("../../db/dbConnection.php");

$response = ['success' => false, 'message' => ''];

header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow only POST, GET, and OPTIONS requests
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Specify allowed headers

if (isset($_POST['categoryName']) && $_POST['categoryName'] != '') {

    $name = htmlspecialchars($_POST['categoryName'], ENT_QUOTES, 'UTF-8');
    
    $checkQuery = "SELECT COUNT(*) AS count FROM expense_category WHERE name = '$name' AND `status` = 'Active'";
    $result = $conn->query($checkQuery);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['count'] > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Category name already exists!']);
            exit;
        }
    }
    $query = "INSERT INTO expense_category (name) 
              VALUES ('$name')";

    if ($conn->query($query) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Category submitted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error submitting Category: ' . $conn->error]);
    }
}

if (isset($_POST['categoryNameEdit']) && $_POST['categoryNameEdit'] !== '') {
    $catId = htmlspecialchars($_POST['categoryId'], ENT_QUOTES, 'UTF-8');
    $name  = htmlspecialchars($_POST['categoryNameEdit'], ENT_QUOTES, 'UTF-8');

    $checkQuery = "SELECT COUNT(*) FROM `expense_category` WHERE `name` = '$name' AND `cat_id` != '$catId' AND `status` = 'Active'";
    $result = $conn->query($checkQuery);
    $row = $result->fetch_row();

    if ($row[0] > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Category name already exists!']);
    } else {
        $catEditQuery = "UPDATE `expense_category` SET `name` = '$name' WHERE `cat_id` = '$catId'";

        if ($conn->query($catEditQuery) === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'Category details updated successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Unexpected error in updating Category details!' . $conn->error]);
        }
    }
}

if (isset($_POST['delId']) && $_POST['delId'] != '') {
    
    $catId = $_POST['delId'];

    $deleteQuery = "UPDATE
                        `expense_category`
                    SET
                        `status` = 'Inactive'
                    WHERE
                        `cat_id` = '$catId'";

    if ($conn->query($deleteQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Category details Deleted successfully!";
    } else {
        $response['message'] = "Unexpected error in deleting Category details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

?>