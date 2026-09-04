<?php
include("../../db/dbConnection.php");
 session_start();
include('../../qr/phpqrcode-master/qrlib.php'); // Include the QR code library
include("../../url.php");  
include("../../assets/function/function.php");

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Add Trainee
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addTrainee') {

    $response = [];
    $imagePath = null; // Initialize imagePath as null
    $uploadOk = 1;

    if (!empty($_FILES["image"]["name"])) {
        // File upload handling
        $targetDir =$traineeImage;
        $filename = $_FILES["image"]["name"];
        $target_file = $targetDir . basename($filename);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($target_file)) {
            $response['message'] = "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            $response['message'] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        $allowed_extensions = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowed_extensions)) {
            $response['message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Attempt to move the uploaded file to the target directory
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $imagePath = $filename; // Store the image path or filename for database insertion
            } else {
                $response['message'] = "Sorry, there was an error uploading your file.";
                echo json_encode($response);
                exit();
            }
        }
    }

    // Retrieve form data
    $name = $_POST['name'];
    $dob =$_POST['dob'];
    $pemail = $_POST['pemail'];
    $phone = $_POST['phone'];
    $address=$_POST['address'];
    $gender = $_POST['gender'];
    $blood = $_POST['blood'];
    $course=$_POST['course_name'];
    $duration=$_POST['duration'];
    $fee=$_POST['actual_fee'];
    $jod=$_POST['jDate'];
    $username=$_POST['username'];
    $slot=$_POST['slot'];
    $batch=$_POST['batch'];
    
   $employee = $_POST['employee'] ?? [];
 $employeeStr = implode(',', $employee);
    // Use DOB as password
    $password = $dob;
    $next_trainee_id = generateNextTraineeId();

    // SQL query to insert data
    $trainee_sql = "INSERT INTO basic_details (name, dob, email, phone, gender, address, username, password , blood_group) 
                    VALUES ('$name', '$dob', '$pemail', '$phone', '$gender', '$address', '$username', '$password' , '$blood')";  


if ($conn->query($trainee_sql) === TRUE) {
    $last_insert_id = $conn->insert_id;
    $target_dir = $qr_imgTrainee;

    // Ensure the target directory exists
    if (!file_exists($target_dir)) {
        if (!mkdir($target_dir, 0777, true)) {
            $response['success'] = false;
            $response['message'] = "Failed to create directory: $target_dir";
            error_log($response['message']);
            echo json_encode($response);
            exit();
        }
    }

    $url = "https://erp.inforiya.in/NexGen_IT_Academy/traineeDetails.php?id=$last_insert_id";
    $qr_filename = $username . 'qr.png';
    $qr_file_path = $target_dir . $qr_filename;

    try {
        QRcode::png($url, $qr_file_path);

        if (file_exists($qr_file_path)) {
            $trainee_qr = $qr_file_path;
            $imagePathValue = $imagePath ? "'$imagePath'" : "''";

            $additional_sql = "INSERT INTO additional_details (basic_id, entity_id, role, image, qr, reg_no, joining_date) 
                               VALUES ('$last_insert_id', 3, $roletrainee, $imagePathValue, '$qr_filename', '$next_trainee_id','$jod')";

            if ($conn->query($additional_sql) === TRUE) {
                $course_sql = "INSERT INTO trainee_additional_details (basic_id, course_id, duration, slot_timing, batch, course_fee ,incharge_name) 
                               VALUES ('$last_insert_id', '$course', '$duration', '$slot', '$batch', '$fee' ,'$employeeStr')";

                if ($conn->query($course_sql) === TRUE) {
                    $response['success'] = true;
                    $response['message'] = "Trainee and course details added successfully!";
                } else {
                    $response['success'] = false;
                    $response['message'] = "Error adding course details: " . $conn->error;
                    error_log("Course SQL: " . $course_sql);
                }
            } else {
                $response['success'] = false;
                $response['message'] = "Unexpected error in adding trainee details to additional_details table! " . $conn->error;
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Failed to save the QR code image. File not created.";
            error_log($response['message']);
        }
    } catch (Exception $e) {
        $response['success'] = false;
        $response['message'] = "Error generating QR code: " . $e->getMessage();
        error_log($response['message']);
    }
} else {
    $response['success'] = false;
    $response['message'] = "Error adding trainee: " . $conn->error;
}

echo json_encode($response);
exit();
}


// edit trainee data
if($_SESSION['is_admin']=='True'){

 if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'editTrainee') {
    $traineeId = $_POST['traineeId'];
    $Ename = $_POST['editName'];
    $editGender = $_POST['editGender'];
    $editdob = $_POST['editDob'];
    $editMobile = $_POST['editPhone'];
    $editEmail = $_POST['editPemail'];
    $editAddress = $_POST['editAddress'];
    $editBlood = $_POST['editBlood'];
    $editFee = $_POST['editFee'];
    $editDuration = $_POST['editDuration'];
    $editCourse = $_POST['editCourse'];
    $editJod = $_POST['editJod'];
    $editSlot = $_POST['editSlot'];
    $editBatch = $_POST['editBatch'];
    $cemail = $_POST['cemail'];
    // $password = $_POST['editPassword'];
$employeeEdit = $_POST['employeeEdit'] ?? [];
 $employeeStrEdit = implode(',', $employeeEdit);
    // Fetch the user ID from the admin table
    $userId = getUserIdFromAdmin($traineeId);

    if (!$userId) {
        $response['success'] = false;
        $response['message'] = "Error: User ID not found in admin table.";
        echo json_encode($response);
        exit();
    }

    // Directory where images are stored
    $targetDir = $traineeImage;

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
    $currentImage = getCurrentImageFilenameTrainee($traineeId);
    
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

    // Update Trainee details in database
    $editQuery = "UPDATE basic_details a
    LEFT JOIN additional_details b ON a.id = b.basic_id
    LEFT JOIN trainee_additional_details c ON c.basic_id = a.id
    SET a.name = '$Ename',
        a.dob = '$editdob',
        a.email = '$editEmail',
        a.gender = '$editGender',
       
        a.phone = '$editMobile',
        a.address = '$editAddress',
        a.blood_group = '$editBlood',
        b.joining_date = '$editJod',
        b.company_email = '$cemail',
        c.course_fee = '$editFee',
        c.course_id = '$editCourse',
        c.slot_timing = '$editSlot',
        c.batch = '$editBatch',
        c.incharge_name = '$employeeStrEdit',
        c.duration = '$editDuration'";

    // Check if the discount column exists before using it
   

    if (isset($editImage)) {
        $editQuery .= ", b.`image` = '$editImage'";
    }

    $editQuery .= " WHERE a.`id` = '$traineeId'";

    // For debugging purposes, log the query
    error_log("SQL Query: " . $editQuery);

    $editRes = mysqli_query($conn, $editQuery);

    if ($editRes) {
        $_SESSION['message'] = "Trainee details updated successfully!";
        $response['success'] = true;
        $response['message'] = "Trainee details updated successfully!";
    } else {
        $response['success'] = false;
        $response['message'] = "Error updating database: " . mysqli_error($conn);
    }
    echo json_encode($response);
    exit();
}
}


if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'editPassword')  {
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

  if (isset($_POST['studid']))  {
    $proId=$_POST['studid'];
    

    $editQuery="SELECT id,password FROM basic_details WHERE id= $proId";

    $fetchResult = mysqli_query($conn, $editQuery);
    if ($fetchResult) {
        $row = mysqli_fetch_assoc($fetchResult);

        $editData =array(
            "id" =>$row['id'],
            "password" =>$row['password']

        );

        echo json_encode($editData);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
  exit();
  }



//Handles Fetching the Trainee details for editing 
if (isset($_POST['traineeId']) && $_POST['traineeId'] != '') {
    $traineeId = $_POST['traineeId'];

    $traineeFetch = "SELECT additional_details.*, trainee_additional_details.*, basic_details.* FROM basic_details LEFT JOIN trainee_additional_details ON trainee_additional_details.basic_id = basic_details.id LEFT JOIN additional_details ON additional_details.basic_id = basic_details.id WHERE basic_details.id =$traineeId ;
";
    $fetchResult = mysqli_query($conn, $traineeFetch);
    
    if ($fetchResult) {
        $row = mysqli_fetch_assoc($fetchResult);
        // Construct the image URL
        $inchargeData = $row['incharge_name']; // This is the stored data (e.g., "2,8,5")
        $selectedEmployees = explode(',', $inchargeData); // Convert to array: ['2', '8', '5']

        $image_url = !empty($row['image']) ? $traineeImageView . $row['image'] : $default_image;
        $traineeDetails = array(
            'trainee_id' => $row['id'],
            'name' => $row['name'],
            'dob' => $row['dob'],
            'address' => $row['address'],
            'personal_email' => $row['email'],
            'phone' => $row['phone'],
            'gender' => $row['gender'],
            'joining_date' => $row['joining_date'],
            'blood_group' => $row['blood_group'],
            'course' => $row['course_id'], 
            'duration' => $row['duration'], 
            'slot' => $row['slot_timing'],
            'batch' => $row['batch'],
            'fee' => $row['course_fee'],
            'jod'=>$row['joining_date'],
            'username'=>$row['username'],
            'password'=>$row['password'],
            'cmail'=>$row['company_email'],
            'inchargeName'=>$selectedEmployees,
            'img' => $image_url
        );
        echo json_encode($traineeDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}

// Handle deleting a Trainee
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] === 'deleteTrainee' && isset($_POST['trainee_id'])) {
    $traineeId = $_POST['trainee_id'];
    // Delete query
    $queryDel = "UPDATE basic_details a
    LEFT JOIN additional_details as b ON b.basic_id = a.id
    SET a.status = 'Inactive', b.add_status = 'Inactive'
    WHERE a.id = '$traineeId'";

    if (mysqli_query($conn, $queryDel)) {
        $response = array(
            'success' => true,
            'message' => 'Trainee deleted successfully!'
        );
    } else {
        $response = array(
            'success' => false,
            'message' => 'Error deleting trainee: ' . mysqli_error($conn)
        );
    }

    // Ensure no additional output
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

if (isset($_POST['docStu']) && $_POST['docStu'] != '') {
    $stuId = $_POST['docStu'];
    

    $stuFetch="SELECT * FROM `additional_details` WHERE basic_id='$stuId'";
    $fetchResultS = mysqli_query($conn, $stuFetch);
    
    if ($fetchResultS) {

        $row1 = mysqli_fetch_assoc($fetchResultS);
            $aadhar_path = !empty($row1['aadhar']) ? $aadharView . $row1['aadhar'] : $default_image;
            $bank_path = !empty($row1['bank']) ? $bankView . $row1['bank'] : $default_image;
            $pan_path = !empty($row1['pan']) ? $panView . $row1['pan'] : $default_image;
        $employeeSalary = array(
            'stuId' => $row1['basic_id'],
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

// Add Documents
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addDocument') {
    $stuId = $_POST['stuId'];

    // Fetch the user ID from the admin table
    $userId = getUserIdFromAdmin($stuId);
    if (!$userId) {
        $response['success'] = false;
        $response['message'] = "Error: User ID not found in admin table.";
        echo json_encode($response);
        exit();
    }

    // Initialize file paths
    $aadharPath = $panPath = $bankPath = '';
    $aname = $pname = $bname = '';

    // Handle Aadhar file upload
    if (!empty($_FILES['aadhar']['tmp_name'])) {
        $aadharFileType = strtolower(pathinfo($_FILES['aadhar']['name'], PATHINFO_EXTENSION));
        $aname = $userId . "_aadhar." . $aadharFileType;
        $aadharPath = $aadharDir . $aname;

        if (move_uploaded_file($_FILES['aadhar']['tmp_name'], $aadharPath)) {
            // $response['message'] = "Aadhar uploaded successfully!";
        } else {
            $response['message'] = "Failed to upload Aadhar. Path: $aadharPath";
        }
    }

    // Handle Bank Passbook file upload
    if (!empty($_FILES['bank']['tmp_name'])) {
        $bankFileType = strtolower(pathinfo($_FILES['bank']['name'], PATHINFO_EXTENSION));
        $bname = $userId . "_bank." . $bankFileType;
        $bankPath = $bankDir . $bname;

        if (move_uploaded_file($_FILES['bank']['tmp_name'], $bankPath)) {
            // $response['message'] .= " Bank Passbook uploaded successfully!";
        } else {
            $response['message'] .= " Failed to upload Bank Passbook. Path: $bankPath";
        }
    }

    // Handle PAN file upload
    if (!empty($_FILES['pan']['tmp_name'])) {
        $panFileType = strtolower(pathinfo($_FILES['pan']['name'], PATHINFO_EXTENSION));
        $pname = $userId . "_pan." . $panFileType;
        $panPath = $panDir . $pname;

        if (move_uploaded_file($_FILES['pan']['tmp_name'], $panPath)) {
            // $response['message'] .= " PAN uploaded successfully!";
        } else {
            $response['message'] .= " Failed to upload PAN. Path: $panPath";
        }
    }

    // Build the SQL query based on what was uploaded
    $updateFields = [];
    if (!empty($aname)) {
        $updateFields[] = "`aadhar`='$aname'";
    }
    if (!empty($bname)) {
        $updateFields[] = "`bank`='$bname'";
    }
    if (!empty($pname)) {
        $updateFields[] = "`pan`='$pname'";
    }

    // Only update the database if there are fields to update
    if (!empty($updateFields)) {
        $editQuery = "UPDATE `additional_details` SET " . implode(', ', $updateFields) . " WHERE `basic_id`='$stuId'";
        $editRes = mysqli_query($conn, $editQuery);

        if ($editRes) {
            $_SESSION['message'] = "Students documents updated successfully!";
            $response['success'] = true;
            $response['message'] .= " Students documents updated successfully!";
            $response['data'] = [
                'dir' => $aadharDir.$aname,
                'aadhar_path' => !empty($aname) ? $aadharView . $aname : $default_image,
                'bank_path' => !empty($bname) ? $bankView . $bname : $default_image,
                'pan_path' => !empty($pname) ? $panView . $pname : $default_image
            ];
        } else {
            $response['success'] = false;
            $response['message'] .= " Error updating database: " . mysqli_error($conn);
        }
    } else {
        $response['success'] = true;
        $response['message'] = "No new documents were uploaded.";
    }

    echo json_encode($response);
    exit();
}

        if (isset($_GET['report_start_date']) || isset($_GET['end_date']) || isset($_GET['duration']) || isset($_GET['course']) || isset($_GET['slot'])) {
            $start_date = isset($_GET['report_start_date']) ? $_GET['report_start_date'] : '';
            $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
            $duration = isset($_GET['duration']) ? $_GET['duration'] : '';
            $slot = isset($_GET['slot']) ? $_GET['slot'] : '';
            $course = isset($_GET['course']) ? $_GET['course'] : '';

            // Build the base SQL query
            $filterquery = "SELECT
                                a.id,
                                a.name,
                                a.email,
                                a.phone,
                                b.reg_no
                            FROM
                                basic_details AS a
                            LEFT JOIN 
                                additional_details AS b
                            ON
                                b.basic_id = a.id
                            LEFT JOIN 
                                trainee_additional_details AS c
                            ON
                                c.basic_id = a.id
                            WHERE
                                b.entity_id = 3 AND a.status = 'Active'"; 
        
            if (!empty($start_date)) {
                $filterquery .= " AND b.`joining_date` >= '$start_date'";
            }
            if (!empty($end_date)) {
                $filterquery .= " AND b.`joining_date` <= '$end_date'";
            }
            if (!empty($duration)) {
                $filterquery .= " AND c.`duration` = '$duration'";
            }
            if (!empty($slot)) {
                $filterquery .= " AND c.`slot_timing` = '$slot'";
            }
            if (!empty($course)) {
                $filterquery .= " AND c.`course_id` = '$course'";
            }
            $filterquery .= " ORDER BY b.`joining_date` DESC";
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