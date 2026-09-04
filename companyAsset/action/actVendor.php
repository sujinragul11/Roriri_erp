<?php
session_start();

include("../../db/dbConnection.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Add Vendor
if (isset($_POST['vendorName']) && $_POST['vendorName'] != '') {
    
    $vendorName = htmlspecialchars($_POST['vendorName'], ENT_QUOTES, 'UTF-8');
    $comName    = htmlspecialchars($_POST['comName'], ENT_QUOTES, 'UTF-8');
    $phone      = htmlspecialchars($_POST['phone'], ENT_QUOTES, 'UTF-8');
    $email      = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $location   = htmlspecialchars($_POST['location'], ENT_QUOTES, 'UTF-8');
   
    $insQuery = "INSERT INTO `asset_vendor`(
                    `vendor_name`,
                    `email`,
                    `phone`,
                    `shop_name`,
                    `location`
                )
                VALUES(
                    '$vendorName',
                    '$email',
                    '$phone',
                    '$comName',
                    '$location'
                )";

   if ($conn->query($insQuery) === TRUE) {
    $response['success'] = true;
    $response['message'] = "Vendor details added successfully!";
    } else {
    $response['message'] = "Unexpected error in adding Vendor details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

//Handles Fetching the Vendor details for editing 
if (isset($_POST['editVendorId']) && $_POST['editVendorId'] != '') {
    $editId = $_POST['editVendorId'];

    $vendorFetch = "SELECT
                        `vendor_id`,
                        `vendor_name`,
                        `email`,
                        `phone`,
                        `shop_name`,
                        `location`
                    FROM
                        `asset_vendor`
                    WHERE
                        `vendor_id` = '$editId'";
    $fetchResult = mysqli_query($conn, $vendorFetch);
    
    if ($fetchResult) {
        $row = mysqli_fetch_assoc($fetchResult);

        $vendorDetails = array(
            'id'        => htmlspecialchars_decode($row['vendor_id']),
            'name'      => htmlspecialchars_decode($row['vendor_name']),
            'phone'     => htmlspecialchars_decode($row['phone']),
            'email'     => htmlspecialchars_decode($row['email']),
            'company'   => htmlspecialchars_decode($row['shop_name']),
            'address'   => htmlspecialchars_decode($row['location'])
        );
        echo json_encode($vendorDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}

// Edit Vendor
if (isset($_POST['vendorId']) && $_POST['vendorId'] != '') {
    
    $vendorId       = $_POST['vendorId'];
    $editName       = htmlspecialchars($_POST['vendorNameEdit'], ENT_QUOTES, 'UTF-8');
    $editCompany    = htmlspecialchars($_POST['comNameEdit'], ENT_QUOTES, 'UTF-8');
    $editPhone      = htmlspecialchars($_POST['phoneEdit'], ENT_QUOTES, 'UTF-8');
    $editEmail      = htmlspecialchars($_POST['emailEdit'], ENT_QUOTES, 'UTF-8');
    $editLocation   = htmlspecialchars($_POST['locationEdit'], ENT_QUOTES, 'UTF-8');
   
    $updateQuery = "UPDATE
                        `asset_vendor`
                    SET
                        `vendor_name` = '$editName',
                        `email` = '$editEmail',
                        `phone` = '$editPhone',
                        `shop_name` = '$editCompany',
                        `location` = '$editLocation'
                    WHERE
                        `vendor_id` = '$vendorId'";

  if ($conn->query($updateQuery) === TRUE) {
    $response['success'] = true;
    $response['message'] = "Vendor details updated successfully!";
    } else {
    $response['message'] = "Unexpected error in updating Vendor details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

// Delete Vendor
if (isset($_POST['delId']) && $_POST['delId'] != '') {
    
    $venId = $_POST['delId'];

    $deleteQuery = "UPDATE
                        `asset_vendor`
                    SET
                        `status` = 'Inactive'
                    WHERE
                        `vendor_id` = '$venId'";

  if ($conn->query($deleteQuery) === TRUE) {
    $response['success'] = true;
    $response['message'] = "Vendor details Deleted successfully!";
    } else {
    $response['message'] = "Unexpected error in deleting Vendor details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}
?>