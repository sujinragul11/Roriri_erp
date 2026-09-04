<?php
// include("C:\\xampp\\htdocs\\RORIRI_ERP\\db\\dbConnection.php");
include("../../db/dbConnection.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Add Employee
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addEnquiry') {

    
    $name         =$_POST['name'];
    $phone        =$_POST['phone'];
    $email        =$_POST['email'];
    $collegeName  =$_POST['collegeName'];
    $passoutYear  =$_POST['passoutYear'];
    $department   =$_POST['department'];
    $description  =$_POST['description'];
    $address      =$_POST['address'];
    $followUpDate =$_POST['followUpDate'];
    $comments     =$_POST['comments'];
    $followStatus =$_POST['followStatus'];
    $enquiryDate  =$_POST['enquiryDate'];
    $mode         =$_POST['mode'];
    
    $insQuery ="INSERT INTO `Intern_enquiry`
    (`name`
    , `phone`
    , `email`
    , `college_name`
    , `POY`
    , `department`
    , `description`
    , `address`
    , `follow_up`
    , `comment`
    , `follow_status`
    , `enq_date`
    , `mode`)
     VALUES 
     ('$name'
     ,'$phone'
     ,'$email'
     ,'$collegeName'
     ,'$passoutYear'
     ,'$department'
     ,'$description'
     ,'$address'
     ,'$followUpDate'
     ,'$comments'
     ,'$followStatus'
     ,'$enquiryDate'
     ,'$mode')";

   if ($conn->query($insQuery) === TRUE) {
    $response['success'] = true;
    $response['message'] = "Enquiry details added successfully!";
    } else {
    $response['message'] = "Unexpected error in adding Enquiry details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

//Handles Update the clients details
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'editEnquiry') {

    $id           =$_POST['enqId'];
    $name         =$_POST['editName'];
    $phone        =$_POST['editPhone'];
    $email        =$_POST['editEmail'];
    $collegeName  =$_POST['editCollegeName'];
    $passoutYear  =$_POST['editPassoutYear'];
    $department   =$_POST['editDepartment'];
    $description  =$_POST['editDescription'];
    $address      =$_POST['editAddress'];
    $followUpDate =$_POST['editFollowUpDate'];
    $comments     =$_POST['editComments'];
    $followStatus =$_POST['editFollowStatus'];
    $enquiryDate  =$_POST['editEnquiryDate'];
    $mode         =$_POST['editMode'];

    $UpdateClient="UPDATE `Intern_enquiry`
    SET `name`='$name',
    `phone`='$phone',
    `email`='$email',
    `college_name`='$collegeName',
    `POY`='$passoutYear',
    `department`='$department',
    `description`='$description',
    `address`='$address',
    `follow_up`='$followUpDate',
    `comment`='$comments',
    `follow_status`='$followStatus',
    `enq_date`='$enquiryDate',
    `mode`='$mode'
     WHERE `intern_enquiry_id`='$id'";

         $editResClient = mysqli_query($conn, $UpdateClient);

        if ($editResClient) {
            $_SESSION['message'] = "Enquiry details updated successfully!";
            $response['success'] = true;
            $response['message'] = "Enquiry details updated successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "Error updating database: " . mysqli_error($conn);
        }
         
        echo json_encode($response);
        exit();

}



//Handles Fetching the Clients details for editing 
if (isset($_POST['editEnquiryId']) && $_POST['editEnquiryId'] != '') {
    $editId = $_POST['editEnquiryId'];

    $clientFetch="SELECT * FROM Intern_enquiry WHERE intern_enquiry_id='$editId'";
    $fetchResult = mysqli_query($conn, $clientFetch);
    
    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);
        
        $clientDetails = array(
            'intern_enquiry_id' => $row['intern_enquiry_id'],
            'name' => $row['name'],
            'phone' => $row['phone'],
            'email' => $row['email'],
            'college_name' => $row['college_name'],
            'poy' => $row['POY'],
            'department' => $row['department'],
            'description' => $row['description'],
            'address' => $row['address'],
            'follow_up' => $row['follow_up'],
            'comment' => $row['comment'],
            'follow_status' => $row['follow_status'],
            'enq_date' => $row['enq_date'],
            'mode' => $row['mode']
            

        );
        echo json_encode($clientDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}
//Handles Deleting the Enquiry

if (isset($_POST['clientdeleteId'])) {
    $id = $_POST['clientdeleteId'];
    $queryDel = "UPDATE `Intern_enquiry` SET `status`='Inactive'
    WHERE intern_enquiry_id='$id'";
    $reDel = mysqli_query($conn, $queryDel);

    if ($reDel) {
        $_SESSION['message'] = "Enquiry details have been deleted successfully!";
        $response['success'] = true;
        $response['message'] = "Enquiry details have been deleted successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in deleting Employee details!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}



//Handles Fetching the Clients details for editing 
if (isset($_POST['viewId']) && $_POST['viewId'] != '') {
    $editId = $_POST['viewId'];

    $clientFetch="SELECT * FROM Intern_enquiry WHERE intern_enquiry_id='$editId'";
    $fetchResult = mysqli_query($conn, $clientFetch);
    
    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);

        $followUpDate = !empty($row['follow_up']) ? (new DateTime($row['follow_up']))->format('d-m-Y') : 'N/A';
        
        $clientDetails = array(
            'intern_enquiry_id' => $row['intern_enquiry_id'],
            'name' => $row['name'],
            'phone' => $row['phone'],
            'email' => $row['email'],
            'college_name' => $row['college_name'],
            'poy' => $row['POY'],
            'department' => $row['department'],
            'description' => $row['description'],
            'address' => $row['address'],
            'follow_up' => $followUpDate,
            'comment' => $row['comment'],
            'follow_status' => $row['follow_status'],
            'enq_date' => $row['enq_date'],
            'mode' => $row['mode']

        );
        echo json_encode($clientDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}

if (isset($_GET['report_start_date']) || isset($_GET['end_date']) || isset($_GET['mode'])) {
            $start_date = isset($_GET['report_start_date']) ? $_GET['report_start_date'] : '';
            $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
            $mode = isset($_GET['mode']) ? $_GET['mode'] : '';

            // Build the base SQL query
            $filterquery = "SELECT 
                        `intern_enquiry_id`,
                        `name`,
                        `phone`,
                        `email`,
                        `college_name`,
                        `POY`,
                        `department`,
                        `description`,
                        `follow_up`,
                        `comment`,
                        `follow_status`,
                        `enq_date`,
                        `mode`
                    FROM
                        `Intern_enquiry` 
                    WHERE 
                        `status` = 'Active'"; 
        
            if (!empty($start_date)) {
                $filterquery .= " AND `enq_date` >= '$start_date'";
            }
            if (!empty($end_date)) {
                $filterquery .= " AND `enq_date` <= '$end_date'";
            }
            if (!empty($mode)) {
                $filterquery .= " AND `mode` = '$mode'";
            }
            $filterquery .= " ORDER BY `enq_date` DESC";
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
