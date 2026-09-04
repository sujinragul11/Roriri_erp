<?php
session_start();
header('Content-Type: application/json');
include("../../db/dbConnection.php");
include('../../qr/phpqrcode-master/qrlib.php'); 
include("../../url.php"); 
include("../../assets/function/function.php");

$response = ['success' => false, 'message' => ''];

    if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addStudent') {


        $name = trim($_POST['name']);
        $gender = trim($_POST['gender']);
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $address = trim($_POST['address']);
        $aadhar = trim($_POST['aadhar']);
        $course =trim($_POST['course']);
        $blood = trim($_POST['blood_group']);
       
        $dob = $_POST['dob']; 
        $courseFee=trim($_POST['actual_fee']);
        $username = strtolower($name);
        $username = preg_replace('/\s+/', '', $username); // Removes all spaces
        
        $student_id = generateNextStudentId();

        // Generate unique username and random password
        $username_crt = generateUniqueUsername($username, $dob);
        $password = $dob; // Assuming this function generates a password
        
        $empuser_sql = "INSERT INTO `basic_details`(`name`, `dob`, `email`, `phone`, `blood_group`, `username`, `password`, `address`, `gender`) VALUES ('$name','$dob','$email','$phone','$blood','$username_crt','$password','$address','$gender')";
    
        if ($conn->query($empuser_sql) === TRUE) {
            $last_insert_id = $conn->insert_id;

            // Generate QR code
            $target_dir = $stuQR; // Absolute path to the target directory
        
            // Ensure the target directory exists
            if (!file_exists($target_dir)) {
                if (!mkdir($target_dir, 0777, true)) {
                    $response['success'] = false;
                    $response['message'] = "Failed to create directory: $target_dir";
                    error_log($response['message']); // Log the error
                    echo json_encode($response);
                    exit();
                }
            }
   

            // $getRole = position($role);
            $url = "http://erp.inforiya.in/NexGen_IT_College/studentDetail.php?id=$last_insert_id";
            
            $qr_filename = $username . 'qr.png';
            $qr_file_path = $target_dir . $qr_filename;
            $qr_generated = false;
        
            try {
                if (function_exists('imagecreatetruecolor')) {
                    QRcode::png($url, $qr_file_path);
                    $qr_generated = file_exists($qr_file_path);
                }
            } catch (Exception $e) {
                error_log("QR code generation error: " . $e->getMessage());
            }
        
            $stud_sql = "INSERT INTO `additional_details`(`basic_id`, `entity_id`, `role`, `qr`,  `reg_no`) VALUES ('$last_insert_id', $entity_id, '$roleStudent', '" . ($qr_generated ? $qr_filename : '') . "', '$student_id')";
        
            if ($conn->query($stud_sql) === TRUE) {

                $addStu="INSERT INTO `student_additional_details`(`basic_id`, `college_course`, `course_fee`, `aadhar_no`) VALUES ('$last_insert_id','$course','$courseFee','$aadhar')";

                if($conn->query($addStu)===True){

                    $response['success'] = true;
                    $response['message'] = "Student details added successfully!";
                }
                else{
                    $response['message'] = "Unexpected error in adding Student details! " . $conn->error;
                }
                
            } else {
                $response['message'] = "Unexpected error in adding Student details! " . $conn->error;
            }
        } else {
            $response['message'] = "Error: " . $conn->error;
        }
        
        echo json_encode($response);
        exit();
    }


// Handles the update of the employee
if($_SESSION['is_admin']=='True'){


    if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'editStudent') {
        $stuId = $_POST['studid'];
        $Ename = $_POST['editFname'];
        $editGender = $_POST['editGender'];
        $editdob = $_POST['editDob'];
        $editAadhar = $_POST['editAadhar'];
        $editMobile = $_POST['editPhone'];
        $editCourse = $_POST['editCourse'];
        $editEmail = $_POST['editemail'];
        $editAddress = $_POST['editAddress'];
        $editFee = $_POST['editFee'];
        $editBlood=$_POST['editBlood'];
        
    
        // Fetch the user ID from the admin table
        $userId = getUserIdFromAdmin($stuId);
    
        if (!$userId) {
            $response['success'] = false;
            $response['message'] = "Error: User ID not found in admin table.";
            echo json_encode($response);
            exit();
        }
    
        // Directory where images are stored
        $targetDir = $stuImage;
    
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
        $currentImage = getCurrentImageFilename($stuId);
        
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
                      LEFT JOIN `student_additional_details` c on a.`id`=c.basic_id
                      SET a.`name` = '$Ename',
                          a.dob = '$editdob',
                          a.email = '$editEmail',
                          a.gender = '$editGender',
                          a.phone = '$editMobile',
                          a.address = '$editAddress',
                          c.aadhar_no = '$editAadhar',
                          c.course_fee = '$editFee',
                          c.college_course='$editCourse',
                    
                          a.blood_group='$editBlood'";
                          
        if (isset($editImage)) {
            $editQuery .= ", b.image = '$editImage'";
        }
    
        $editQuery .= " WHERE a.id = '$stuId'";
    
        $editRes = mysqli_query($conn, $editQuery);
    
        if ($editRes) {
            $_SESSION['message'] = "Students details updated successfully!";
            $response['success'] = true;
            $response['message'] = "Students details updated successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "Error updating database: " . mysqli_error($conn);
        }
    
        echo json_encode($response);
        exit();
    }
     }  
     else{
        if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'editStudent') {
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

// Function to fetch student details by ID (Assuming this is the correct place for it)
if (isset($_POST['studid']) && $_POST['studid'] != '') {
    
    $studid = $_POST['studid'];

    $empFetch="SELECT a.*, b.*,c.*,d.*
                FROM basic_details AS b
                LEFT JOIN additional_details AS a ON a.basic_id=b.id
                LEFT JOIN roles AS c ON c.role_id=a.role
                LEFT JOIN student_additional_details AS d ON d.basic_id=b.id
                WHERE b.id='$studid'";
    $fetchResult = mysqli_query($conn, $empFetch);
    
    if ($fetchResult) {
        $row = mysqli_fetch_assoc($fetchResult);
        
        
        
        $image_url = $stuView . $row['image'];
        
        $studentDetails = array(
            'studid' => $row['id'],
            'firstname' => $row['name'],
            'dob' => $row['dob'],
            'address' => $row['address'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'aadhar' => $row['aadhar_no'],
            'gender' => $row['gender'],
            'course' => $row['college_course'],
            'course_fee'=>$row['course_fee'],
            'blood'=>$row['blood_group'],
            'duration'=>$row['duration'],
            'username' => $row['username'],
            'password' => $row['password'],
            'img' => $image_url,

        );        
    
        echo json_encode($studentDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
}


//Deleting student

if (isset($_POST['deleteId'])) {
    $id = $_POST['deleteId'];
    $queryDel = "UPDATE basic_details a
LEFT JOIN additional_details as b ON b.basic_id=a.id
SET a.status='Inactive', b.add_status='Inactive'
WHERE a.id='$id' AND b.basic_id='$id'";
    $reDel = mysqli_query($conn, $queryDel);

    if ($reDel) {
        $_SESSION['message'] = "Student details have been deleted successfully!";
        $response['success'] = true;
        $response['message'] = "Student details have been deleted successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in deleting Student details!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}
?>