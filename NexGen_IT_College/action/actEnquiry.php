<?php

include("../../db/dbConnection.php");
include("../../url.php"); 
session_start();
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Add Employee
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addEnquiry') {


    $name=trim($_POST['name']);
   
    $email=trim($_POST['eEmail']);
    $phone=trim($_POST['ePhone']);
    $details=trim($_POST['details']);
    $address=trim($_POST['eAddress']);
    $insQuery="INSERT INTO `enquire_tbl`(`entity_id`, `e_name`,  `e_email`, `e_mobile`, `e_address`, `enquire_details`) VALUES ('$entity_id', '$name','$email','$phone','$address','$details')";

   if ($conn->query($insQuery) === TRUE) {
    $response['success'] = true;
    $response['message'] = "Enquire details added successfully!";
    } else {
    $response['message'] = "Unexpected error in adding Enquire details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

//Handles Update the Enquire details
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'editEnquiry') {

    $editName=trim($_POST['EnameE']);
    $editID=trim($_POST['editEnquiryId']);
    
    $editDetails=trim($_POST['detailsE']);
    $editAddress=trim($_POST['AddressE']);
    $editPhone=trim($_POST['PhoneE']);
    $editEmail=trim($_POST['EmailE']);

    $UpdateEnquire="UPDATE `enquire_tbl`
SET
`e_name`='$editName',

`e_email`='$editEmail',
`e_mobile`='$editPhone',
`e_address`='$editAddress',
`enquire_details`='$editDetails'
WHERE `enquire_id`='$editID'";

         $editResEnquire = mysqli_query($conn, $UpdateEnquire);

        if ($editResEnquire) {
            $_SESSION['message'] = "Enquire details updated successfully!";
            $response['success'] = true;
            $response['message'] = "Enquire details updated successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "Error updating database: " . mysqli_error($conn);
        }
         
        echo json_encode($response);
        exit();

}

//Handles Fetching the Enquire details for editing 
if (isset($_POST['editEnquiryID']) && $_POST['editEnquiryID'] != '') {
    $editId = $_POST['editEnquiryID'];

    $enquireFetch="SELECT * FROM `enquire_tbl` WHERE enquire_id='$editId'";
    $fetchResult = mysqli_query($conn, $enquireFetch);
    
    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);
        
        $enquireDetails = array(
            'enquire_id' => $row['enquire_id'],
            'name' => $row['e_name'],
            'comp_name' => $row['e_company_name'],
            'address' => $row['e_address'],
            'email' => $row['e_email'],
            'phone' => $row['e_mobile'],
            'details' => $row['enquire_details'],
            
            

        );
        echo json_encode($enquireDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}


//Handles Deleting the client

if (isset($_POST['deleteId'])) {
    $id = $_POST['deleteId'];
    $queryDel = "UPDATE `enquire_tbl` SET `enquire_status`='Inactive' WHERE `enquire_id`='$id'";
    $reDel = mysqli_query($conn, $queryDel);

    if ($reDel) {
        $_SESSION['message'] = "Enquire details have been deleted successfully!";
        $response['success'] = true;
        $response['message'] = "Enquire details have been deleted successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in deleting Employee details!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}
