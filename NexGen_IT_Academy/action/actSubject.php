<?php
session_start();
include("../../db/dbConnection.php");
include("../../url.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Check if the form has been submitted
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addSubject') {
    // Retrieve form data
    $sub_name = $_POST['sub_name'];
    $sub_duration = $_POST['sub_duration'] ?? '';
    // SQL query to insert data
    $query = "INSERT INTO subject_tbl (subject_name, duration) 
              VALUES ('$sub_name','$sub_duration')";  
    $res = mysqli_query($conn, $query);
    
    // Check query result and set response message
    if ($res) {
        $_SESSION['message'] = "Subject details added successfully!";
        $response['success'] = true;
        $response['message'] = "Subject details added successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in adding Subject details!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    // Return response as JSON
    echo json_encode($response);
    exit();
}
// Handle updating Task details
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'hdnEditSubject') {
    $editid = $_POST['editId'];
    $editSub_name = $_POST['editsub_name'];
    $editSub_duration = $_POST['edit_duration'];

    $editQuery1 = " UPDATE subject_tbl SET 
        subject_tbl.duration = '$editSub_duration',
        subject_tbl.subject_name = '$editSub_name'
    WHERE id = '$editid'";
    
    $editRes = mysqli_query($conn, $editQuery1);

    $response = [];
    if ($editRes) {
        $_SESSION['message'] = "Subject details updated successfully!";
        $response['success'] = true;
        $response['message'] = "Subject details updated successfully!";
    } else {
        $response['success'] = false;
        $response['message'] = "Error: " . mysqli_error($conn);
    }
    
    echo json_encode($response);
    exit();
}

// ajax edit course
// Handle fetching Tak details for editing
if (isset($_POST['editId']) && $_POST['editId'] != '') {
    $fetchId = $_POST['editId'];
   $selQuery = "SELECT subject_tbl.*
      FROM subject_tbl
      WHERE id= $fetchId";
    $result = mysqli_query($conn, $selQuery);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        
        $subjectDetails = array(
            'sub_id'=>$row['id'],
            'edit_duration' => $row['duration'],
            'editsub_name' => $row['subject_name'],
        );
        $aa = json_encode($subjectDetails);
        echo  $aa ;
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}
// Handle deleting a Task
if (isset($_POST['deleteId'])) {
    $id = $_POST['deleteId'];
    $queryDel = "UPDATE `subject_tbl` 
    SET status = 'Inactive'
    WHERE id = $id;";
    $reDel = mysqli_query($conn, $queryDel);

    if ($reDel) {
        $_SESSION['message'] = "Subject details have been deleted successfully!";
        $response['success'] = true;
        $response['message'] = "Subject details have been deleted successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in deleting Topic details!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}
if (isset($_POST['id'])) {
$id = $_POST['id'];
$section = $_POST['section'];

// Update the section based on the provided section value
$sql = "UPDATE syllabus SET section = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $section, $id);

if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$stmt->close();


}

if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addDepartment') {
    
     $uploadDir = $meterialDir; // Directory to store files
       $fileNames = [];
    $imageNames = []; // Initialize to avoid undefined variable errors

    $maxFileSize = 100 * 1024 * 1024 * 1024; // 1000 MB in bytes
    $description = trim($_POST['description']);
    $recordId =$_POST['EditRecordId'];

    // Ensure upload directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Process each file
    if (!empty($_FILES['projectMaterial']['name'][0])) {
        foreach ($_FILES['projectMaterial']['name'] as $key => $name) {
            $tempPath = $_FILES['projectMaterial']['tmp_name'][$key];
            $fileSize = $_FILES['projectMaterial']['size'][$key];

            // Check file size
            if ($fileSize > $maxFileSize) {
                $response=['status' => 'error', 'message' => 'File size exceeds 1000 MB.'];
                exit;
            }

            // Generate unique file name and move file
            $uniqueName = uniqid() . '_' . basename($name);
            $targetPath = $uploadDir . $uniqueName;

            if (move_uploaded_file($tempPath, $targetPath)) {
                $fileNames[] = $uniqueName;
            } else {
                $response =['status' => 'error', 'message' => 'Failed to upload file: ' . $name];
                exit;
            }
        }
    }

         // Handle existing images
         // Handle existing images
    $existingImages = $_POST['existingImages'] ?? '';
    if (!empty($existingImages)) {
        $existingImagesArray = explode(',', $existingImages); // Convert to array
        $imageNames = array_merge($fileNames, $existingImagesArray);
    } else {
        $imageNames = $fileNames; // Only use newly uploaded files
    }

    // Convert final array of file names into a string
    $fileNamesStr = implode(',', $imageNames);
    
    // Save data to the database
    // $fileNamesStr = implode(',', $fileNames);
    // Replace with your database connection and query
    // Example:
   if (!empty($recordId)) {
    $query = "UPDATE topic_tbl SET topic_meterial = ?, topic_description = ? WHERE topic_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssi', $fileNamesStr, $description, $recordId);

    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'Data updated successfully.'];
    } else {
        $response =['status' => 'error', 'message' => 'Failed to update data.'];
    }

    $stmt->close();
} else {
    $response =['status' => 'error', 'message' => 'Record ID is missing.'];
}

    // Respond with success
    $response =['status' => 'success', 'message' => 'Data saved successfully.'];
    
    
    echo json_encode($response);
    exit();
}

if (isset($_GET['topic_id'])) {
    $topicId = intval($_GET['topic_id']);
    
    $query = "SELECT topic_description, topic_meterial FROM topic_tbl WHERE topic_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $topicId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'data' => $data]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No material found for the given topic ID.']);
    }
    
    $stmt->close();

    exit();
}

?>
