<?php
session_start();
// include("C:\\xampp\\htdocs\\RORIRI_ERP\\db\\dbConnection.php");
include("../../db/dbConnection.php");
include("../../url.php");  
include("../../assets/function/function.php");
include "function.php";

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Add Employee
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addCandidate') {

     // Get form data
     $name = $_POST['name'];
     $incharge = $_POST['incharge'];
     $phone = $_POST['phone'];
     $email = $_POST['email'];
     $mode = $_POST['mode'];
     $gender = $_POST['gender'];
     $join_date = $_POST['joiningDate'];
     $address = $_POST['address'];
     $course_id = $_POST['course'];
     $duration = $_POST['fullDuration'];
     $fees = $_POST['fees'];
     $username = $_POST['username'];
     $password = $_POST['password'];

     // Prevent duplicate candidate entries
     $dupCheck = $conn->prepare("SELECT COUNT(*) AS cnt FROM `internship_tbl` WHERE `username` = ? OR `phone` = ?");
     $dupCheck->bind_param("ss", $username, $phone);
     $dupCheck->execute();
     $dupResult = $dupCheck->get_result()->fetch_assoc();
     if ($dupResult['cnt'] > 0) {
         $response['success'] = false;
         $response['message'] = "A candidate with this username or phone already exists.";
         echo json_encode($response);
         exit();
     }

     // Initialize file paths
     $aadharPath = $panPath = $bankPath = '';
     $aname = $pname = $bname = '';
 
     // Handle Aadhar file upload
     if (!empty($_FILES['image']['tmp_name'])) {
         $aadharFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
         $aname = $username . "_." . $aadharFileType;
         $aadharPath = $internImage . $aname;
 
         if (move_uploaded_file($_FILES['image']['tmp_name'], $aadharPath)) {
             // $response['message'] = "Aadhar uploaded successfully!";
         } else {
             $response['message'] = "Failed to upload Aadhar. Path: $aadharPath";
         }
     }

   

    // Proceed with the database query if image upload was successful or not required
    $insQuery = "INSERT INTO `internship_tbl`
        (`name`
        , `incharge_id`
        , `phone`
        , `email`
        , `mode`
        , `gender`
        , `joining_date`
        , `address`
        , `image`
        , `inte_cou_id`
        , `duration`
        , `payment`
        , `username`
        , `password`) 
        VALUES 
        ('$name'
        , '$incharge'
        , '$phone'
        , '$email'
        , '$mode'
        , '$gender'
        , '$join_date'
        , '$address'
        , '$aname'
        , '$course_id'
        , '$duration'
        , '$fees'
        , '$username'
        , '$password')";

    // Execute the query and send the appropriate response
    if ($conn->query($insQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Candidate details added successfully!";
    } else {
        $response['success'] = false;
        $response['message'] = "Error adding candidate details: " . $conn->error;
    }

    // Send the response back as JSON
    echo json_encode($response);
    exit();
}

// Edit Employee
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'EditCandidate') {
    // Get form data
    $id = $_POST['EditId']; 
    $name = $_POST['nameEdit'];
    $incharge = $_POST['inchargeEdit'];
    $phone = $_POST['phoneEdit'];    
    $email = $_POST['emailEdit'];
    $modeEdit = $_POST['modeEdit'];
    $gender = $_POST['genderEdit'];
    $join_date = $_POST['joiningDateEdit'];
    $address = $_POST['addressEdit'];
    $course_id = $_POST['courseEdit'];
    $duration = $_POST['fullDuration'];
    $fees = $_POST['feesEdit'];
    $usernameEdit = $_POST['usernameEdit'];
    $password = $_POST['passwordEdit'];

    // Initialize file path and existing image variable
    $aadharPath = '';
    $existingImage = ''; // Variable to store the existing image path


    // Handle Aadhar file upload if a new file is uploaded
    if (!empty($_FILES['imageEdit']['tmp_name'])) {
        $aadharFileType = strtolower(pathinfo($_FILES['imageEdit']['name'], PATHINFO_EXTENSION));
        $aname = $usernameEdit . "_." . $aadharFileType;
        $aadharPath = $internImage . $aname;

        // Move uploaded file and check for success
        if (move_uploaded_file($_FILES['imageEdit']['tmp_name'], $aadharPath)) {
            // If the upload was successful, set the new image name
            $aadharPath = $aname; 
        } else {
            $response['message'] = "Failed to upload Image. Path: $aadharPath";
            echo json_encode($response);
            exit();
        }
    } else {
        // If no new image is uploaded, keep the existing image path
        $aadharPath = $existingImage; 
    }

    // Prepare the update query
    // Only update the image field if a new image was uploaded
    $updQuery = "UPDATE `internship_tbl` SET 
        `name` = '$name', 
        `incharge_id` = '$incharge',
        `phone` = '$phone', 
        `email` = '$email', 
        `mode` = '$modeEdit', 
        `gender` = '$gender', 
        `joining_date` = '$join_date', 
        `address` = '$address', 
        `inte_cou_id` = '$course_id', 
        `duration` = '$duration', 
        `payment` = '$fees', 
        `password` = '$password' 
        WHERE intern_id = '$id'";

    // Check if a new image was uploaded, if so include it in the update
    if (!empty($_FILES['imageEdit']['tmp_name'])) {
        $updQuery = "UPDATE `internship_tbl` SET 
            `name` = '$name', 
            `incharge_id` = '$incharge',
            `phone` = '$phone', 
            `email` = '$email', 
            `mode` = '$modeEdit', 
            `gender` = '$gender', 
            `joining_date` = '$join_date', 
            `address` = '$address', 
            `image` = '$aname', 
            `inte_cou_id` = '$course_id', 
            `duration` = '$duration', 
            `payment` = '$fees', 
            `password` = '$password' 
            WHERE intern_id = '$id'";
    }

    // Execute the query and send the appropriate response
    if ($conn->query($updQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Candidate details updated successfully!";
    } else {
        $response['success'] = false;
        $response['message'] = "Error updating candidate details: " . $conn->error;
    }

    // Send the response back as JSON
    echo json_encode($response);
    exit();
}

//Handles Fetching the Clients details for editing 
if (isset($_POST['editIdClient']) && $_POST['editIdClient'] != '') {
    $editId = $_POST['editIdClient'];

    $clientFetch="SELECT * FROM internship_tbl WHERE intern_id='$editId'";
    $fetchResult = mysqli_query($conn, $clientFetch);
    
    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);

        // Assume you fetched the duration from the database
    $fullDuration = $row['duration']; // Example value from the database

// Split the duration into number and unit
    list($durationNo, $durationUnit) = explode(" ", $fullDuration, 2);
        
        $clientDetails = array(
            'id' => $row['intern_id'],
            'name' => $row['name'],
            'incharge' => $row['incharge_id'],
            'phone' => $row['phone'],
            'email' => $row['email'],
            'mode' => $row['mode'],
            'gender' => $row['gender'],
            'join_date' => $row['joining_date'],
            'address' => $row['address'],
            // 'image' => $row['image'],
            'course_id' => $row['inte_cou_id'],
            'durationNO' => $durationNo,
            'duration' => $durationUnit,
            'fees' => $row['payment'],
            'username' => $row['username'],
            'password' => $row['password'],


            
            

        );
        echo json_encode($clientDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}
//Handles Deleting the client

if (isset($_POST['clientdeleteId'])) {
    $id = $_POST['clientdeleteId'];
    $status = $_POST['status'];
    $queryDel = "UPDATE `internship_tbl` SET status ='$status'
    WHERE intern_id='$id'";
    $reDel = mysqli_query($conn, $queryDel);

    if ($reDel) {
        $_SESSION['message'] = "Candidate Status have been changed successfully!";
        $response['success'] = true;
        $response['message'] = "Candidate Status have been changed successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in changed Candidate Status!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}

if (isset($_POST['certificate'])) {
    $id = $_POST['certificate'];
    $queryDel = "UPDATE `internship_tbl` SET certificate_status ='Active'
    WHERE intern_id='$id'";
    $reDel = mysqli_query($conn, $queryDel);

    if ($reDel) {
        $_SESSION['message'] = "Certificate Create successfully!";
        $response['success'] = true;
        $response['message'] = "Certificate Create successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in deleting Certificate details!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}

// Handles Fetching the Clients details for View page 
if (isset($_POST['viewIdClient']) && $_POST['viewIdClient'] != '') {
    $editId = $_POST['viewIdClient'];

    // Fetch client details with course name
    $clientFetch = "SELECT a.*, b.intern_course_name, c.name AS inchargeName 
                    FROM internship_tbl as a 
                    LEFT JOIN inter_course_tbl as b 
                    ON a.inte_cou_id = b.inte_cou_id 
                    LEFT JOIN basic_details as c 
                    ON a.incharge_id = c.id 
                    WHERE intern_id='$editId'";
    $fetchResult = mysqli_query($conn, $clientFetch);
    
    if ($fetchResult) {
        $row = mysqli_fetch_assoc($fetchResult);

        // Split the duration into number and unit
        $fullDuration = $row['duration']; 
        list($durationNo, $durationUnit) = explode(" ", $fullDuration, 2);

        // Normalize duration unit (convert singular to plural)
        $durationUnit = strtolower($durationUnit); // Convert to lowercase to avoid case mismatches
        if ($durationUnit === 'day') {
            $durationUnit = 'days';
        } elseif ($durationUnit === 'week') {
            $durationUnit = 'weeks';
        } elseif ($durationUnit === 'month') {
            $durationUnit = 'months';
        } elseif ($durationUnit === 'year') {
            $durationUnit = 'years';
        }

        $trackFetch = "SELECT task_mark 
                       FROM intern_appli_track 
                       WHERE intern_id = '$editId' AND trainer_status = 'Completed' AND status = 'Active'";
        $trackResult = mysqli_query($conn, $trackFetch);
        
        $totalObtainedMarks = 0;
        $totalTasks = 0;
        
        // Loop through the results to calculate total marks and task count
        while ($trackRow = mysqli_fetch_assoc($trackResult)) {
            $totalObtainedMarks += (float)$trackRow['task_mark'];
            $totalTasks++;
        }
        
        // Each task is worth 10 marks
        $marksPerTask = 10;
        $totalMaxMarks = $totalTasks * $marksPerTask;
        
        // Calculate percentage
        $percentage = (!empty($totalObtainedMarks)) ? number_format(($totalObtainedMarks / $totalMaxMarks) * 100, 2) : 0;
        // Fetch the payment details (sum of amount and balance, status, and amount status)
        $paymentFetch = "SELECT SUM(inter_amount) AS totalAmount, 
                                tranx_id,
                                received_date,
                                received_by, 
                                pay_mode,
                                inter_paym_id 
                         FROM intern_payment 
                         WHERE intern_id='$editId' AND status = 'Active'";
        $paymentResult = mysqli_query($conn, $paymentFetch);

        if ($paymentResult) {
            $paymentRow = mysqli_fetch_assoc($paymentResult);
            
            // Calculate duration days
            switch ($durationUnit) {
                case 'days':
                    $daysMultiplier = 1;
                    break;
                case 'weeks':
                    $daysMultiplier = 7;
                    break;
                case 'months':
                    $daysMultiplier = 30; // Approximate value for months
                    break;
                case 'years':
                    $daysMultiplier = 365; // Approximate value for years
                    break;
                default:
                    $daysMultiplier = 0;
            }

            // Total duration in days
            $durationDays = $durationNo * $daysMultiplier;

            // Calculate remaining days
            $joiningDate = new DateTime($row['joining_date']); // From database in Y-m-d format
            $currentDate = new DateTime(); // Current date

            // Difference in days
            if ($joiningDate > $currentDate) {
                // Joining date is in the future
                $daysElapsed = 0;
            } else {
                $daysElapsed = $joiningDate->diff($currentDate)->days;
            }

            // Calculate remaining days, but don't allow less than 0
            $remainingDays = max(0, $durationDays - $daysElapsed);
            $endDate = clone $joiningDate;
            $endDate->modify("+{$durationDays} days");
            
            $workingDays = $row['total_workingdays']; 
            list($numerator, $denominator) = explode('/', $workingDays);
            if ($denominator == 0) {
                $attendance = 0; 
            } else {
                $attendance = ($numerator / $denominator) * 100;
            }
            $attendance = round($attendance, 2);

            // Prepare the response data with both client and payment details
            $clientDetails = array(
                'id' => $row['intern_id'],
                'name' => $row['name'],
                'incharge' => $row['inchargeName'],
                'phone' => $row['phone'],
                'email' => $row['email'],
                'mode' => $row['mode'],
                'gender' => $row['gender'],
                'join_date' => (new DateTime($row['joining_date']))->format('d M Y'),
                'end_date' => $endDate->format('d M Y'),
                'address' => $row['address'],
                'image' => $row['image'],
                'course_id' => $row['intern_course_name'],
                'durationNO' => $durationNo,
                'duration' => $durationUnit,
                'fees' => $row['payment'],
                'username' => $row['username'],
                'password' => $row['password'],
                'certificate_status' => $row['certificate_status'],
                'remaining_days' => $remainingDays, // Correctly calculated remaining days
                'performance' => $percentage,
                'attendance' => $attendance,
                // Payment details
                'totalAmount' => $paymentRow['totalAmount'],
                'tranx_id' => $paymentRow['tranx_id'],
                'received_date' => $paymentRow['received_date'],
                'received_by' => $paymentRow['received_by'],
                'pay_mode' => $paymentRow['pay_mode'],
                'inter_paym_id' => $paymentRow['inter_paym_id']
            );

            echo json_encode($clientDetails);
        } else {
            $response['message'] = "Error fetching payment details: " . mysqli_error($conn);
            echo json_encode($response);
        }
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}

//Delete the payment details
if (isset($_POST['paymentId'])) {
    $id = $_POST['paymentId'];
    $paymentDel = "UPDATE `intern_payment` SET status ='Inactive'
    WHERE inter_paym_id = '$id'";
    $rtnpayment = mysqli_query($conn, $paymentDel);

    if ($rtnpayment) {
        $_SESSION['message'] = "Payment details have been deleted successfully!";
        $response['success'] = true;
        $response['message'] = "Payment details have been deleted successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in deleting Payment details!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}

//Handles Add the payment details 
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'TraineePayment') {
    $intern_id = $_POST['TraineePay'];
    $amount = $_POST['balance'];
    $remaining = $_POST['remaining'];
     $date = $_POST['date'];
    $payMode = $_POST['payMode'];
    $receivedBy = $_SESSION['id'];
    $transId = $_POST['trans'];
    // $entity = 3; // or assign the correct entity ID

    $insertPayment = "INSERT INTO `intern_payment`
    ( `intern_id`
    , `inter_amount`
    , `tranx_id`
    , `received_date`
    , `pay_mode`
    , `pay_balance`
    , `received_by`) 
     VALUES 
     ('$intern_id'
     ,'$amount'
     ,'$transId'
     ,'$date'
     ,'$payMode'
     ,'$remaining'
     ,'$receivedBy')";

    // Log the query
    error_log($insertPayment);

    if ($conn->query($insertPayment) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Payment details added successfully!";
    } else {
        $response['success'] = false;
        $response['message'] = "Unexpected error in adding Payment details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

// payment table data -----------------
if (isset($_POST['internId'])) {
    $internId = $_POST['internId'];

    // Query to fetch payment details for the intern
    $query = "SELECT 
                a.inter_paym_id,
                a.intern_id,
                a.received_date,
                a.inter_amount,
                a.received_by,
                a.pay_mode,
                b.name AS empName
              FROM intern_payment AS a 
              LEFT JOIN basic_details AS b ON a.received_by = b.id 
              WHERE a.intern_id = '$internId' AND a.status = 'Active'
              ORDER BY a.received_date DESC";

    $result = mysqli_query($conn, $query);

    $payments = array();

    while ($row = mysqli_fetch_assoc($result)) {
        // Format the date and amount
        $row['formatted_date'] = date('d-M-Y', strtotime($row['received_date']));
        $row['formatted_amount'] = number_format($row['inter_amount'], 2, '.', ',');
        $row['received_by'] = $row['empName']; 
        $row['inter_paym_id'];
        $payments[] = $row;
    }

    echo json_encode($payments); // Send the JSON response back to the client
}

if (isset($_POST['status']) && $_POST['status'] != '') {

    $status = $_POST['status'];

// Prepare SQL query based on the selected status
                    $sql = "SELECT 
                                a.`intern_id`,
                                a.`name`,
                                a.`phone`,
                                a.`email`,
                                a.`mode`,
                                a.`gender`,
                                a.`joining_date`,
                                a.`address`,
                                a.`image`,
                                a.`inte_cou_id`,
                                a.`duration`,
                                a.`payment`,
                                a.`username`,
                                a.`password`,
                                b.`intern_course_name`,
                                IFNULL(payment_summary.totalAmount, 0) AS totalAmount
                            FROM 
                                `internship_tbl` AS a 
                            LEFT JOIN 
                                `inter_course_tbl` AS b ON a.`inte_cou_id` = b.`inte_cou_id`
                            LEFT JOIN 
                                (
                                    SELECT 
                                        intern_id, 
                                        SUM(inter_amount) AS totalAmount
                                    FROM 
                                        intern_payment 
                                    WHERE 
                                        status = 'Active' 
                                    GROUP BY 
                                        intern_id
                                ) AS payment_summary ON a.`intern_id` = payment_summary.intern_id
                            WHERE 
                                a.`status` = ? AND a.intern_id !=5 ORDER BY `joining_date` DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $status); // Bind the status parameter
$stmt->execute();
$result = $stmt->get_result();

$employees = [];
while ($row = $result->fetch_assoc()) {
    $employees[] = $row; // Collect the employee data
}

echo json_encode($employees); // Return the data as JSON

}

//Task Ajax and conditions 
if (isset($_POST['int_id']) && $_POST['int_id'] != '') {
    // Set the session variable for the intern ID
    $_SESSION['int_id'] = $_POST['int_id'];
    
    // You can return a response if needed
    echo json_encode(["status" => "success", "message" => "Session set successfully"]);
}

//Add Task Query
if (isset($_POST['intern_id']) && $_POST['intern_id'] !== '') {
    $intern_id = htmlspecialchars($_POST['intern_id'], ENT_QUOTES, 'UTF-8');
    $appli_name = htmlspecialchars($_POST['appli_name'], ENT_QUOTES, 'UTF-8');
    $appli_description = htmlspecialchars($_POST['appli_description'], ENT_QUOTES, 'UTF-8');
    $assignee_id = $_SESSION['id'];

    // Set the timezone to Asia/Kolkata
    date_default_timezone_set('Asia/Kolkata');
    $currentTime = date('Y-m-d H:i:s'); 
    
    $imageNames = [];

    // Check if files were uploaded
    if (!empty($_FILES['documents']['name'][0])) {
        // Loop through each uploaded file
        foreach ($_FILES['documents']['tmp_name'] as $index => $tmpName) {
            $fileName = basename($_FILES['documents']['name'][$index]);
            $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $currentTimeFormatted = date('dMyHis');
            $uniqueFileName = "img_" . $currentTimeFormatted . '_' . ($index + 1) . '.' . $fileType;
            $targetPath = '../../../asset/ERP/ERP_image/internTask/' . $uniqueFileName; // Define target path
    
            // Move uploaded file to target directory
            if (move_uploaded_file($tmpName, $targetPath)) {
                $imageNames[] = $uniqueFileName; // Add the unique filename (not full path) to array
            } else {
                $response['success'] = false;
                $response['message'] = "Failed to upload image: $fileName";
                echo json_encode($response);
                exit();
            }
        }
    }
    
    $imageNamesString = implode(",", $imageNames);

    $taskQuery = "INSERT INTO `intern_appli_track`
    ( `intern_id`
    , `appli_name`
    , `appli_description`
    , `refer_documents`
    , `assigned_by`
    , `created_at`) 
     VALUES 
     ('$intern_id'
     ,'$appli_name'
     ,'$appli_description'
     ,'$imageNamesString'
     ,'$assignee_id'
     , '$currentTime')"; 

    if ($conn->query($taskQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Task details added successfully!";
    } else {
        $response['success'] = false;
        $response['message'] = "Unexpected error in adding Task details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

//Fetch the Edit Task Details
if (isset($_POST['appli_id']) && $_POST['appli_id'] !== '') {
    $appli_id = $_POST['appli_id'];
    
    $taskFetch="SELECT
                    `appli_id`,
                    `appli_name`,
                    `appli_description`,
                    `task_mark`,
                    `trainer_status`
                FROM
                    `intern_appli_track`
                WHERE
                    appli_id = '$appli_id'";
    $taskResult = mysqli_query($conn, $taskFetch);
    
    if ($taskResult) {

        $row = mysqli_fetch_assoc($taskResult);
        
        $taskDetails = array(
            'id' => htmlspecialchars_decode($row['appli_id'], ENT_QUOTES),
            'name' => htmlspecialchars_decode($row['appli_name'], ENT_QUOTES),
            'appli_description' => htmlspecialchars_decode($row['appli_description'], ENT_QUOTES),
            'task_mark' => htmlspecialchars_decode($row['task_mark'], ENT_QUOTES),
            'trainer_status' => htmlspecialchars_decode($row['trainer_status'], ENT_QUOTES)
        );
        echo json_encode($taskDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}

//Ajax for update the edited task details
if (isset($_POST['appli_nameEdit']) && $_POST['appli_nameEdit'] !== '') {
    $internId       = htmlspecialchars($_POST['intern_idEdit'], ENT_QUOTES, 'UTF-8');
    $applyId        = htmlspecialchars($_POST['appli_idEdit'], ENT_QUOTES, 'UTF-8');
    $name           = htmlspecialchars($_POST['appli_nameEdit'], ENT_QUOTES, 'UTF-8');
    $description    = htmlspecialchars($_POST['appli_descriptionEdit'], ENT_QUOTES, 'UTF-8');
    $status         = htmlspecialchars($_POST['statusEdit'], ENT_QUOTES, 'UTF-8');
    $mark           = htmlspecialchars($_POST['taskMark'], ENT_QUOTES, 'UTF-8');
    $verified_by    = $_SESSION['id'];
    
    date_default_timezone_set('Asia/Kolkata');
    
    $imageNames = [];

    // Check if files were uploaded
    if (!empty($_FILES['documentsEdit']['name'][0])) {
        // Loop through each uploaded file
        foreach ($_FILES['documentsEdit']['tmp_name'] as $index => $tmpName) {
            $fileName = basename($_FILES['documentsEdit']['name'][$index]);
            $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $currentTimeFormatted = date('dMyHis');
            $uniqueFileName = "img_" . $currentTimeFormatted . '_' . ($index + 1) . '.' . $fileType;
            $targetPath = '../../../asset/ERP/ERP_image/internTask/' . $uniqueFileName; // Define target path
    
            // Move uploaded file to target directory
            if (move_uploaded_file($tmpName, $targetPath)) {
                $imageNames[] = $uniqueFileName; // Add the unique filename (not full path) to array
            } else {
                $response['success'] = false;
                $response['message'] = "Failed to upload image: $fileName";
                echo json_encode($response);
                exit();
            }
        }
    }
    
    $imageNamesString = implode(",", $imageNames);
    
    $updateTask = "UPDATE `intern_appli_track` SET 
        `appli_name` = '$name', 
        `appli_description` = '$description', 
        `refer_documents` = '$imageNamesString', 
        `trainer_status` = '$status', 
        `task_mark` = '$mark', 
        `verified_by` = '$verified_by'";

    if ($status === 'Completed') {
        $currentTime = date('Y-m-d h:i:s A'); 
        $updateTask .= ", `verified_time` = '$currentTime'"; 
    }

    $updateTask .= " WHERE appli_id = '$applyId'";

    if (mysqli_query($conn, $updateTask)) {
        $response['success'] = true;
        $response['message'] = "Task details Updated successfully!";
    } else {
        $response['success'] = false;
        $response['message'] = "Unexpected error in updating Task details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

if (isset($_POST['viewTaskId']) && $_POST['viewTaskId'] != '') {
    $task_id = $_POST['viewTaskId'];

      $queryFetch = "SELECT
                        a.`appli_id`,
                        a.`intern_id`,
                        a.`appli_name`,
                        a.`refer_documents`,
                        a.`intern_descript`,
                        a.`intern_status`,
                        a.`trainer_status`,
                        a.`assigned_by`,
                        a.`verified_by`,
                        a.`task_mark`,
                        a.`created_at`,
                        a.`verified_time`,
                        b.name AS assignBy,
                        c.name AS verifyBy
                    FROM
                        `intern_appli_track` AS a 
                    LEFT JOIN 
                        `basic_details` AS b 
                    ON a.assigned_by = b.id 
                    LEFT JOIN 
                        `basic_details` AS c 
                    ON a.verified_by = c.id
                    WHERE
                        a.`appli_id` = '$task_id'";
    $fetchResult = mysqli_query($conn, $queryFetch);
    
    if ($fetchResult) {
        $row = mysqli_fetch_assoc($fetchResult);

        $expenseDetails = array(
            'task'          => $row['appli_name'],
            'assignDate'    => (new DateTime($row['created_at']))->format('d M Y'),
            'assignBy'      => $row['assignBy'],
            'taskStatus'    => $row['intern_status'],
            'verifyDate'    => (new DateTime($row['verified_time']))->format('d M Y'),
            'verifyStatus'  => htmlspecialchars_decode($row['trainer_status'], ENT_QUOTES),
            'verifyBy'      => htmlspecialchars_decode($row['verifyBy'], ENT_QUOTES),
            'referImages'   => htmlspecialchars_decode($row['refer_documents'], ENT_QUOTES),
            'taskMark'      => $row['task_mark'],
            'internDescript'=> htmlspecialchars_decode($row['intern_descript'], ENT_QUOTES)
        );
        echo json_encode($expenseDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}


       // get  History-----------
        if (isset($_GET['report_start_date']) || isset($_GET['end_date']) || isset($_GET['duration']) || isset($_GET['mode']) || isset($_GET['course']) || isset($_GET['payment']) || isset($_GET['incharge'])) {
            $start_date = isset($_GET['report_start_date']) ? $_GET['report_start_date'] : '';
            $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
            $duration = isset($_GET['duration']) ? $_GET['duration'] : '';
            $mode = isset($_GET['mode']) ? $_GET['mode'] : '';
            $course = isset($_GET['course']) ? $_GET['course'] : '';
            $payment = isset($_GET['payment']) ? $_GET['payment'] : '';
            $incharge = isset($_GET['incharge']) ? $_GET['incharge'] : '';
            $status = isset($_GET['status']) ? $_GET['status'] : '';
        
            // Build the base SQL query
            $filterquery = "SELECT 
                                a.`intern_id`,
                                a.`name`,
                                a.`phone`,
                                a.`email`,
                                a.`mode`,
                                a.`gender`,
                                a.`joining_date`,
                                a.`address`,
                                a.`image`,
                                a.`inte_cou_id`,
                                a.`duration`,
                                a.`payment`,
                                a.`username`,
                                a.`password`,
                                b.`intern_course_name`,
                                IFNULL(payment_summary.totalAmount, 0) AS totalAmount
                            FROM 
                                `internship_tbl` AS a 
                            LEFT JOIN 
                                `inter_course_tbl` AS b ON a.`inte_cou_id` = b.`inte_cou_id`
                            LEFT JOIN 
                                (
                                    SELECT 
                                        intern_id, 
                                        SUM(inter_amount) AS totalAmount
                                    FROM 
                                        intern_payment 
                                    WHERE 
                                        status = 'Active' 
                                    GROUP BY 
                                        intern_id
                                ) AS payment_summary ON a.`intern_id` = payment_summary.intern_id
                            WHERE 
                                a.`status` = '$status' AND a.intern_id !=5"; 
        
            if (!empty($start_date)) {
                $filterquery .= " AND a.`joining_date` >= '$start_date'";
            }
            if (!empty($end_date)) {
                $filterquery .= " AND a.`joining_date` <= '$end_date'";
            }
            if (!empty($duration)) {
                $filterquery .= " AND a.`duration` = '$duration'";
            }
            if (!empty($mode)) {
                $filterquery .= " AND a.`mode` = '$mode'";
            }
            if (!empty($course)) {
                $filterquery .= " AND a.`inte_cou_id` = '$course'";
            }
            if (!empty($incharge)) {
                $filterquery .= " AND a.`incharge_id` = '$incharge'";
            }
            if (!empty($payment)) {
                // Filter based on 'Completed' or 'Pending' payment status
                if ($payment === 'Completed') {
                    $filterquery .= " AND a.`payment` <= IFNULL(payment_summary.totalAmount, 0)";
                } elseif ($payment === 'Pending') {
                    $filterquery .= " AND a.`payment` > IFNULL(payment_summary.totalAmount, 0)";
                }
            }
            $filterquery .= " ORDER BY a.`joining_date` DESC";
            $resFilter = mysqli_query($conn, $filterquery);
            
            $assets = [];
        
            while ($row = mysqli_fetch_assoc($resFilter)) {
                $assets[] = $row; // Collect the data
            }
        
            header('Content-Type: application/json');
            echo json_encode($assets);
            exit();
        }
?>