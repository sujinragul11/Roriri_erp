<?php
include("../../db/dbConnection.php");

$response = ['success' => false, 'message' => ''];

header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow only POST, GET, and OPTIONS requests
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Specify allowed headers

if (isset($_POST['subCatName']) && $_POST['subCatName'] != '') {

    $catname = htmlspecialchars($_POST['categoryName'], ENT_QUOTES, 'UTF-8');
    $subname = htmlspecialchars($_POST['subCatName'], ENT_QUOTES, 'UTF-8');
    
    $checkQuery = "SELECT COUNT(*) AS count FROM expense_subcategory WHERE cat_id = '$catname' AND name = '$subname' AND `status` = 'Active'";
    $result = $conn->query($checkQuery);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['count'] > 0) {
            echo json_encode(['status' => 'error', 'message' => 'SubCategory name already exists!']);
            exit;
        }
    }
    $query = "INSERT INTO expense_subcategory (cat_id, name) 
              VALUES ('$catname', '$subname')";

    if ($conn->query($query) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'SubCategory submitted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error submitting SubCategory: ' . $conn->error]);
    }
}

if (isset($_POST['subCatNameEdit']) && $_POST['subCatNameEdit'] !== '') {
    $subcatId = htmlspecialchars($_POST['subCategoryId'], ENT_QUOTES, 'UTF-8');
    $catname  = htmlspecialchars($_POST['categoryNameEdit'], ENT_QUOTES, 'UTF-8');
    $subname  = htmlspecialchars($_POST['subCatNameEdit'], ENT_QUOTES, 'UTF-8');

    $checkQuery = "SELECT COUNT(*) FROM `expense_subcategory` WHERE `name` = '$subname' AND `cat_id` = '$catname' AND `subcat_id` != '$subcatId' AND `status` = 'Active'";
    $result = $conn->query($checkQuery);
    $row = $result->fetch_row();

    if ($row[0] > 0) {
        echo json_encode(['status' => 'error', 'message' => 'SubCategory name already exists!']);
    } else {
        $catEditQuery = "UPDATE `expense_subcategory` SET `cat_id` = '$catname', `name` = '$subname' WHERE `subcat_id` = '$subcatId'";

        if ($conn->query($catEditQuery) === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'SubCategory details updated successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Unexpected error in updating SubCategory details!' . $conn->error]);
        }
    }
}

if (isset($_POST['delId']) && $_POST['delId'] != '') {
    
    $subCatId = $_POST['delId'];

    $deleteQuery = "UPDATE
                        `expense_subcategory`
                    SET
                        `status` = 'Inactive'
                    WHERE
                        `subcat_id` = '$subCatId'";

    if ($conn->query($deleteQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = "SubCategory details Deleted successfully!";
    } else {
        $response['message'] = "Unexpected error in deleting SubCategory details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

?>