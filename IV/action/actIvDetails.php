<?php
session_start();
include("../../db/dbConnection.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];


if (isset($_POST['iv_edit']) && $_POST['iv_edit'] !== '') {
    $viewId = $_POST['iv_edit'];
   
      $query = "SELECT
                    a.iv_id,
                    a.college_id,
                    a.iv_date,
                    a.department,
                    a.batch,
                    a.stu_count,
                    a.staff_count,
                    a.incharge_name,
                    a.incharge_phone,
                    a.iv_status,
                    b.name
                FROM
                    `iv_details_tbl` AS a 
                    LEFT JOIN iv_client_tbl AS b ON a.college_id =b.id
                WHERE
                    a.iv_id = '$viewId';"; 
                
    $result = $conn->query($query);
    
    $categories = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $categories =array(
             'iv_id' => $row['iv_id'],
             'name' => $row['name'],
             'iv_date' => $row['iv_date'],
             'department' => $row['department'],
             'batch' => $row['batch'],
             'stu_count' => $row['stu_count'],
             'staff_count' => $row['staff_count'],
             'incharge_name' => $row['incharge_name'],
             'incharge_phone' => $row['incharge_phone'],
             'iv_status' => $row['iv_status']
                
                );
        }
    }
    
    echo json_encode($categories);
    exit();
}

// Check if the request is for retrieving IV details
if (isset($_POST['viewIv']) && $_POST['viewIv'] == 'getIv') {
    // Get parameters for pagination and searching
    $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 0;
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $length = isset($_POST['length']) ? intval($_POST['length']) : 10;

    // Prepare your SQL query to count total records
    $totalRecordsQuery = "SELECT COUNT(*) as total FROM iv_details_tbl WHERE status = 'Active'";
    $totalRecordsResult = mysqli_query($conn, $totalRecordsQuery);
    
    if ($totalRecordsResult) {
        $totalRecords = mysqli_fetch_assoc($totalRecordsResult)['total'];
    } else {
        $totalRecords = 0; // Handle errors gracefully
    }

    // Prepare your data query
    $dataQuery = "SELECT iv_id, college_id, iv_date, department, batch, stu_count, staff_count, incharge_name, incharge_phone, iv_status, status 
                  FROM iv_details_tbl 
                  WHERE status = 'Active'";

    // Add pagination
    $dataQuery .= " LIMIT $start, $length";

    // Execute the data query
    $dataResult = mysqli_query($conn, $dataQuery);

    // Prepare the data array
    $data = [];
    if ($dataResult) {
        while ($row = mysqli_fetch_assoc($dataResult)) {
            $data[] = $row;
        }
    }

    // Prepare the response
    $response = [
        "draw" => $draw,
        "recordsTotal" => $totalRecords,
        "recordsFiltered" => $totalRecords, // Update this if you apply filtering
        "data" => $data
    ];

    // Send the response in JSON format
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}


// get table data ----------------------

if (isset($_GET['date_get']) && $_GET['date_get'] == 'table_value') {
 
    $id = $_GET['id'];
    
    // Prepare your data query
    $dataQuery = "SELECT
                                `iv_stu_id`,
                                `iv_id`,
                                `name`,
                                `phone`,
                                `email`,
                                `address`,
                                `certificate_status`
                            FROM
                                `iv_students`
                            WHERE
                            `status`
                                = 'Active' AND `iv_id` = '$id';";

   

    // Execute the data query
    $dataResult = mysqli_query($conn, $dataQuery);

    // Prepare the data array
    $data = [];
    if ($dataResult) {
        while ($row = mysqli_fetch_assoc($dataResult)) {
            $data[] = $row;
        }
    }



    // Send the response in JSON format
    
    echo json_encode($data);
    exit();
}


// add student -function ------------------

if (isset($_POST['action']) && $_POST['action'] === 'addStudent') {
 

    // Get data from the AJAX request and sanitize it
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $address = (int)$_POST['address'];
    $id =mysqli_real_escape_string($conn, $_POST['iv_id_form']);

                // Call the stored procedure
                $callProcedure = "INSERT INTO `iv_students`(
                                            `iv_id`,
                                            `name`,
                                            `phone`,
                                            `email`,
                                            `address`
                                        )
                                        VALUES(
                                            '$id',
                                            '$name',
                                            '$phone',
                                            '$email',
                                            '$address'
                                        )";

            if (mysqli_query($conn, $callProcedure)) {
                    // Return success response
                    echo json_encode(['status' => 'success', 'message' => 'Visit data saved successfully!']);
                } else {
                    // Return error response if the query failed
                    echo json_encode(['status' => 'error', 'message' => 'Failed to save visit data: ' . mysqli_error($conn)]);
                }
           
    
 
    exit();
}






