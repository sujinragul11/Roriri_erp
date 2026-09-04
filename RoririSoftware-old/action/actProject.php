<?php
// include("C:\\xampp\\htdocs\\RORIRI_ERP\\db\\dbConnection.php");
include("../../db/dbConnection.php");
session_start();


header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Add Employee
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addProject') {
    
   
    $projectName=$_POST['pname'];
    $projectDescription=$_POST['description'];
    
    $developers = $_POST['developers']; 
    $programming = $_POST['programming'];
    $services=$_POST['service'];  
    $clientName=$_POST['clientName'];
    
    $startDate=$_POST['startDate'];
 
    $duration=$_POST['duration'];
    $charge=$_POST['charge'];
    
    $proStatus=$_POST['proStatus'];

     // Encode the arrays to JSON
     $developersJson = json_encode($developers);
     $programmingJson = json_encode($programming);
     $serviceJson=json_encode($services);

     // Combine clientName and clientAddress into an associative array
    
 
   $insQuery="INSERT INTO `project_tbl`(`project_name`,`services`, `technology`, `developers`, `client`, `start_date`,  `duration`,  `total_pay`, `description`,`project_status`) VALUES ('$projectName','$serviceJson','$programmingJson','$developersJson','$clientName','$startDate','$duration','$charge',' $projectDescription','$proStatus')";
   if ($conn->query($insQuery) === TRUE) {
    $response['success'] = true;
    $response['message'] = "Project details added successfully!";
} else {
    $response['message'] = "Unexpected error in adding Project details! " . $conn->error;
}
echo json_encode($response);
exit();
}

//Handles Updating the project
if (isset($_POST['EhdnAction']) && $_POST['EhdnAction'] == 'editProject') {
    $editPro=$_POST['editPro'];
    $eProName=$_POST['pnameE'];
    $eDescription=$_POST['descriptionE'];
    $eProgramming=$_POST['programmingE'];
    $eDevelopers=$_POST['developersE'];
    $eClient=$_POST['clientNameE'];
    $eStartDate=$_POST['startDateE'];
    $eDuration=$_POST['durationE'];
    $echarge=$_POST['chargeE'];
    $eService=$_POST['serviceE'];
    $eProStatus=$_POST['proStatusE'];

    $eProgrammingJson = json_encode($eProgramming);
    $eDevelopersJson = json_encode($eDevelopers);
    $eServiceJson=json_encode($eService);
        // Update Project details in database
        $editQuery = "UPDATE `project_tbl`
        SET 
        `project_name`='$eProName',
        `services`='$eServiceJson',
        `technology`='$eProgrammingJson',
        `developers`='$eDevelopersJson',
        `client`='$eClient',
        `start_date`='$eStartDate',
        `duration`='$eDuration',
        
        `total_pay`='$echarge',
        `description`='$eDescription',
        -- `pay_status`='',
        `project_status`='$eProStatus'
        WHERE `project_id`='$editPro'";

                
                $editRes = mysqli_query($conn, $editQuery);

            if ($editRes) {
                $_SESSION['message'] = "Project details updated successfully!";
                $response['success'] = true;
                $response['message'] = "Project details updated successfully!";
            } else {
                $response['success'] = false;
                $response['message'] = "Error updating database: " . mysqli_error($conn);
            }

            echo json_encode($response);
            exit();
}


//Handles deleting a project


if (isset($_POST['deleteId'])) {
    $id = $_POST['deleteId'];
    $queryDel = "UPDATE `project_tbl` SET status='Inactive'
    WHERE project_id='$id'";
    $reDel = mysqli_query($conn, $queryDel);

    if ($reDel) {
        $_SESSION['message'] = "Employee details have been deleted successfully!";
        $response['success'] = true;
        $response['message'] = "Employee details have been deleted successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in deleting Employee details!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}

//Handles Fetching the employee details for editing 
if (isset($_POST['editPro']) && $_POST['editPro'] != '') {
    $editPro = $_POST['editPro'];

    $projectFetch="SELECT * FROM project_tbl WHERE project_id='$editPro' AND status='Active'";
    $fetchResult = mysqli_query($conn, $projectFetch);
    
    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);
        
        $projectDetails = array(
            'pro_id' => $row['project_id'],
            'project_name' => $row['project_name'],
            'description' => $row['description'],
            'programming' => $row['technology'],
            'developers' => $row['developers'],
            'services'=>$row['services'],
            'pro_status' => $row['project_status'],
            'charge' => $row['total_pay'],
            'startDate' => $row['start_date'],
            'duration'=>$row['duration'],
            'client'=>$row['client'],
            
        


        );
        echo json_encode($projectDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}





