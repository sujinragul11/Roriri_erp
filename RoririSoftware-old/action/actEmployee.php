<?php
// include("C:\\xampp\\htdocs\\RORIRI_ERP\\db\\dbConnection.php");
include("../../db/dbConnection.php");
session_start();
// include('../../phpqrcode/qrlib.php'); // Include the QR code library
include('../../qr/phpqrcode-master/qrlib.php');
include("../../url.php");  
include("../../assets/function/function.php");

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];


// Add Employee
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addEmployee') {
    $name = $_POST['fname'];
    $mobile = $_POST['phone'];
    $pemail = $_POST['pemail'];
    $cemail = strtolower($_POST['cemail']);
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $jDate = $_POST['jDate'];
    $blood = $_POST['blood'];
    $role = $_POST['role'];
    $married_status = $_POST['ms'];
    $gender = $_POST['gender'];
    $username = strtolower($name);
    $username = preg_replace('/\s+/', '', $username); // Removes all spaces

    $username_gen = generateUniqueUsername($username, $dob);
    $password = $dob; // Assuming this function generates a password
    $next_employee_id = generateNextEmployeeId();
    $empuser_sql = "INSERT INTO `basic_details`(`name`, `dob`, `email`, `phone`,`blood_group`, `username`, `password`, `address`, `gender`) VALUES ('$name','$dob','$pemail','$mobile','$blood','$username_gen','$password','$address','$gender')";

    if ($conn->query($empuser_sql) === TRUE) {
        $last_insert_id = $conn->insert_id;
        $getRole = position($role);

        // Generate the URL for the QR code
        $url = "http://erp.inforiya.in/RoririSoftware/employeeDetails.php?id=$last_insert_id";

        // Generate the QR code
        $qr_filename = generateQRCode($url, $username_gen, $qr_img);

        if ($qr_filename !== false) {
            $emp_sql = "INSERT INTO `additional_details`(`basic_id`, `entity_id`, `role`, `qr`, `joining_date`, `reg_no`) VALUES ('$last_insert_id', 1, '$role', '$qr_filename', '$jDate', '$next_employee_id')";

            if ($conn->query($emp_sql) === TRUE) {
                $last_parent_id = $conn->insert_id;

                $emp_add_sql = "INSERT INTO `emp_additional_details`(`basic_id`, `marrital_status`, `company_email`) VALUES ('$last_insert_id', '$married_status', '$cemail')";

                if ($conn->query($emp_add_sql) === TRUE) {
                    $response['success'] = true;
                    $response['message'] = "Employee details added successfully!";
                } else {
                    $response['message'] = "Unexpected error in adding Employee details! " . $conn->error;
                }
            } else {
                $response['message'] = "Error: " . $conn->error;
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Error generating QR code.";
        }
    } else {
        $response['message'] = "Error: " . $conn->error;
    }

    echo json_encode($response);
    exit();
}



// Handles the update of the employee
// Handles the update of the employee
if($_SESSION['is_admin']=='True'){


    if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'hdneditEmployee') {
        $empId = $_POST['empId'];
        $Ename = $_POST['editFname'];
        $editGender = $_POST['editGender'];
        $editdob = $_POST['editDob'];
        $editRole = $_POST['editRole'];
        $editMobile = $_POST['editPhone'];
        $editCemail = $_POST['editCemail'];
        $editEmail = $_POST['editPemail'];
        $editJDate = $_POST['editjDate'];
        
        $editAddress = $_POST['editAddress'];
        $editMs = $_POST['editms'];
       
        
    
        // Fetch the user ID from the admin table
        $userId = getUserIdFromAdmin($empId);
    
        if (!$userId) {
            $response['success'] = false;
            $response['message'] = "Error: User ID not found in admin table.";
            echo json_encode($response);
            exit();
        }
    
        // Directory where images are stored
        $targetDir = $image;
    
        // Ensure the directory exists; create if not
        if (!file_exists($targetDir)) {
            if (!mkdir($targetDir, 0777, true)) {
                $response['success'] = false;
                $response['message'] = "Failed to create directory for image upload.";
                echo json_encode($response);
                exit();
            }
        }
    
        // Get the current image filename from the database
        $currentImage = getCurrentImageFilename($empId);
        
        // Initialize variable to store the new image filename
        $editImage = $currentImage;
    
        // Handle new image upload
        if (!empty($_FILES["editImage"]["tmp_name"])) {
            $imageFileType = strtolower(pathinfo($_FILES["editImage"]["name"], PATHINFO_EXTENSION));
            $newImageFilename = $userId . "." . $imageFileType;
            $targetFilePath = $targetDir . $newImageFilename;
    
            // Check if image file is an actual image or fake image
            $check = getimagesize($_FILES["editImage"]["tmp_name"]);
            if ($check === false) {
                $response['success'] = false;
                $response['message'] = "Error: File is not an image.";
                echo json_encode($response);
                exit();
            }
    
            // Check file size (optional, here 10MB max)
            if ($_FILES["editImage"]["size"] > 10000000) {
                $response['success'] = false;
                $response['message'] = "Error: File is too large.";
                echo json_encode($response);
                exit();
            }
    
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $response['success'] = false;
                $response['message'] = "Error: Only JPG, JPEG, PNG files are allowed.";
                echo json_encode($response);
                exit();
            }
    
            // Move the file to the target directory
            if (move_uploaded_file($_FILES["editImage"]["tmp_name"], $targetFilePath)) {
                // Remove the old image if it exists and is different from the new image
                if ($currentImage && $currentImage != $newImageFilename) {
                    unlink($targetDir . $currentImage); // Remove the old file
                }
                $editImage = $newImageFilename; // Set new image filename
            } else {
                $response['success'] = false;
                $response['message'] = "Sorry, there was an error uploading your file.";
                echo json_encode($response);
                exit();
            }
        }

       
    
        // Update employee details in database
        $editQuery = "UPDATE `basic_details` a
                      LEFT JOIN `additional_details` b ON a.`id` = b.`basic_id`
                      LEFT JOIN `emp_additional_details` c on a.`id`=c.basic_id
                      SET a.`name` = '$Ename',
                          a.dob = '$editdob',
                          a.email = '$editEmail',
                          a.gender = '$editGender',
                          a.phone = '$editMobile',
                          a.address = '$editAddress',
                          b.role = '$editRole',
                          b.joining_date = '$editJDate',
                          c.marrital_status = '$editMs',
                          c.company_email = '$editCemail'
                          
                         ";
                          
        if (isset($editImage)) {
            $editQuery .= ", b.image = '$editImage'";
        }
    
        $editQuery .= " WHERE a.id = '$empId'";
    
        $editRes = mysqli_query($conn, $editQuery);
    
        if ($editRes) {
            $_SESSION['message'] = "Employee details updated successfully!";
            $response['success'] = true;
            $response['message'] = "Employee details updated successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "Error updating database: " . mysqli_error($conn);
        }
    
        echo json_encode($response);
        exit();
    }
    }
    else{
        if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'hdneditEmployee') {
            $proId=$_POST['profileId'];
            $pass=$_POST['editPassword'];
    
            $editQuery="UPDATE `basic_details` SET `password`='$pass' WHERE `id`='$proId'";
            
            $editRes = mysqli_query($conn, $editQuery);
            if ($editRes) {
              $_SESSION['message'] = "Password  updated successfully!";
              $response['success'] = true;
              $response['message'] = "Password  updated successfully!";
              $response['newPassword'] = $pass; // Add this line
          } else {
              $response['success'] = false;
              $response['message'] = "Error updating database: " . mysqli_error($conn);
          }
        
          echo json_encode($response);
          exit();
          }
    }
//Handles Fetching the employee details for editing 
if (isset($_POST['empId']) && $_POST['empId'] != '') {
    $empId = $_POST['empId'];

    $empFetch="SELECT additional_details.*, basic_details.*,emp_additional_details.*,roles.*
FROM basic_details
LEFT JOIN additional_details ON additional_details.basic_id=basic_details.id
LEFT JOIN emp_additional_details ON emp_additional_details.basic_id=basic_details.id 
LEFT JOIN roles ON roles.role_id=additional_details.role
WHERE basic_details.id='$empId'";
    $fetchResult = mysqli_query($conn, $empFetch);
    
    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);
         // Construct the image URL
        $image_url = $imageView . $row['image'];
        $employeeDetails = array(
            'emp_id' => $row['id'],
            'first_name' => $row['name'],
            'dob' => $row['dob'],
            'address' => $row['address'],
            'personal_email' => $row['email'],
            'company_email' => $row['company_email'],
            'phone' => $row['phone'],
            'role'=>$row['role'],
            'married_status'=>$row['marrital_status'],
            'gender'=>$row['gender'],
            'joining_date'=>$row['joining_date'],
            'username'=>$row['username'],
            'password'=>$row['password'],
            'img'=>$image_url,


        );
        echo json_encode($employeeDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}





// Handle deleting a Employee
if (isset($_POST['deleteId'])) {
    $id = $_POST['deleteId'];
    $queryDel = "UPDATE basic_details a
LEFT JOIN additional_details b ON b.basic_id = a.id
SET a.status = 'Inactive', b.add_status = 'Inactive'
WHERE a.id = '$id'";
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
// Add Salary
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addSalary') {

    $sID=$_POST['salaryId'];
    $salary=$_POST['salary'];
    $date=$_POST['date'];
    $days=$_POST['days'];
    
    $insQuery="INSERT INTO `salary_tbl`( `basic_id`, `salary`,`days`, `month`) VALUES ('$sID','$salary','$days','$date')";

   if ($conn->query($insQuery) === TRUE) {
    $response['success'] = true;
    $response['message'] = "Salary details added successfully!";
    } else {
    $response['message'] = "Unexpected error in adding Salary details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}
//Fetch the salary Details
if (isset($_POST['salaryId']) && $_POST['salaryId'] != '') {
    $empIdS = $_POST['salaryId'];
    

    $empFetchS="SELECT * FROM emp_additional_details WHERE basic_id='$empIdS'";
    $fetchResultS = mysqli_query($conn, $empFetchS);
    
    if ($fetchResultS) {

        $row1 = mysqli_fetch_assoc($fetchResultS);
       
        $employeeSalary = array(
            'salaryid' => $row1['basic_id'],
            'payroll'=>$row1['payroll'],
            'exper'=>$row1['experience'],
            'accNo'=>$row1['account_no'],
            'ifsc'=>$row1['ifsc'],
            'branch'=>$row1['branch'],
        );
        echo json_encode($employeeSalary);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}
function generateQRCode($url, $username, $target_dir) {
    $qr_filename = $username . 'qr.png';
    $qr_file_path = $target_dir . $qr_filename;

    try {
        // Ensure the target directory exists
        if (!file_exists($target_dir)) {
            if (!mkdir($target_dir, 0777, true)) {
                throw new Exception("Failed to create directory: $target_dir");
            }
        }

        // Generate and save the QR code
        QRcode::png($url, $qr_file_path);

        // Check if the file exists and is writable
        if (file_exists($qr_file_path)) {
            return $qr_filename;
        } else {
            throw new Exception("Failed to save the QR code image. File not created.");
        }
    } catch (Exception $e) {
        error_log($e->getMessage()); // Log the error
        return false;
    }
}
function url_exists($url) {
    // Suppress warnings and handle errors
    $headers = @get_headers($url);
    
    // Check if headers are retrieved and valid
    if ($headers && strpos($headers[0], "200") !== false) {
        return true;
    } else {
        return false;
    }
}


if (isset($_POST['status']) && $_POST['status'] != '') {

    $status = $_POST['status'];

// Prepare SQL query based on the selected status
$sql = "SELECT a.*, b.*, c.*, b.status as emp_status 
        FROM basic_details AS b 
        LEFT JOIN additional_details AS a ON a.basic_id = b.id 
        LEFT JOIN emp_additional_details AS c ON c.basic_id = b.id 
        WHERE a.entity_id = 1 AND b.status = ?";
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

?>
