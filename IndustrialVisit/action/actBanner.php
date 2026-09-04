<?php
session_start();
include("../../db/dbConnection.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $image = $_FILES['image']; 
    $name  = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');

    $uploadDir = '../../../asset/ERP/ERP_image/IVBanner/';
    $extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION)); 
    $fileName = $name . '.' . $extension;
    $targetFile = $uploadDir . $fileName;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($image['tmp_name'], $targetFile)) {
        $banQuery = "INSERT INTO `iv_banner_tbl`(
                        `name`,
                        `image_name`
                    )
                    VALUES(
                        '$name',
                        '$fileName'
                    )";
                                    
        if ($conn->query($banQuery) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Banner was added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file.']);
        exit(); 
    }
}

if (isset($_POST['bannerId']) && $_POST['bannerId'] != '') {
    $id = $_POST['bannerId'];
    $name = htmlspecialchars($_POST['nameEdit'], ENT_QUOTES, 'UTF-8');

    $uploadDir = '../../../asset/ERP/ERP_image/IVBanner/';
    $imageUploaded = isset($_FILES['imageEdit']) && $_FILES['imageEdit']['error'] === UPLOAD_ERR_OK;

    // If an image is uploaded, process the upload
    if ($imageUploaded) {
        $image = $_FILES['imageEdit'];
        $extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        $fileName = $name . '.' . $extension;
        $targetFile = $uploadDir . $fileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            $updateQuery = "UPDATE `iv_banner_tbl` SET `name` = '$name', `image_name` = '$fileName' WHERE `banner_id` = '$id'";
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file.']);
            exit();
        }
    } else {
        // No image uploaded; update only name
        $updateQuery = "UPDATE `iv_banner_tbl` SET `name` = '$name' WHERE `banner_id` = '$id'";
    }

    // Execute the query
    if ($conn->query($updateQuery) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Banner was updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    }
}

if (isset($_POST['delId']) && $_POST['delId'] != '') {
    
    $bannerId = $_POST['delId'];

    $deleteQuery = "UPDATE
                        `iv_banner_tbl`
                    SET
                        `status` = 'Inactive'
                    WHERE
                        `banner_id` = '$bannerId'";

  if ($conn->query($deleteQuery) === TRUE) {
    $response['success'] = true;
    $response['message'] = "Banner details Deleted successfully!";
    } else {
    $response['message'] = "Unexpected error in deleting Banner details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

?>