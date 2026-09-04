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
        if (!file_exists($dir)) {
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
    if (!empty($_FILES['aadhar']['tmp_name'])) {
        // $aadharTmpName = $_FILES['aadhar']['tmp_name'];
        // $aadharName = basename($_FILES['aadhar']['name']);
        $aadharFileType = strtolower(pathinfo($_FILES['aadhar']['name'], PATHINFO_EXTENSION));
        $aname=$userId."_aadhar.". $aadharFileType;
        $aadharPath = $aadharDir . $aname ;

        if (move_uploaded_file($_FILES['aadhar']['tmp_name'], $aadharPath)) {
            $response['message'] = "Aadhar uploaded successfully!";
        } else {
            $response['message'] = "Failed to upload Aadhar. Path: $aadharPath";
        }
    } else {
        $response['message'] .= " Error uploading Aadhar: " . $_FILES['aadhar']['error'];
    }

    // Handle Bank Passbook file upload
    if (!empty($_FILES['bank']['tmp_name'])) {
        // $bankTmpName = $_FILES['bank']['tmp_name'];
        // $bankName = basename($_FILES['bank']['name']);
        $bankFileType = strtolower(pathinfo($_FILES['bank']['name'], PATHINFO_EXTENSION));
        $bname=$userId."_bank.".$bankFileType;
        $bankPath = $bankDir . $bname ;

        if (move_uploaded_file($_FILES['bank']['tmp_name'], $bankPath)) {
            $response['message'] .= " Bank Passbook uploaded successfully!";
        } else {
            $response['message'] .= " Failed to upload Bank Passbook. Path: $bankPath";
        }
    } else {
        $response['message'] .= " Error uploading Bank Passbook: " . $_FILES['bank']['error'];
    }

    // Handle PAN file upload
    if (!empty($_FILES['pan']['tmp_name'])) {
        // $panTmpName = $_FILES['pan']['tmp_name'];
        // $panName = basename($_FILES['pan']['name']);
        $panFileType = strtolower(pathinfo($_FILES['pan']['name'], PATHINFO_EXTENSION));
        $pname=$userId."_pan.".$panFileType;
        $panPath = $panDir . $pname;

        if (move_uploaded_file($_FILES['pan']['tmp_name'], $panPath)) {
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
            'dir'=>$aadharDir.$aname,
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
            $aadhar_path=$aadharView.$row1['aadhar'];
            $bank_path=$bankView.$row1['bank'];
            $pan_path=$panView.$row1['pan'];
        $employeeSalary = array(
            'empId' => $row1['basic_id'],
            'bank'=>$row1['bank'],
            'pan'=>$row1['pan'],
            'aadhar'=>$row1['aadhar'],
            'aadhar_path'=>$aadhar_path,
            'bank_path'=>$bank_path,
            'pan_path'=>$pan_path,
        );
        echo json_encode($employeeSalary);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}
?>