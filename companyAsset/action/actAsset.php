<?php

include("../../db/dbConnection.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];


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
    
    
    // get  Sub category
    if (isset($_GET['category_id']) && $_GET['category_id'] !== '') {
    
        $id=$_GET['category_id'];
      $query = "SELECT `subcat_id`, `assetcate_id`, `Subcategory` FROM `asset_subcategory` WHERE `assetcate_id` = '$id';"; // Change to your actual table name
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
    
    // add asset unction 
    
 if (isset($_POST['htnName']) && $_POST['htnName'] == 'addAsset') {
    $category_id = $_POST['category_id'] ?? '';
    $sub_category_id = $_POST['sub_category_id'] ?? '';
    $asset_id = $_POST['asset_id'] ?? '';
    $asset_name = $_POST['asset_name'] ?? '';
    $vendor_id = $_POST['vendor_id'] ?? ''; // Verify this exists in the form
    $status = $_POST['status'] ?? '';
    $description = $_POST['description'] ?? '';
    $asset_date = $_POST['asset_date'] ?? '';

        $insQuery = "INSERT INTO `asset_product`(
                                        `subcat_id`,
                                        `product_no`,
                                        `product_name`,
                                        `description`,
                                        `vendor_id`,
                                        `buy_date`,
                                        `asset_status`
                                    )
                                    VALUES(
                                        '$sub_category_id',
                                        '$asset_id',
                                        '$asset_name',
                                        '$description',
                                        '$vendor_id',
                                        '$asset_date',
                                        '$status'
                                     
                                    )";
                                    
                                    // Debug: Print the query for troubleshooting
                        // echo $insQuery;

        if ($conn->query($insQuery) === TRUE) {
            $response['success'] = true;
            $response['message'] = "Asset details added successfully!";
        } else {
            $response['message'] = "Unexpected error in adding Asset details! " . $conn->error;
        }
    
    echo json_encode($response);
    exit();
 }
 
 
 
 // edit function --------------
  // get  Sub category
    if (isset($_GET['asset_id']) && $_GET['asset_id'] !== '') {
    
        $id=$_GET['asset_id'];
        
      $query = "SELECT
                    a.assetpro_id,
                    a.subcat_id,
                    a.product_no,
                    a.product_name,
                    a.description,
                    a.buy_date,
                    a.vendor_id,
                    a.asset_status,
                    b.assetcate_id
                    FROM
                        `asset_product` AS a 
                        LEFT JOIN asset_subcategory AS b ON a.subcat_id = b.subcat_id
                    WHERE
                        `assetpro_id` = '$id';"; 
                
    $result = $conn->query($query);
    
    $categories = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $categories =array(
             'assetpro_id' => $row['assetpro_id'],
             'assetcate_id' => $row['assetcate_id'],
             'subcat_Id' => $row['subcat_id'],
             'product_no' => $row['product_no'],
             'product_name' => $row['product_name'],
             'description' => $row['description'],
             'buy_date' => $row['buy_date'],
             'vendor_id' => $row['vendor_id'],
             'asset_status' => $row['asset_status']
             
                
                );
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($categories);
    exit();
    }
    
    
    
      // get  category
    if (isset($_GET['action']) && $_GET['action'] == 'getSubCategory') {
    
        
      $query = "SELECT `subcat_id`, `Subcategory` FROM `asset_subcategory` WHERE `status` = 'Active'"; // Change to your actual table name
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
    
    
    //update data --------------
        // add asset unction 
    
 if (isset($_POST['htnName']) && $_POST['htnName'] == 'editAsset') {
    
    $assetpro_id = $_POST['assetpro_id'] ?? '';     
    $category_id = $_POST['category_id'] ?? '';
    $sub_category_id = $_POST['sub_category_id'] ?? '';
    $asset_id = $_POST['asset_id'] ?? '';
    $asset_name = $_POST['asset_name'] ?? '';
    $vendor_id = $_POST['vendor_id'] ?? ''; // Verify this exists in the form
    $status = $_POST['status'] ?? '';
    $description = $_POST['description'] ?? '';
    $asset_date = $_POST['asset_date'] ?? '';

    // Update query for asset_product table
    $updateQuery = "UPDATE `asset_product`
                    SET 
                        `subcat_id` = '$sub_category_id',
                        `product_no` = '$asset_id',
                        `product_name` = '$asset_name',
                        `description` = '$description',
                        `vendor_id` = '$vendor_id',
                        `buy_date` = '$asset_date',
                        `asset_status` = '$status'
                    WHERE 
                        `assetpro_id` = '$assetpro_id';";
    
    if ($conn->query($updateQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Asset details updated successfully!";

        $additionalQuery = "UPDATE `asset_asign_tbl` 
                            SET `asign_end_date` = CURRENT_DATE() 
                            WHERE `asign_asset_id` = '$assetpro_id' 
                            AND `status` = 'Active' 
                            AND `asign_end_date` = '0000-00-00'"; 
        if ($conn->query($additionalQuery) === TRUE) {
        } else {
            $response['message'] .= " Additional action failed: " . $conn->error;
        }
    } else {
        $response['message'] = "Unexpected error in updating asset details! " . $conn->error;
    }

    // Output the JSON response
    echo json_encode($response);
    exit();
}

 
 //view --function ---
  // get  Sub category
    if (isset($_GET['view_asset_id']) && $_GET['view_asset_id'] !== '') {
    
        $id=$_GET['view_asset_id'];
        
      $query = "SELECT
                a.assetpro_id,
                b.Subcategory,
                c.category_name,
                a.product_no,
                a.product_name,
                a.description,
                a.buy_date,
                d.vendor_name,
                a.asset_status
            FROM
                `asset_product` AS a
            LEFT JOIN asset_subcategory AS b
            ON
                a.subcat_id = b.subcat_id
            LEFT JOIN asset_category AS c
            ON
                b.assetcate_id = c.assetcate_id
            LEFT JOIN asset_vendor AS d
            ON
                a.vendor_id = d.vendor_id
            WHERE
                a.status = 'Active' AND a.assetpro_id ='$id';"; 
                
    $result = $conn->query($query);
    
    $categories = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $categories =array(
             'assetpro_id' => $row['assetpro_id'],
             'Subcategory' => $row['Subcategory'],
             'category_name' => $row['category_name'],
             'product_no' => $row['product_no'],
             'product_name' => $row['product_name'],
             'description' => $row['description'],
             'buy_date' => ($row['buy_date'] === '0000-00-00') ? '' : date('d M Y', strtotime($row['buy_date'])),
             'vendor_name' => $row['vendor_name'],
             'asset_status' => $row['asset_status']
             
                
                );
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($categories);
    exit();
    }
    
    
    
    // -- add assign task--------------------
    
        // add asset unction 
if (isset($_POST['htnName']) && $_POST['htnName'] == 'addAssign') {
    $assignAssetId = $_POST['assignAssetId'] ?? '';
    $name = $_POST['name'] ?? '';
    $room = $_POST['room'] ?? '';
    $asign_start_date = $_POST['asign_start_date'] ?? '';
    $asign_end_date = $_POST['asign_end_date'] ?? '';
    $assignDescription = $_POST['assignDescription'] ?? '';

    // Prepare the response array
    $response = ['success' => false, 'message' => ''];

     
        // Step 3: Insert query if no record exists
        $insQuery = "INSERT INTO `asset_asign_tbl`(
                                    `asign_user_id`,
                                    `asign_asset_id`,
                                    `asign_room_id`,
                                    `asign_start_date`,
                                    `asign_end_date`,
                                    `description`
                                )
                                VALUES(?, ?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insQuery);
        $insertStmt->bind_param("ssssss", $name, $assignAssetId, $room, $asign_start_date, $asign_end_date, $assignDescription);

        if ($insertStmt->execute()) {
            // Change the status of the asset in asset_product table
            $updateQuery = "UPDATE `asset_product` 
                            SET `asset_status` = 'Assigned' 
                            WHERE `assetpro_id` = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("s", $assignAssetId);
    
            if ($updateStmt->execute()) {
                $response['success'] = true;
                $response['message'] = "Asset was Assigned to User successfully.";
            } else {
                $response['message'] = "Asset assignment added, but failed to update asset status: " . $conn->error;
            }
        } else {
            $response['message'] = "Error adding asset assignment details: " . $conn->error;
        }
    

    // Output the JSON response
    echo json_encode($response);
    exit();
}
//  ----------------------------------------------------------------------------------
 
  // get  View User
    if (isset($_GET['view_id']) && $_GET['view_id'] !== '') {
    
        $id=$_GET['view_id'];
        
      $query = "SELECT
                a.asign_id,
                d.name,
                d.username,
                a.asign_start_date,
                c.room_name
            FROM
                asset_asign_tbl AS a
            LEFT JOIN asset_product AS b
                ON a.asign_asset_id = b.assetpro_id
            LEFT JOIN room_tbl AS c
                ON a.asign_room_id = c.room_id
            LEFT JOIN basic_details AS d
                ON a.asign_user_id = d.id
            WHERE
                a.asign_asset_id = $id 
                AND (a.asign_end_date IS NULL OR a.asign_end_date = '0000-00-00') 
                AND a.status = 'Active';"; 
                
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
    
    
    
    //----view list of user ---
    if (isset($_POST['id']) && isset($_POST['end_date'])) {
    $id = $_POST['id'];
    $end_date = $_POST['end_date'];

    $query = "UPDATE asset_asign_tbl SET asign_end_date = '$end_date' WHERE asign_id = '$id'";
    if ($conn->query($query)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }
    } 
    
    
     // get  History-----------
    if (isset($_GET['history_asset_id']) && $_GET['history_asset_id'] !== '') {
    
        $id=$_GET['history_asset_id'];
        
      $query = "SELECT
                a.asign_id,
                d.name,
                d.username,
                a.asign_start_date,
                a.asign_end_date,
                c.room_name
            FROM
                asset_asign_tbl AS a
            LEFT JOIN asset_product AS b
                ON a.asign_asset_id = b.assetpro_id
            LEFT JOIN room_tbl AS c
                ON a.asign_room_id = c.room_id
            LEFT JOIN basic_details AS d
                ON a.asign_user_id = d.id
            WHERE
                a.asign_asset_id = $id 
                AND a.status = 'Active';"; 
                
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
    
    // get  Service-----------
    if (isset($_GET['service_asset_id']) && $_GET['service_asset_id'] !== '') {
    
        $id = $_GET['service_asset_id'];
        
      $queryService = " SELECT
                            `service_date`,
                            `description`,
                            `return_date`,
                            `amount`
                        FROM
                            `asset_service`
                        WHERE
                            `status` = 'Active' AND `assetpro_id` = '$id'"; 
                
    $resultService = $conn->query($queryService);
    
    $categories = [];
    if ($resultService) {
        while ($row = $resultService->fetch_assoc()) {
           $categories[] = $row;
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($categories);
    exit();
    }
    
    //--view report--------------
    
         // get  History-----------
    if (isset($_GET['report_start_date']) || isset($_GET['end_date']) || isset($_GET['vendor']) || isset($_GET['status'])) {
    
        // Get the filter values from the AJAX request
        $start_date = isset($_GET['report_start_date']) ? $_GET['report_start_date'] : '';
        $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
        $vendor = isset($_GET['vendor']) ? $_GET['vendor'] : '';
        $status = isset($_GET['status']) ? $_GET['status'] : '';
        
        // Build the SQL query with filters
        $query = "SELECT
                a.assetpro_id,
                b.Subcategory,
                c.category_name,
                a.product_no,
                a.product_name,
                a.description,
                a.buy_date,
                d.vendor_name,
                a.asset_status
            FROM
                `asset_product` AS a
            LEFT JOIN asset_subcategory AS b
            ON
                a.subcat_id = b.subcat_id
            LEFT JOIN asset_category AS c
            ON
                b.assetcate_id = c.assetcate_id
            LEFT JOIN asset_vendor AS d
            ON
                a.vendor_id = d.vendor_id
            WHERE
                a.status = 'Active'"; // Replace 'assets' with your table name
        
        if (!empty($start_date)) {
            $query .= " AND a.buy_date >= '$start_date'";
        }
        if (!empty($end_date)) {
            $query .= " AND a.buy_date <= '$end_date'";
        }
        if (!empty($vendor)) {
            $query .= " AND d.vendor_id = '$vendor'";
        }
        if (!empty($status)) {
            $query .= " AND a.asset_status = '$status'";
        }
        
        $resQuery = mysqli_query($conn, $query);
        $assets = [];
        
        while ($row = mysqli_fetch_assoc($resQuery)) {
            $assets[] = $row; // Collect the data
        }

    
    header('Content-Type: application/json');
    echo json_encode($assets);
    exit();
    }
 
    
  ?>  
    
    