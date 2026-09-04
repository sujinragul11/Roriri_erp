<?php
// include("C:\\xampp\\htdocs\\RORIRI_ERP\\db\\dbConnection.php");
include("../../db/dbConnection.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Add Employee
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addClient') {

    
    $name=$_POST['Cname'];
    $compName=$_POST['compName'];
    $email=$_POST['cEmail'];
    $phone=$_POST['cPhone'];
    $gst=$_POST['gst'];
    $address=$_POST['cAddress'];
    $insQuery="INSERT INTO `client_tbl`(`entity_id`, `client_name`, `client_company`, `client_location`, `client_email`, `client_phone`, `client_gst`) VALUES (1,'$name','$compName','$address','$email','$phone','$gst')";

   if ($conn->query($insQuery) === TRUE) {
    $response['success'] = true;
    $response['message'] = "Clients details added successfully!";
    } else {
    $response['message'] = "Unexpected error in adding Clients details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

//Handles Update the clients details
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'editClient') {

    $editName=$_POST['CnameE'];
    $editCID=$_POST['editIdClient'];
    $editComp=$_POST['compNameE'];
    $editGst=$_POST['gstE'];
    $editAddress=$_POST['cAddressE'];
    $editPhone=$_POST['cPhoneE'];
    $editEmail=$_POST['cEmailE'];

    $UpdateClient="UPDATE `client_tbl`
    SET `entity_id`='1',
    `client_name`='$editName',
    `client_company`='$editComp',
    `client_location`='$editAddress',
    `client_email`='$editEmail',
    `client_phone`='$editPhone',
    `client_gst`='$editGst'
     WHERE `client_id`='$editCID'";

         $editResClient = mysqli_query($conn, $UpdateClient);

        if ($editResClient) {
            $_SESSION['message'] = "Client details updated successfully!";
            $response['success'] = true;
            $response['message'] = "Client details updated successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "Error updating database: " . mysqli_error($conn);
        }
         
        echo json_encode($response);
        exit();

}



//Handles Fetching the Clients details for editing 
if (isset($_POST['editIdClient']) && $_POST['editIdClient'] != '') {
    $editId = $_POST['editIdClient'];

    $clientFetch="SELECT * FROM client_tbl WHERE client_id='$editId'";
    $fetchResult = mysqli_query($conn, $clientFetch);
    
    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);
        
        $clientDetails = array(
            'client_id' => $row['client_id'],
            'client_name' => $row['client_name'],
            'comp_name' => $row['client_company'],
            'address' => $row['client_location'],
            'email' => $row['client_email'],
            'phone' => $row['client_phone'],
            'gst' => $row['client_gst'],
            
            

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
    $queryDel = "UPDATE `client_tbl` SET client_status='Inactive'
    WHERE client_id='$id'";
    $reDel = mysqli_query($conn, $queryDel);

    if ($reDel) {
        $_SESSION['message'] = "Client details have been deleted successfully!";
        $response['success'] = true;
        $response['message'] = "Client details have been deleted successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in deleting Employee details!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}
