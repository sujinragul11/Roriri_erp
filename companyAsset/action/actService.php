<?php
session_start();

include("../../db/dbConnection.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Fetch Product details based on selected category
if (isset($_POST['category_id']) && $_POST['category_id'] != '') {
    $editId = $_POST['category_id'];

    $productFetch = "SELECT
                        a.`assetpro_id`,
                        a.`product_no`,
                        a.`product_name`
                    FROM
                        `asset_product` a
                    LEFT JOIN `asset_service` b ON
                        a.`assetpro_id` = b.`assetpro_id` AND b.`status` = 'Active' AND b.`return_date` = '0000-00-00'
                    WHERE
                        a.`status` = 'Active' AND a.`subcat_id` = '$editId' AND b.`assetpro_id` IS NULL";
    $proResult = mysqli_query($conn, $productFetch);
    
    if (mysqli_num_rows($proResult) > 0) {
        $productDetails = array(); 

        while ($row = mysqli_fetch_assoc($proResult)) {
            $productDetails[] = array(
                'id'        => htmlspecialchars_decode($row['assetpro_id']),
                'pro_no'    => htmlspecialchars_decode($row['product_no']),
                'name'      => htmlspecialchars_decode($row['product_name'])
            );
        }

        echo json_encode($productDetails);
    } else {
        $response['message'] = "No products available.";
        echo json_encode($response);
    }
    exit();
} 

if (isset($_POST['category_editId']) && $_POST['category_editId'] != '') {
    $editId = $_POST['category_editId'];
    $serId = $_POST['serId'];

    $productFetch = "SELECT
                        a.`assetpro_id`,
                        a.`product_no`,
                        a.`product_name`
                    FROM
                        `asset_product` a
                    LEFT JOIN `asset_service` b ON
                        a.`assetpro_id` = b.`assetpro_id` AND b.`status` = 'Active' AND b.`return_date` = '0000-00-00'
                    WHERE
                        a.`status` = 'Active' 
                        AND a.`subcat_id` = '$editId' 
                        AND (b.`service_id` IS NULL OR b.`service_id` = '$serId')
                    ORDER BY 
                        a.`product_no` ASC";
    $proResult = mysqli_query($conn, $productFetch);
    
    if (mysqli_num_rows($proResult) > 0) {
        $productDetails = array(); 

        while ($row = mysqli_fetch_assoc($proResult)) {
            $productDetails[] = array(
                'id'        => htmlspecialchars_decode($row['assetpro_id']),
                'pro_no'    => htmlspecialchars_decode($row['product_no']),
                'name'      => htmlspecialchars_decode($row['product_name'])
            );
        }

        echo json_encode($productDetails);
    } else {
        $response['message'] = "No products available.";
        echo json_encode($response);
    }
    exit();
} 

// Add Service
if (isset($_POST['proName']) && $_POST['proName'] != '') {
    
    $proName        = htmlspecialchars($_POST['proName'], ENT_QUOTES, 'UTF-8');
    $serDate        = htmlspecialchars($_POST['serDate'], ENT_QUOTES, 'UTF-8');
    $description    = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
    $retDate        = htmlspecialchars($_POST['retDate'], ENT_QUOTES, 'UTF-8');
    $amount         = htmlspecialchars($_POST['amount'], ENT_QUOTES, 'UTF-8');
   
    $insQuery = "INSERT INTO `asset_service`(
                    `assetpro_id`,
                    `service_date`,
                    `description`,
                    `return_date`,
                    `amount`
                )
                VALUES(
                    '$proName',
                    '$serDate',
                    '$description',
                    '$retDate',
                    '$amount'
                )";

  if ($conn->query($insQuery) === TRUE) {
    $response['success'] = true;
    $response['message'] = "Service details added successfully!";
    } else {
    $response['message'] = "Unexpected error in adding Service details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

//Handles Fetching the Service details for view 
if (isset($_POST['viewServiceId']) && $_POST['viewServiceId'] != '') {
    $viewId = $_POST['viewServiceId'];

    $viewFetch = "SELECT
                    a.`service_id`,
                    a.`service_date`,
                    a.`description`,
                    a.`return_date`,
                    a.`amount`,
                    b.product_no,
                    b.product_name
                FROM
                    `asset_service` AS a
                LEFT JOIN `asset_product` AS b
                ON
                    a.assetpro_id = b.assetpro_id
                WHERE
                    `service_id` = '$viewId'";
    $viewResult = mysqli_query($conn, $viewFetch);
    
    if ($viewResult) {
        $row = mysqli_fetch_assoc($viewResult);
        $productDetails = htmlspecialchars_decode($row['product_no'], ENT_QUOTES) . ' - ' . htmlspecialchars_decode($row['product_name'], ENT_QUOTES);

        $viewDetails = array(
            'id'            => $row['service_id'],
            'name'          => $productDetails,
            'serDate'       => $row['service_date'],
            'descript'      => htmlspecialchars_decode($row['description'], ENT_QUOTES),
            'retDate'       => $row['return_date'],
            'amount'        => $row['amount']
        );
        echo json_encode($viewDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}

//Handles Fetching the Service details for editing 
if (isset($_POST['editServiceId']) && $_POST['editServiceId'] != '') {
    $editId = $_POST['editServiceId'];

      $editFetch = "SELECT
                        a.`service_id`,
                        a.`assetpro_id`,
                        a.`service_date`,
                        a.`description`,
                        a.`return_date`,
                        a.`amount`,
                        b.subcat_id
                    FROM
                        `asset_service` AS a
                    LEFT JOIN `asset_product` AS b
                    ON
                        a.assetpro_id = b.assetpro_id
                    WHERE
                        a.service_id = '$editId'";
    $fetchResult = mysqli_query($conn, $editFetch);
    
    if ($fetchResult) {
        $row = mysqli_fetch_assoc($fetchResult);

        $serviceDetails = array(
            'id'        => $row['service_id'],
            'catName'   => $row['subcat_id'],
            'proName'   => $row['assetpro_id'],
            'serDate'   => $row['service_date'],
            'descript'  => htmlspecialchars_decode($row['description'], ENT_QUOTES),
            'retDate'   => $row['return_date'],
            'amount'    => $row['amount']
        );
        echo json_encode($serviceDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}

// Edit Service
if (isset($_POST['serviceId']) && $_POST['serviceId'] != '') {
    
    $serviceId      = $_POST['serviceId'];
    $editName       = htmlspecialchars($_POST['proNameEdit'], ENT_QUOTES, 'UTF-8');
    $editSerDate    = htmlspecialchars($_POST['serDateEdit'], ENT_QUOTES, 'UTF-8');
    $editDescript   = htmlspecialchars($_POST['descriptionEdit'], ENT_QUOTES, 'UTF-8');
    $editRetDate    = htmlspecialchars($_POST['retDateEdit'], ENT_QUOTES, 'UTF-8');
    $editAmount     = htmlspecialchars($_POST['amountEdit'], ENT_QUOTES, 'UTF-8');
   
    $updateQuery = "UPDATE
                        `asset_service`
                    SET
                        `assetpro_id`  = '$editName',
                        `service_date` = '$editSerDate',
                        `description`  = '$editDescript',
                        `return_date`  = '$editRetDate',
                        `amount`       = '$editAmount'
                    WHERE
                        `service_id`   = '$serviceId'";

  if ($conn->query($updateQuery) === TRUE) {
    $response['success'] = true;
    $response['message'] = "Service details updated successfully!";
    } else {
    $response['message'] = "Unexpected error in updating Service details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

// Delete Service
if (isset($_POST['delId']) && $_POST['delId'] != '') {
    
    $serId = $_POST['delId'];

    $deleteQuery = "UPDATE
                        `asset_service`
                    SET
                        `status` = 'Inactive'
                    WHERE
                        `service_id` = '$serId'";

  if ($conn->query($deleteQuery) === TRUE) {
    $response['success'] = true;
    $response['message'] = "Service details Deleted successfully!";
    } else {
    $response['message'] = "Unexpected error in deleting Service details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}
?>