
<?php
session_start();
include("../../db/dbConnection.php");
include("../../url.php");  
include("../../assets/function/function.php");
header('Content-Type: application/json');


$response = ['success' => false, 'message' => ''];

if (isset($_POST['course_name']) && $_POST['course_name'] != '') {
    
    // Get form data
    $course_name = $_POST['course_name'];
   

    // Initialize file paths
    $aadharPath =  '';
    $aname =  '';

    // Handle Aadhar file upload
    if (!empty($_FILES['course_logo']['tmp_name'])) {
        $aadharFileType = strtolower(pathinfo($_FILES['course_logo']['name'], PATHINFO_EXTENSION));
        $aname = $course_name . "_." . $aadharFileType;
        $aadharPath = $internCourse . $aname;

        if (move_uploaded_file($_FILES['course_logo']['tmp_name'], $aadharPath)) {
            // $response['message'] = "Aadhar uploaded successfully!";
        } else {
            $response['message'] = "Failed to upload Course. Path: $aadharPath";
        }
    }

  

   // Proceed with the database query if image upload was successful or not required
   $insQuery = "INSERT INTO inter_course_tbl (intern_course_name, course_logo) 
                        VALUES ('$course_name', '$aname')";

   // Execute the query and send the appropriate response
   if ($conn->query($insQuery) === TRUE) {
       $response['success'] = true;
       $response['message'] = "Course details added successfully!";
   } else {
       $response['success'] = false;
       $response['message'] = "Error adding Course details: " . $conn->error;
   }

   // Send the response back as JSON
   echo json_encode($response);
   exit();
}

if (isset($_POST['editCourseName']) && $_POST['editCourseName'] != '') {
    
    // Get form data
    $course_id = $_POST['course_id'];
    $course_name = $_POST['editCourseName'];

    // Initialize file paths
    $aadharPath = '';
    $aname = '';

    // Check if a file is uploaded
    if (!empty($_FILES['editCourseLogo']['tmp_name'])) {
        $aadharFileType = strtolower(pathinfo($_FILES['editCourseLogo']['name'], PATHINFO_EXTENSION));
        $aname = $course_name . "_." . $aadharFileType;
        $aadharPath = $internCourse . $aname;

        if (move_uploaded_file($_FILES['editCourseLogo']['tmp_name'], $aadharPath)) {
            // File uploaded successfully
        } else {
            $response['success'] = false;
            $response['message'] = "Failed to upload Course logo. Path: $aadharPath";
            echo json_encode($response);
            exit();
        }

        // If file is uploaded, include the logo update
        $updateQuery = "UPDATE inter_course_tbl 
                        SET intern_course_name = '$course_name', 
                            course_logo = '$aname' 
                        WHERE inte_cou_id = '$course_id'";
    } else {
        // If no file is uploaded, update only the course name
        $updateQuery = "UPDATE inter_course_tbl 
                        SET intern_course_name = '$course_name' 
                        WHERE inte_cou_id = '$course_id'";
    }

    // Execute the query and send the appropriate response
    if ($conn->query($updateQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Course details updated successfully!";
    } else {
        $response['success'] = false;
        $response['message'] = "Error updating course details: " . $conn->error;
    }

    // Send the response back as JSON
    echo json_encode($response);
    exit();
}

if (isset($_POST['deleteId'])) {
    $courseId = $_POST['deleteId'];

    // Sanitize the input to avoid SQL injection
    $courseId = mysqli_real_escape_string($conn, $courseId);

    // Delete query
    $deleteQuery = "UPDATE `inter_course_tbl` SET status ='Inactive' WHERE inte_cou_id = '$courseId'";

    // Execute query
    if ($conn->query($deleteQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Course deleted successfully!";
    } else {
        $response['success'] = false;
        $response['message'] = "Error deleting Course: " . $conn->error;
    }
    // Send JSON response back to the AJAX call
    echo json_encode($response);
    exit();
}

if (isset($_POST['cour_Id']) && $_POST['cour_Id'] !== '') {
    $courseId = $_POST['cour_Id'];
    
    $pptFetch="SELECT
                    `ppt_id`,
                    `cou_id`,
                    `title`,
                    `description`,
                    `file_name`
                FROM
                    `intern_ppt_tbl`
                WHERE
                    `status` = 'Active' AND `cou_id` = '$courseId'";
    $pptResult = mysqli_query($conn, $pptFetch);
    
    if ($pptResult) {
        $pptDetails = array(); 
        $baseUrl = 'https://asset.inforiya.in/ERP/ERP_image/InternPPT/';
        while ($row = mysqli_fetch_assoc($pptResult)) {
            $pptDetails[] = array(
                'id' => htmlspecialchars_decode($row['ppt_id'], ENT_QUOTES),
                'couId' => htmlspecialchars_decode($row['cou_id'], ENT_QUOTES),
                'content_title' => htmlspecialchars_decode($row['title'], ENT_QUOTES),
                'descript' => htmlspecialchars_decode($row['description'], ENT_QUOTES),
                'file_url' => $baseUrl . urlencode($row['file_name'])
            );
        }
        echo json_encode($pptDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}

if (isset($_POST['contentTitle']) && $_POST['contentTitle'] != '') {
    
    date_default_timezone_set('Asia/Kolkata');
    $courseId = $_POST['courseId'];
    $contentTitle = $_POST['contentTitle'];
    $description = $_POST['description'];
    $created_by = $_SESSION['id'];

    $aadharPath = '';
    $aname = '';

    if (!empty($_FILES['ppt']['tmp_name'])) {
        $aadharFileType = strtolower(pathinfo($_FILES['ppt']['name'], PATHINFO_EXTENSION));

        $timestamp = date('dMYHis'); 
        $aname = $courseId . '_' . $timestamp . '.' . $aadharFileType;
        $aadharPath = $internPPT . $aname;

        if (move_uploaded_file($_FILES['ppt']['tmp_name'], $aadharPath)) {
        } else {
            $response['message'] = "Failed to upload Course. Path: $aadharPath";
        }
    }

   $pptQuery = "INSERT INTO intern_ppt_tbl (cou_id, title, description, file_name, created_by) 
                        VALUES ('$courseId', '$contentTitle', '$description', '$aname', '$created_by')";

   // Execute the query and send the appropriate response
   if ($conn->query($pptQuery) === TRUE) {
       $response['success'] = true;
       $response['message'] = "Course details added successfully!";
   } else {
       $response['success'] = false;
       $response['message'] = "Error adding Course details: " . $conn->error;
   }

   // Send the response back as JSON
   echo json_encode($response);
   exit();
}

if (isset($_POST['pptEdit']) && $_POST['pptEdit'] !== '') {
    
    $id= $_POST['pptEdit'];
        
    $pptFetchquery = "SELECT
                        `ppt_id`,
                        `cou_id`,
                        `title`,
                        `description`
                    FROM
                        `intern_ppt_tbl`
                    WHERE
                        `ppt_id` = '$id'"; 
                
    $resultPPT = $conn->query($pptFetchquery);
    
    $pptDetails = [];
    if ($resultPPT) {
        while ($row = $resultPPT->fetch_assoc()) {
            $pptDetails =array(
             'id' => $row['ppt_id'],
             'cou_id' => $row['cou_id'],
             'title' => $row['title'],
             'descript' => $row['description']
            );
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($pptDetails);
    exit();
} 

if (isset($_POST['pptIdEdit']) && $_POST['pptIdEdit'] != '') {
    
    date_default_timezone_set('Asia/Kolkata');
    $pptId          = $_POST['pptIdEdit'];
    $course_id      = $_POST['courseIdEdit'];
    $title          = $_POST['contentTitleEdit'];
    $description    = $_POST['descriptionEdit'];

    $aadharPath = '';
    $aname = '';

    if (!empty($_FILES['pptEdit']['tmp_name'])) {
        $aadharFileType = strtolower(pathinfo($_FILES['pptEdit']['name'], PATHINFO_EXTENSION));
        $timestamp = date('dMYHis'); 
        $aname = $course_id . '_' . $timestamp . '.' . $aadharFileType;
        $aadharPath = $internPPT . $aname;

        if (move_uploaded_file($_FILES['pptEdit']['tmp_name'], $aadharPath)) {
        } else {
            $response['success'] = false;
            $response['message'] = "Failed to upload PPT File. Path: $aadharPath";
            echo json_encode($response);
            exit();
        }

        $updateQuery1 = "UPDATE
                            `intern_ppt_tbl`
                        SET
                            `ppt_id` = '$pptId',
                            `cou_id` = '$course_id',
                            `title` = '$title',
                            `description` = '$description',
                            `file_name` = '$aname'
                        WHERE
                            `ppt_id` = '$pptId'";
    } else {
        $updateQuery1 = "UPDATE
                            `intern_ppt_tbl`
                        SET
                            `ppt_id` = '$pptId',
                            `cou_id` = '$course_id',
                            `title` = '$title',
                            `description` = '$description'
                        WHERE
                            `ppt_id` = '$pptId'";
    }

    if ($conn->query($updateQuery1) === TRUE) {
        $response['success'] = true;
        $response['message'] = "PPT details updated successfully!";
    } else {
        $response['success'] = false;
        $response['message'] = "Error updating PPT details: " . $conn->error;
    }

    echo json_encode($response);
    exit();
}

?>