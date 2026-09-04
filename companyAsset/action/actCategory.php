<?php
session_start();
// include("C:\xampp\htdocs\RORIRI_ERP\db\dbConnection.php");
include("../../db/dbConnection.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Add Employee
if (isset($_POST['htnName']) && $_POST['htnName'] == 'AddCategory') {

    
    $categoryName=$_POST['categoryName'];
   
    $insQuery="INSERT INTO `asset_category`(`category_name`) VALUES ('$categoryName')";

   if ($conn->query($insQuery) === TRUE) {
    $response['success'] = true;
    $response['message'] = "Category details added successfully!";
    } else {
    $response['message'] = "Unexpected error in adding Category details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

    // get  category
    if (isset($_GET['action']) && $_GET['action'] == 'getCategory') {
    
        
      $query = "SELECT `assetcate_id`, `category_name` FROM `asset_category` WHERE `category_status` = 'Active'"; // Change to your actual table name
    $result = $conn->query($query);
    
    $categories = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($categories);
    exit();
    }
    
    
    // Add Sub category
    if (isset($_POST['htnName']) && $_POST['htnName'] == 'addSubCategory') {

    
    $category_id        = $_POST['category_id'];
    $subcategory_name   = $_POST['subcategory_name']; 
    $quantity           = $_POST['quantity'];
   	
    $insQuery="INSERT INTO `asset_subcategory`(
    `assetcate_id`,
    `Subcategory`,
    `quantity`
 
		)
		VALUES(
		    '$category_id',
		    '$subcategory_name',
		    '$quantity'
		)";

   if ($conn->query($insQuery) === TRUE) {
    $response['success'] = true;
    $response['message'] = "Sub Category details added successfully!";
    } else {
    $response['message'] = "Unexpected error in adding Sub Category details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

//Handles Update the clients details
if (isset($_POST['htnName']) && $_POST['htnName'] == 'editSubCategory') {

    $subcat_id        =$_POST['subcat_id'];
    $category_id      =$_POST['category_id'];
    $subcategory_name =$_POST['subcategory_name'];
    $quantity         =$_POST['quantity'];
  

    $UpdateClient="UPDATE
                        `asset_subcategory`
                    SET
                        `assetcate_id` = '$category_id',
                        `Subcategory` = '$subcategory_name',
                        `quantity` = '$quantity'
                    WHERE
                        `subcat_id` = '$subcat_id'";

         $editResClient = mysqli_query($conn, $UpdateClient);

        if ($editResClient) {
            $_SESSION['message'] = "Sub Category details updated successfully!";
            $response['success'] = true;
            $response['message'] = "Sub Category details updated successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "Error updating database: " . mysqli_error($conn);
        }
         
        echo json_encode($response);
        exit();

}



//Handles Fetching the Clients details for editing 
if (isset($_GET['subcat_id']) && $_GET['subcat_id'] != '') {
    $editId = $_GET['subcat_id'];

    $subcateFetch="SELECT
    `subcat_id`,
    `assetcate_id`,
    `Subcategory`,
    `quantity`
FROM
    `asset_subcategory`
WHERE
    subcat_id ='$editId'";
    
    $fetchResult = mysqli_query($conn, $subcateFetch);
    
    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);
        
        $subCateDetails = array(
            'subcat_id' => $row['subcat_id'],
            'assetcate_id' => $row['assetcate_id'],
            'Subcategory' => $row['Subcategory'],
            'quantity' => $row['quantity']
            

        );
        echo json_encode($subCateDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}
//Handles Deleting the client

if (isset($_POST['delId'])) {
    $id = $_POST['delId'];
    $queryDel = "UPDATE `asset_subcategory` SET status='Inactive'
    WHERE subcat_id='$id'";
    $reDel = mysqli_query($conn, $queryDel);

    if ($reDel) {
        $_SESSION['message'] = "Sub Category details have been deleted successfully!";
        $response['success'] = true;
        $response['message'] = "Sub Category details have been deleted successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in deleting Sub Category details!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}
