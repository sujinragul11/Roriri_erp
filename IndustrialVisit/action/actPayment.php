<?php
session_start();
include("../../db/dbConnection.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addPayment') {
    
    $visit    = $_POST['visit'] ?? '';
    $reason    = $_POST['reason'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $paymentMethod = $_POST['paymentMethod'] ?? ''; // Verify this exists in the form
    $transactionId = $_POST['transactionId'] ?? '';
    $date = $_POST['date'] ?? '';
    $user     = $_SESSION['id'];

  
        // Username is unique, proceed with insertion
        $insQuery = "INSERT INTO `iv_payment_tbl`(
                                            `visit_id`,
                                            `reason`,
                                            `amount`,
                                            `payment_method`,
                                            `traisanction_id`,
                                            `paid_date`,
                                            `created_by`
                                        )
                                        VALUES(
                                            '$visit',
                                            '$reason',
                                            '$amount',
                                            '$paymentMethod',
                                            '$transactionId',
                                            '$date',
                                            '$user'
                                        
                                        )";
                                    
      if ($conn->query($insQuery) === TRUE) {
            $response['success'] = true;
            $response['message'] = "Payment details Created successfully!";
        } else {
            $response['message'] = "Unexpected error in Created Payment details! " . $conn->error;
        }

    echo json_encode($response);
    exit();
}



if (isset($_POST['TableName']) && $_POST['TableName'] != '') {
    // Number of records to fetch
    $limit = $_POST['length']; 
    // Starting point for records
    $offset = $_POST['start']; 
    // Search input
    $searchValue = $conn->real_escape_string($_POST['search']['value']); 
    
    // Base query
    $query = "SELECT a.payment_method, a.id, a.paid_date, a.amount, c.name, a.reason 
              FROM iv_payment_tbl AS a 
              LEFT JOIN iv_details_tbl AS b ON a.visit_id = b.iv_id 
              LEFT JOIN iv_client_tbl AS c ON b.college_id = c.id 
              WHERE a.status ='Active'";

    // Apply search filter if any
    if (!empty($searchValue)) {
        $query .= " AND (c.name LIKE '%$searchValue%' OR a.reason LIKE '%$searchValue%')";
    }

    // Get total data count without filtering
    $totalData = $conn->query($query)->num_rows;

    // Add LIMIT for pagination
    $query .= " LIMIT $offset, $limit"; 
    $result = $conn->query($query);

    // Count filtered records
    $filteredQuery = "SELECT COUNT(*) AS count 
                      FROM iv_payment_tbl AS a 
                      LEFT JOIN iv_details_tbl AS b ON a.visit_id = b.iv_id 
                      LEFT JOIN iv_client_tbl AS c ON b.college_id = c.id 
                      WHERE a.status ='Active'";
                      
    if (!empty($searchValue)) {
        $filteredQuery .= " AND (c.name LIKE '%$searchValue%' OR a.reason LIKE '%$searchValue%')";
    }
    
    $filteredResult = $conn->query($filteredQuery);
    $filteredCount = $filteredResult->fetch_assoc()['count'];

    $data = [];
    while ($row = $result->fetch_assoc()) {
    // Format your data here
    $data[] = [
        'id' => $row['id'],
        'paid_date' => date('d-M-Y', strtotime($row['paid_date'])),
        'amount' => $row['amount'],
        'payment_method' => $row['payment_method'],
        'name' => $row['name'],
        'reason' => $row['reason'],
        'action' => "<td>
            <button type='button' class='btn btn-sm btn-outline-warning' onclick='goEditPayment(" . $row['id'] . ");' data-bs-toggle='modal' data-bs-target='#editClientModal'>
                <i class='lni lni-pencil'></i>
            </button>
        </td>"
    ];
}
    // Send JSON response
    echo json_encode([
        "draw" => intval($_POST['draw']),
        "recordsTotal" => $totalData,
        "recordsFiltered" => $filteredCount, // Updated with filtered count
        "data" => $data
    ]);

    exit();
}

 
 
 // edit function --------------
    if (isset($_POST['editPayId']) && $_POST['editPayId'] !== '') {
    
        $id= $_POST['editPayId'];
        
      $query = "SELECT `id`, `visit_id`, `reason`, `amount`, `payment_method`, `traisanction_id`, `paid_date` FROM `iv_payment_tbl` WHERE `id`=$id;"; 
                
    $result = $conn->query($query);
    
    $categories = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $categories =array(
             'id' => $row['id'],
             'visit_id' => $row['visit_id'],
             'reason' => $row['reason'],
             'amount' => $row['amount'],
             'payment_method' => $row['payment_method'],
             'traisanction_id' => $row['traisanction_id'],
             'paid_date' => $row['paid_date']
             
                
                );
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($categories);
    exit();
    }  
    //update data --------------
       
    
 if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'editPayment') {
        
   $id    = $_POST['editPaymentId'] ?? '';     
   $visit    = $_POST['visit'] ?? '';
    $reason    = $_POST['reason'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $paymentMethod = $_POST['paymentMethod'] ?? ''; // Verify this exists in the form
    $transactionId = $_POST['transactionId'] ?? '';
    $date = $_POST['date'] ?? '';
    $user     = $_SESSION['id'];

      $updateQuery = "UPDATE `iv_payment_tbl`
                SET
                    `visit_id` = '$visit',
                    `reason` = '$reason',
                    `amount` = '$amount',
                    `payment_method` = '$paymentMethod',
                    `traisanction_id` = '$transactionId',
                    `paid_date` = '$date',
                    `updated_by` = '$user'
                WHERE 
                    `id` = '$id'";
                                    
                                    // Debug: Print the query for troubleshooting
                        // echo $updateQuery;

        if ($conn->query($updateQuery) === TRUE) {
            $response['success'] = true;
            $response['message'] = "Payment details Updated successfully!";
        } else {
            $response['message'] = "Unexpected error in Updated Payment details! " . $conn->error;
        }
    
    echo json_encode($response);
    exit();
 }
 


if (isset($_POST['studentId_view']) && $_POST['studentId_view'] !== '') {
    $viewId = $_POST['studentId_view'];

    $ivQuery = "SELECT
                a.`iv_id`,
                a.`college_id`,
                b.`name` AS college_name,
                a.`iv_date`,
                a.`department`,
                a.`batch`,
                a.`stu_count`,
                a.`staff_count`,
                a.`incharge_name`,
                a.`incharge_phone`,
                a.`iv_status`,
                a.`created_at`,
                a.`status`
            FROM
                `iv_details_tbl` AS a
            LEFT JOIN 
                `iv_client_tbl` AS b ON a.`college_id` = b.`id`
            WHERE
                a.`status` = 'Active' AND a.`iv_id` = '$viewId'"; 

    $ivResult = $conn->query($ivQuery);
    $ivDetails = null;

    if ($ivResult && $ivResult->num_rows > 0) {
        $ivDetails = $ivResult->fetch_assoc();
    }

    $studentQuery = "SELECT
                        `iv_stu_id`,
                        `iv_id`,
                        `name`,
                        `phone`,
                        `email`,
                        `address`,
                        `certificate_status`,
                        `status`
                    FROM
                        `iv_students`
                    WHERE
                        `status` = 'Active' AND `iv_id` = '$viewId'";

    $studentResult = $conn->query($studentQuery);

    $students = [];
    if ($studentResult) {
        while ($row = $studentResult->fetch_assoc()) {
            $students[] = array(
                'id' => $row['iv_stu_id'],
                'name' => $row['name'],
                'phone' => $row['phone'],
                'email' => $row['email'],
                'address' => $row['address'],
                'certificate' => $row['certificate_status'],
                'visitId' => $row['iv_id']
            );
        }
    }

    // Combine IV details and student details into one response
    $response = [
        'ivDetails' => $ivDetails,
        'students' => $students
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

if (isset($_POST['htnVisitId']) && $_POST['htnVisitId'] !== '') {
    $visitId     = $_POST['htnVisitId'] ?? '';
    $studentName = $_POST['studentName'] ?? '';
    $phone       = $_POST['stuPhone'] ?? '';
    $email       = $_POST['stuEmail'] ?? '';
    $location    = $_POST['stuLocation'] ?? '';


        $stuQuery = "INSERT INTO `iv_students`(
                        `iv_id`,
                        `name`,
                        `phone`,
                        `email`,
                        `address`
                    )
                    VALUES(
                        '$visitId',
                        '$studentName',
                        '$phone',
                        '$email',
                        '$location'
                    )";
                                    
        if ($conn->query($stuQuery) === TRUE) {
            $response['success'] = true;
            $response['message'] = "Student details added successfully!";
            $response['visitId'] = $visitId;
        } else {
            $response['success'] = false;
            $response['message'] = "Unexpected error in adding Student details! " . $conn->error;
        }

    echo json_encode($response);
    exit();
}
 
if (isset($_POST['editStuId']) && $_POST['editStuId'] !== '') {
    $visitId     = $_POST['editVisitId'] ?? '';
    $stuId       = $_POST['editStuId'] ?? '';
    $studentName = $_POST['studentNameEdit'] ?? '';
    $phone       = $_POST['stuPhoneEdit'] ?? '';
    $email       = $_POST['stuEmailEdit'] ?? '';
    $location    = $_POST['stuLocationEdit'] ?? '';


        $stuEditQuery = "UPDATE
                            `iv_students`
                        SET
                            `name` = '$studentName',
                            `phone` = '$phone',
                            `email` = '$email',
                            `address` = '$location'
                        WHERE
                            `iv_stu_id` = '$stuId'";
                                    
        if ($conn->query($stuEditQuery) === TRUE) {
            $response['success'] = true;
            $response['message'] = "Student details Updated successfully!";
            $response['visitId'] = $visitId;
        } else {
            $response['success'] = false;
            $response['message'] = "Unexpected error in updating Student details! " . $conn->error;
        }

    echo json_encode($response);
    exit();
}

if (isset($_POST['stuId_edit']) && $_POST['stuId_edit'] !== '') {
    
    $id= $_POST['stuId_edit'];
        
    $stuFetchquery = "SELECT
                        `iv_stu_id`,
                        `name`,
                        `phone`,
                        `email`,
                        `address`
                    FROM
                        `iv_students`
                    WHERE
                        `iv_stu_id` = '$id'"; 
                
    $resultStu = $conn->query($stuFetchquery);
    
    $studentDetails = [];
    if ($resultStu) {
        while ($row = $resultStu->fetch_assoc()) {
            $studentDetails =array(
             'id' => $row['iv_stu_id'],
             'name' => $row['name'],
             'phone' => $row['phone'],
             'email' => $row['email'],
             'address' => $row['address']
            );
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($studentDetails);
    exit();
} 

if (isset($_POST['delStuId']) && $_POST['delStuId'] != '') {
    
    $stuId = $_POST['delStuId'];

    $deleteQuery = "UPDATE
                        `iv_students`
                    SET
                        `status` = 'Inactive'
                    WHERE
                        `iv_stu_id` = '$stuId'";

  if ($conn->query($deleteQuery) === TRUE) {
    $response['success'] = true;
    $response['message'] = "Student details Deleted successfully!";
    } else {
    $response['message'] = "Unexpected error in deleting Student details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

if (isset($_POST['issue_all']) && $_POST['issue_all'] != '') {
    
    $visitId = $_POST['issue_all'];
    
        $checkQuery = "SELECT COUNT(*) as count FROM iv_students WHERE certificate_status != 'Issued' AND status = 'Active' AND iv_id = '$visitId'";
        $result = $conn->query($checkQuery);
        
        if ($result) {
            $row = $result->fetch_assoc();
            if ($row['count'] == 0) {
                $response['success'] = false;
                $response['message'] = "All certificates have already been issued for this Visit.";
                echo json_encode($response);
                exit();
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Error checking for students: " . $conn->error;
            echo json_encode($response);
            exit();
        }

    $certificateQuery = "UPDATE iv_students SET certificate_status = 'Issued' WHERE status = 'Active' AND iv_id = '$visitId'";

    if ($conn->query($certificateQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = "All certificates issued successfully!";
    } else {
        $response['success'] = false;
        $response['message'] = "Unexpected error in issuing certificates! " . $conn->error;
    }

    echo json_encode($response);
    exit();
}

if (isset($_POST['visitfeedback']) && $_POST['visitfeedback'] != '') {
        $id = $_POST['visitfeedback'];
        // Fetch messages from the database
        $sql = "SELECT
                    a.`feed_iv`,
                    a.`student_id`,
                    a.`feedback`,
                    a.`created_at`,
                    a.`status`,
                    b.iv_id,
                    b.name
                FROM
                    `iv_feedback_tbl` AS a
                LEFT JOIN iv_students AS b
                ON
                    a.student_id = b.iv_stu_id
                WHERE
                    a.status = 'Active' AND b.iv_id = '$id'";
        $result = mysqli_query($conn, $sql);
        
        $default_image = "https://asset.inforiya.in//ERP/ERP_image//Employee//download.png";
        // Initialize an array to store messages
        $messages = array();

        // Loop through the result and append each message to the array
        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = array(
                'stuId' => $row['student_id'],
                'name' => $row['name'],
                'msg' => htmlspecialchars_decode($row['feedback'], ENT_QUOTES),
                'date_time' => $row['created_at'],
                'user_image' => $default_image
            );
        }

        // Return messages as JSON
        echo json_encode($messages);

        // Close the database connection
        mysqli_close($conn);
    }
    
if (isset($_POST['galleryId']) && $_POST['galleryId'] != '') {
    $id = $_POST['galleryId'];
    $gallerySql = " SELECT
                        a.`gallery_id`,
                        a.`visit_id`,
                        a.`name`,
                        c.`username` AS `college_name`
                    FROM
                        `iv_gallery_tbl` AS `a`
                    LEFT JOIN `iv_details_tbl` AS `b`
                    ON
                        a.`visit_id` = b.`iv_id`
                    LEFT JOIN `iv_client_tbl` AS `c`
                    ON
                        b.`college_id` = c.`id`
                    WHERE
                        a.`status` = 'Active'
                    AND
                        a.`visit_id` = '$id'
                    ORDER BY
                        a.`created_at` DESC";
    $result = mysqli_query($conn, $gallerySql);
        
    $default_image = "https://asset.inforiya.in/ERP/ERP_image/IV/";
    $gallery = array();

    while ($row = mysqli_fetch_assoc($result)) {
        // Construct the full path: base path + college name + file name
        $file_path = $default_image . $row['college_name'] . '/' . $row['name'];

        // Append the file path to the gallery array
        $gallery[] = array(
            'url' => $file_path,
            'id' => $row['gallery_id']
        );
    }

    echo json_encode($gallery);
    exit();
}

if (isset($_POST['galVisitId']) && $_POST['galVisitId'] != '') {
    $visitId = $_POST['galVisitId']; 
    $file    = $_FILES['image'];
    
    // Validate file upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'File upload error.']);
        exit();
    }

    // Fetch the college name associated with the visit ID
    $collegeQuery = "SELECT
                        a.`iv_id`,
                        a.`college_id`,
                        b.username
                    FROM
                        `iv_details_tbl` AS a
                    LEFT JOIN iv_client_tbl AS b
                    ON
                        a.college_id = b.id
                    WHERE
                        a.iv_id = '$visitId'"; 
    $resultCollege = mysqli_query($conn, $collegeQuery);

    if ($resultCollege && mysqli_num_rows($resultCollege) > 0) {
        $row = mysqli_fetch_assoc($resultCollege);
        $collegeName = $row['username']; 
    } else {
        echo json_encode(['success' => false, 'message' => 'Visit ID not found.']);
        exit();
    }

    // Set the upload directory and file name
    $uploadDir   = '../../../asset/ERP/ERP_image/IV/';
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('dMyHis'); 
    $extension   = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)); 
    $fileName    = 'iv' . $visitId . '_' . $currentTime . '.' . $extension;
    $targetFile  = $uploadDir . $collegeName . '/' . $fileName;
    $folderFile  = $collegeName . '/' . $fileName;

    // Create college directory if it doesn't exist
    if (!file_exists($uploadDir . $collegeName)) {
        mkdir($uploadDir . $collegeName, 0755, true);
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        $imagePath = $fileName;
        $insertQuery = "INSERT INTO `iv_gallery_tbl` (`visit_id`, `name`) VALUES ('$visitId', '$imagePath')";
        
         if (mysqli_query($conn, $insertQuery)) {
            // Get the last inserted ID
            $lastInsertId = mysqli_insert_id($conn);
            echo json_encode(['success' => true, 'message' => 'Image was uploaded successfully.', 'id' => $lastInsertId, 'name' => $folderFile]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file.']);
    }
}

if (isset($_POST['delImageId']) && $_POST['delImageId'] != '') {
    
    $imgId = $_POST['delImageId'];

    $deleteQuery = "UPDATE
                        `iv_gallery_tbl`
                    SET
                        `status` = 'Inactive'
                    WHERE
                        `gallery_id` = '$imgId'";

  if ($conn->query($deleteQuery) === TRUE) {
    $response['success'] = true;
    $response['message'] = "Image was Deleted successfully!";
    } else {
    $response['message'] = "Unexpected error in deleting Image! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

?>   