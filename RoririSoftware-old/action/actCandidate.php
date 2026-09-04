<?php
// include("C:\\xampp\\htdocs\\RORIRI_ERP\\db\\dbConnection.php");
include("../../db/dbConnection.php");
include("../../url.php");  
include("../../assets/function/function.php");

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Add Employee
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addCandidate') {


     // Get form data
     $name = $_POST['name'];
     $phone = $_POST['phone'];
     $email = $_POST['email'];
     $dob = $_POST['dob'];
     $gender = $_POST['gender'];
     $join_date = $_POST['joiningDate'];
     $address = $_POST['address'];
     $course_id = $_POST['course'];
     $duration = $_POST['fullDuration'];
     $fees = $_POST['fees'];
     $username = $_POST['username'];
     $password = $_POST['password'];

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
    $insQuery = "INSERT INTO `intern_tbl`
        (`name`, `phone`, `email`, `dob`, `gender`, `join_date`, `address`, `image`, `course_id`, `duration`, `fees`, `username`, `password`) 
        VALUES 
        ('$name', '$phone', '$email', '$dob', '$gender', '$join_date', '$address', '$aname', '$course_id', '$duration', '$fees', '$username', '$password')";

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
    $id = $_POST['EditId']; // Assuming you have the employee ID to update
    $name = $_POST['nameEdit'];
    $phone = $_POST['phoneEdit'];    
    $email = $_POST['emailEdit'];
    $dob = $_POST['dobEdit'];
    $gender = $_POST['genderEdit'];
    $join_date = $_POST['joiningDateEdit'];
    $address = $_POST['addressEdit'];
    $course_id = $_POST['courseEdit'];
    $duration = $_POST['fullDuration'];
    $fees = $_POST['feesEdit'];
    
    $password = $_POST['passwordEdit'];

    // Initialize file path and existing image variable
    $aadharPath = '';
    $existingImage = ''; // Variable to store the existing image path


    // Handle Aadhar file upload if a new file is uploaded
    if (!empty($_FILES['imageEdit']['tmp_name'])) {
        $aadharFileType = strtolower(pathinfo($_FILES['imageEdit']['name'], PATHINFO_EXTENSION));
        $aname = $username . "_." . $aadharFileType;
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
    $updQuery = "UPDATE `intern_tbl` SET 
        `name` = '$name', 
        `phone` = '$phone', 
        `email` = '$email', 
        `dob` = '$dob', 
        `gender` = '$gender', 
        `join_date` = '$join_date', 
        `address` = '$address', 
        `course_id` = '$course_id', 
        `duration` = '$duration', 
        `fees` = '$fees', 
        `password` = '$password' 
        WHERE id = '$id'";

    // Check if a new image was uploaded, if so include it in the update
    if (!empty($_FILES['image']['tmp_name'])) {
        $updQuery = "UPDATE `intern_tbl` SET 
            `name` = '$name', 
            `phone` = '$phone', 
            `email` = '$email', 
            `dob` = '$dob', 
            `gender` = '$gender', 
            `join_date` = '$join_date', 
            `address` = '$address', 
            `image` = '$aadharPath', 
            `course_id` = '$course_id', 
            `duration` = '$duration', 
            `fees` = '$fees', 
            `password` = '$password' 
            WHERE id = '$id'";
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

    $clientFetch="SELECT * FROM intern_tbl WHERE id='$editId'";
    $fetchResult = mysqli_query($conn, $clientFetch);
    
    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);

        // Assume you fetched the duration from the database
    $fullDuration = $row['duration']; // Example value from the database

// Split the duration into number and unit
    list($durationNo, $durationUnit) = explode(" ", $fullDuration, 2);
        
        $clientDetails = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'phone' => $row['phone'],
            'email' => $row['email'],
            'dob' => $row['dob'],
            'gender' => $row['gender'],
            'join_date' => $row['join_date'],
            'address' => $row['address'],
            'image' => $row['image'],
            'course_id' => $row['course_id'],
            'durationNO' => $durationNo,
            'duration' => $durationUnit,
            'fees' => $row['fees'],
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
    $queryDel = "UPDATE `intern_tbl` SET status ='Inactive'
    WHERE id='$id'";
    $reDel = mysqli_query($conn, $queryDel);

    if ($reDel) {
        $_SESSION['message'] = "Condidate details have been deleted successfully!";
        $response['success'] = true;
        $response['message'] = "Condidate details have been deleted successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in deleting Employee details!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}



//Handles Fetching the Clients details for View page 
if (isset($_POST['viewIdClient']) && $_POST['viewIdClient'] != '') {
    $editId = $_POST['viewIdClient'];

    $clientFetch="SELECT * FROM intern_tbl WHERE id='$editId'";
    $fetchResult = mysqli_query($conn, $clientFetch);
    
    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);

        // Assume you fetched the duration from the database
    $fullDuration = $row['duration']; // Example value from the database

// Split the duration into number and unit
    list($durationNo, $durationUnit) = explode(" ", $fullDuration, 2);
        
        $clientDetails = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'phone' => $row['phone'],
            'email' => $row['email'],
            'dob' => $row['dob'],
            'gender' => $row['gender'],
            'join_date' => $row['join_date'],
            'address' => $row['address'],
            'image' => $row['image'],
            'course_id' => $row['course_id'],
            'durationNO' => $durationNo,
            'duration' => $durationUnit,
            'fees' => $row['fees'],
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
