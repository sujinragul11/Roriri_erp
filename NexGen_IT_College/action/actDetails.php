<?php

include("../../db/dbConnection.php");
include("../../url.php"); 
include("../../assets/function/function.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Add Employee
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addDetails') {

    
    $fName=trim($_POST['fatherName']);
    $mName=trim($_POST['motherName']);
    $fOcc=trim($_POST['fatherOccupation']);
    $mOcc=trim($_POST['motherOccupation']);
    $ten=trim($_POST['tenthMark']);
    $tewlve=trim($_POST['twelfthMark']);
    $fPhone=trim($_POST['fatherPhone']);
    $mPhone=trim($_POST['motherPhone']);
    $stuId=$_POST['stuId'];

    $userId = getUserIdFromAdmin($stuId);
    

    if (!$userId) {
        $response['success'] = false;
        $response['message'] = "Error: User ID not found in admin table.";
        echo json_encode($response);
        exit();
    }

    // Directory where images are stored
    $targetDir = $stu10th;
    $targetDir12=$stu12th;
    
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
    $editImage = $currentImage;

    // Handle new image upload
    if (!empty($_FILES["tenthMarksheet"]["tmp_name"])) {
        $imageFileType = strtolower(pathinfo($_FILES["tenthMarksheet"]["name"], PATHINFO_EXTENSION));
        $newImageFilename = $userId . "." . $imageFileType;
        $targetFilePath = $targetDir . $newImageFilename;

        // Check for file size and type
        
        $maxFileSize = 5 * 1024 * 1024;

        if ($_FILES["tenthMarksheet"]["size"] > $maxFileSize) {
            $response['success'] = false;
            $response['message'] = "File is too large. Maximum size allowed is 5 MB.";
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
        // Check for file upload errors
        if ($_FILES["tenthMarksheet"]["error"] != UPLOAD_ERR_OK) {
            $response['success'] = false;
            $response['message'] = "File upload error: " . $_FILES["tenthMarksheet"]["error"];
            echo json_encode($response);
            exit();
        }

        // Move the file to the target directory
        if (move_uploaded_file($_FILES["tenthMarksheet"]["tmp_name"], $targetFilePath)) {
            // Remove the old image if it exists and is different from the new image
            if ($currentImage && $currentImage != $newImageFilename) {
                $oldFilePath = $targetDir . $currentImage;
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath); // Remove the old file if it exists
                }
            }
            $editImage = $newImageFilename; // Set new image filename
        } else {
            $response['success'] = false;
            $response['message'] = "Sorry, there was an error uploading your file.";
            echo json_encode($response);
            exit();
        }
    }

    if (!file_exists($targetDir12)) {
        if (!mkdir($targetDir12, 0777, true)) {
            $response['success'] = false;
            $response['message'] = "Failed to create directory for image upload.";
            echo json_encode($response);
            exit();
        }
    }
    
    // Get the current image filename from the database
    $currentImage12 = getCurrentImageFilename($stuId);
    $editImage12 = $currentImage12;
    
        // Handle new image upload
        if (!empty($_FILES["twelfthMarksheet"]["tmp_name"])) {
            $imageFileType12 = strtolower(pathinfo($_FILES["twelfthMarksheet"]["name"], PATHINFO_EXTENSION));
            $newImageFilename12 = $userId . "." . $imageFileType12;
            $targetFilePath12 = $targetDir12 . $newImageFilename12;

            // Check if file size exceeds the maximum allowed size (e.g., 5 MB)
            $maxFileSize = 5 * 1024 * 1024; // 5 MB in bytes
            if ($_FILES["twelfthMarksheet"]["size"] > $maxFileSize) {
                $response['success'] = false;
                $response['message'] = "File is too large. Maximum size allowed is 5 MB.";
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
            // Check for file upload errors
            if ($_FILES["twelfthMarksheet"]["error"] != UPLOAD_ERR_OK) {
                $response['success'] = false;
                $response['message'] = "File upload error: " . $_FILES["twelfthMarksheet"]["error"];
                echo json_encode($response);
                exit();
            }

            // Move the file to the target directory
            if (move_uploaded_file($_FILES["twelfthMarksheet"]["tmp_name"], $targetFilePath12)) {
                // Remove the old image if it exists and is different from the new image
                if (!empty($currentImage12) && $currentImage12 != $newImageFilename12) {
                    $oldFilePath12 = $targetDir12 . $currentImage12;
                    if (file_exists($oldFilePath12)) {
                        unlink($oldFilePath12); // Remove the old file if it exists
                    }
                }
                $editImage12 = $newImageFilename12; // Set new image filename
            } else {
                $response['success'] = false;
                $response['message'] = "Sorry, there was an error uploading your file.";
                echo json_encode($response);
                exit();
            }
        }
            $insQuery = "UPDATE `student_additional_details` SET 
                                `father_name` = '$fName',
                                `father_occupation` = '$fOcc',
                                `father_phone_number` = '$fPhone',
                                `mother_name` = '$mName',
                                `mother_occupation` = '$mOcc',
                                `mother_phone_number` = '$mPhone',
                                `12th_mark` = '$tewlve',
                                `10th_mark` = '$ten'";

            // Check if 12th Marksheet image is provided
            if (isset($editImage12)) {
                $insQuery .= ", `12th_marksheet` = '$editImage12'";
            }

            // Check if 10th Marksheet image is provided
            if (isset($editImage)) {
                $insQuery .= ", `10th_marksheet` = '$editImage'";
            }

            // Complete the query with the WHERE clause
            $insQuery .= " WHERE `basic_id` = '$stuId'";

            if ($conn->query($insQuery) === TRUE) {
                $response['success'] = true;
                $response['message'] = "Student details added successfully!";
                $response['img'] = [
                    'ten_img' => $stu10thView . $editImage,
                    'twelve_img' => $stu12thView . $editImage12,
                    
                ];
                } else {
                $response['message'] = "Unexpected error in adding Student details! " . $conn->error;
                }
                echo json_encode($response);
                exit();
}



//Handles Fetching the Clients details for editing 
if (isset($_POST['stuId']) && $_POST['stuId'] != '') {
    $editId = $_POST['stuId'];

    $Fetch="SELECT a.*,
                    b.*,
                    c.*,
                    d.*
                    FROM basic_details AS b
                    LEFT JOIN additional_details AS a ON a.basic_id=b.id
                    LEFT JOIN student_additional_details AS d ON d.basic_id=b.id
                    LEFT JOIN course_tbl AS c ON c.course_id=d.college_course
                    WHERE a.entity_id='$entity_id' AND b.id='$editId'";

    $fetchResult = mysqli_query($conn, $Fetch);
    
    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);

        $image_10 = $stu10thView . $row['10th_marksheet'];
        $image_12 = $stu12thView . $row['12th_marksheet'];
        $clientDetails = array(
            'course_id' => $row['course_id'],
            'course_name' => $row['course_name'],
            'fee' => $row['course_fee'], 
            'stuId'=>$row['id'],         
            'name'=>$row['name'],
            'father'=>$row['father_name'],
            'mother'=>$row['mother_name'],
            'fOcc'=>$row['father_occupation'],
            'mOcc'=>$row['mother_occupation'],
            'fPhone'=>$row['father_phone_number'],
            'mPhone'=>$row['mother_phone_number'],
            'ten'=>$row['10th_mark'],
            'twelve'=>$row['12th_mark'],
            'tenMark'=>$image_10,
            'twelveMark'=>$image_12,
        );
        echo json_encode($clientDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}

