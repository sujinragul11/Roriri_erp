<?php
session_start();
include("../../db/dbConnection.php");
include("../../url.php");  
include("../../assets/function/function.php");


header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];


if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addDocument') {
    $empId = $_POST['empId'];

    // Fetch the user ID from the admin table
    $userId = getUserIdFromAdmin($empId);
    if (!$userId) {
        $response['success'] = false;
        $response['message'] = "Error: User ID not found in admin table.";
        echo json_encode($response);
        exit();
    }

    // Define directories
    // $aadharDir = "uploads/aadhar/";
    // $bankDir = "uploads/bank/";
    // $panDir = "uploads/pan/";
    // $offerLetterDir = "uploads/offerLetter/";
    // $experienceDir = "uploads/experience/";
    // $paySlipDir = "uploads/paySlip/";

    // Ensure directories exist
    $directories = [$aadharDir, $bankDir, $panDir, $offerLetterDir, $experienceDir, $paySlipDir];
    foreach ($directories as $dir) {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    // Initialize paths and database update array
    $updateFields = [];
    $messages = [];
    $filePaths = [];

    // Handle uploads
    $fileFields = [
        'aadhar' => $aadharDir,
        'bank' => $bankDir,
        'pan' => $panDir,
        'offerLetter' => $offerLetterDir,
        'experience' => $experienceDir,
        'paySlip' => $paySlipDir,
    ];

    foreach ($fileFields as $field => $dir) {
        if (!empty($_FILES[$field]['tmp_name'])) {
            $fileType = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
            $fileName = $userId . "_{$field}." . $fileType;
            $filePath = $dir . $fileName;

            if (move_uploaded_file($_FILES[$field]['tmp_name'], $filePath)) {
                $updateFields[] = "`$field` = '$fileName'";
                // $messages[] = ucfirst($field) . " uploaded successfully!";
                $messages[] = " uploaded successfully!";
                $filePaths[$field] = [
                    'name' => $fileName,
                    'path' => $filePath
                ];
            } else {
                $messages[] = "Failed to upload " . ucfirst($field) . ".";
            }
        } else {
            $messages[] = "No file uploaded for " . ucfirst($field) . ".";
        }
    }

    // Update the database if there are changes
    if (!empty($updateFields)) {
        $updateQuery = "UPDATE `additional_details` SET " . implode(", ", $updateFields) . " WHERE `basic_id` = '$empId'";
        $updateResult = mysqli_query($conn, $updateQuery);

        if ($updateResult) {
            $response['success'] = true;
            $response['message'] = " Employee details updated successfully!";
            $response['data'] = $filePaths; // Include file paths and names in the response
        } else {
            $response['success'] = false;
            $response['message'] = "Error updating database: " . mysqli_error($conn);
        }
    } else {
        $response['success'] = false;
        $response['message'] = "No files uploaded, and no database updates performed.";
    }

    echo json_encode($response);
    exit();
}


//Fetch 


if (isset($_POST['doc']) && $_POST['doc'] != '') {
    $empIdS = $_POST['doc'];
    

    $empFetchS="SELECT * FROM `additional_details` WHERE basic_id='$empIdS'";
    $fetchResultS = mysqli_query($conn, $empFetchS);
    
    if ($fetchResultS) {

        $row1 = mysqli_fetch_assoc($fetchResultS);
            $aadhar_path=$aadharView.$row1['aadhar'];
            $bank_path=$bankView.$row1['bank'];
            $pan_path=$panView.$row1['pan'];
            
            $offerLetter_path=$offerLetterView.$row1['offerLetter'];
            $experience_path=$experienceView.$row1['experience'];
            $paySlip_path=$paySlipView.$row1['paySlip'];
            
        $employeeSalary = array(
            'empId' => $row1['basic_id'],
            'bank'=>$row1['bank'],
            'pan'=>$row1['pan'],
            'aadhar'=>$row1['aadhar'],
            'offerLetter'=>$row1['offerLetter'],
            'experience'=>$row1['experience'],
            'paySlip'=>$row1['paySlip'],
            'aadhar_path'=>$aadhar_path,
            'bank_path'=>$bank_path,
            'pan_path'=>$pan_path,
            'offerLetter_path'=>$offerLetter_path,
            'experience_path'=>$experience_path,
            'paySlip_path'=>$paySlip_path,
        );
        echo json_encode($employeeSalary);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}
?>