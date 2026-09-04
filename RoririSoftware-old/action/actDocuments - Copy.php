<?php
session_start();
include("../../db/dbConnection.php");
include("../../url.php");  
include("../../assets/function/function.php");

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];


// Add Documents
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

    // Define directories for each document type
   

    // Ensure directories exist; create if not
    foreach ([$aadharDir, $panDir, $bankDir] as $dir) {
        if (!@opendir($dir)) {
            if (!mkdir($dir, 0777, true)) {
                $response['success'] = false;
                $response['message'] = "Failed to create directory for image upload.";
                echo json_encode($response);
                exit();
            }
        }
    }
// Initialize paths
$aadharPath = $panPath = $bankPath = '';
    // Handle Aadhar file upload
    if (isset($_FILES['aadhar']) && $_FILES['aadhar']['error'] === UPLOAD_ERR_OK) {
        $aadharTmpName = $_FILES['aadhar']['tmp_name'];
        $aadharName = basename($_FILES['aadhar']['name']);
        $aadharFileType = strtolower(pathinfo($aadharName, PATHINFO_EXTENSION));
        $aname=$userId."_aadhar.". $aadharFileType;
        $aadharPath = $aadharDir . $aname ;

        if (move_uploaded_file($aadharTmpName, $aadharPath)) {
            $response['message'] = "Aadhar uploaded successfully!";
        } else {
            $response['message'] = "Failed to upload Aadhar. Path: $aadharPath";
        }
    } else {
        $response['message'] .= " Error uploading Aadhar: " . $_FILES['aadhar']['error'];
    }

    // Handle Bank Passbook file upload
    if (isset($_FILES['bank']) && $_FILES['bank']['error'] === UPLOAD_ERR_OK) {
        $bankTmpName = $_FILES['bank']['tmp_name'];
        $bankName = basename($_FILES['bank']['name']);
        $bankFileType = strtolower(pathinfo($bankName, PATHINFO_EXTENSION));
        $bname=$userId."_bank.".$bankFileType;
        $bankPath = $bankDir . $bname ;

        if (move_uploaded_file($bankTmpName, $bankPath)) {
            $response['message'] .= " Bank Passbook uploaded successfully!";
        } else {
            $response['message'] .= " Failed to upload Bank Passbook. Path: $bankPath";
        }
    } else {
        $response['message'] .= " Error uploading Bank Passbook: " . $_FILES['bank']['error'];
    }

    // Handle PAN file upload
    if (isset($_FILES['pan']) && $_FILES['pan']['error'] === UPLOAD_ERR_OK) {
        $panTmpName = $_FILES['pan']['tmp_name'];
        $panName = basename($_FILES['pan']['name']);
        $panFileType = strtolower(pathinfo($bname, PATHINFO_EXTENSION));
        $pname=$userId."_pan.".$panFileType;
        $panPath = $panDir . $pname;

        if (move_uploaded_file($panTmpName, $panPath)) {
            $response['message'] .= " PAN uploaded successfully!";
        } else {
            $response['message'] .= " Failed to upload PAN. Path: $panPath";
        }
    } else {
        $response['message'] .= " Error uploading PAN: " . $_FILES['pan']['error'];
    }

    // Update employee details in the database
    $editQuery = "UPDATE `additional_details` SET `aadhar`='$aname', `bank`='$bname', `pan`='$pname' WHERE `basic_id`='$empId'";
    $editRes = mysqli_query($conn, $editQuery);

    if ($editRes) {
        $_SESSION['message'] = "Employee details updated successfully!";
        $response['success'] = true;
        $response['message'] .= " Employee details updated successfully!";
        $response['data'] = [
            'aadhar_path' => $aadharView . $aname,
            'bank_path' => $bankView . $bname,
            'pan_path' => $panView . $pname
        ];
    } else {
        $response['success'] = false;
        $response['message'] .= " Error updating database: " . mysqli_error($conn);
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
       
        $employeeSalary = array(
            'empId' => $row1['basic_id'],
            'bank'=>$row1['bank'],
            'pan'=>$row1['pan'],
            'aadhar'=>$row1['aadhar'],
            
        );
        echo json_encode($employeeSalary);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}
?>