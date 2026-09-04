<?php
// include("C:\\xampp\\htdocs\\RORIRI_ERP\\db\\dbConnection.php");
include("../../db/dbConnection.php");

session_start();


header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Add Employee
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addEnquire') {


    $name=$_POST['name'];
    $compName=$_POST['compName'];
    $email=$_POST['eEmail'];
    $phone=$_POST['ePhone'];
    $details=$_POST['details'];
    $address=$_POST['eAddress'];
    $date   = $_POST['date'];
    $status = $_POST['estatus'];
    $insQuery="INSERT INTO `enquire_tbl`(`entity_id`, `e_name`, `e_company_name`, `e_email`, `e_mobile`, `e_address`, `enquire_details`, `e_date`, `enquiry_status`) VALUES ('1', '$name','$compName','$email','$phone','$address','$details', '$date', '$status')";

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
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'editEnquire') {

    $editName=$_POST['EnameE'];
    $editID=$_POST['editIdEnquire'];
    $editComp=$_POST['compNameE'];
    $editDetails=$_POST['detailsE'];
    $editAddress=$_POST['AddressE'];
    $editPhone=$_POST['PhoneE'];
    $editEmail=$_POST['EmailE'];
    $date   = $_POST['dateEdit'];
    $status = $_POST['estatusEdit'];

    $UpdateEnquire="UPDATE 
                        `enquire_tbl`
                    SET
                        `e_name`='$editName',
                        `e_company_name`='$editComp',
                        `e_email`='$editEmail',
                        `e_mobile`='$editPhone',
                        `e_address`='$editAddress',
                        `enquire_details`='$editDetails',
                        `e_date`='$date',
                        `enquiry_status`='$status'
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
if (isset($_POST['editIdEnquire']) && $_POST['editIdEnquire'] != '') {
    $editId = $_POST['editIdEnquire'];

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
            'date' => $row['e_date'],
            'estatus' => $row['enquiry_status']
            

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


   // get  History-----------
    if (isset($_GET['report_start_date']) && $_GET['report_start_date'] !== '') {
    
        // Get the filter values from the AJAX request
        $start_date = isset($_GET['report_start_date']) ? $_GET['report_start_date'] : '';
        $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
        
        // Build the SQL query with filters
        $query = "SELECT
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
                `status`
            FROM
                `Intern_enquiry`
            WHERE `status`='Active'"; // Replace 'assets' with your table name
        
        if ($start_date) {
            $query .= " AND created_at >= '$start_date'";
        }
        if ($end_date) {
            $query .= " AND created_at <= '$end_date'";
        }
      
        $query .= " ORDER BY `intern_enquiry_id` DESC";
        $resQuery = mysqli_query($conn, $query);
        $assets = [];
        
        while ($row = mysqli_fetch_assoc($resQuery)) {
            $assets[] = $row; // Collect the data
        }

    
    header('Content-Type: application/json');
    echo json_encode($assets);
    exit();
    }
 
