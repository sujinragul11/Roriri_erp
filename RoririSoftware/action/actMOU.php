<?php

include("../../db/dbConnection.php");



$response = ['success' => false, 'message' => ''];



header("Access-Control-Allow-Origin: *"); // Allow requests from any origin

header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow only POST, GET, and OPTIONS requests

header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Specify allowed headers



if (isset($_POST['college']) && $_POST['college'] != '') {



    $college  = htmlspecialchars($_POST['college'], ENT_QUOTES, 'UTF-8');

    $catname  = $_POST['categoryName'];

    $date     = htmlspecialchars($_POST['date'], ENT_QUOTES, 'UTF-8');

    $empName  = htmlspecialchars($_POST['inchargeName'], ENT_QUOTES, 'UTF-8');

    $status   = htmlspecialchars($_POST['mouStatus'], ENT_QUOTES, 'UTF-8');

    $descript = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');

    

    // Set the timezone to Asia/Kolkata

    date_default_timezone_set('Asia/Kolkata');

    $currentTime = date('Y-m-d H:i:s'); 

    
    $imageNames = [];

    $uploadDir = '../../assets/images/MOU/';
    if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0777, true); }




    // Check if files were uploaded

    if (!empty($_FILES['documents']['name'][0])) {

        // Loop through each uploaded file

        foreach ($_FILES['documents']['tmp_name'] as $index => $tmpName) {

            $fileName = basename($_FILES['documents']['name'][$index]);

            $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $currentTimeFormatted = date('dMyHis');

            $uniqueFileName = "img_" . $currentTimeFormatted . '_' . ($index + 1) . '.' . $fileType;

            $targetPath = $uploadDir . $uniqueFileName; // Define target path

    

            // Move uploaded file to target directory

            if (move_uploaded_file($tmpName, $targetPath)) {

                $imageNames[] = $uniqueFileName; // Add the unique filename (not full path) to array

            } else {

                $response['success'] = false;

                $response['message'] = "Failed to upload image: $fileName";

                echo json_encode($response);

                exit();

            }

        }

    }

    

    $imageNamesString = implode(",", $imageNames);

    

    $query = "INSERT INTO `mou_tbl`(

                    `name`,

                    `category`,

                    `date`,

                    `incharge`,

                    `moustatus`,

                    `documents`,

                    `description`

                )

                VALUES(

                    '$college',

                    '$catname',

                    '$date',

                    '$empName',

                    '$status',

                    '$imageNamesString',

                    '$descript'

                )";



    if ($conn->query($query) === TRUE) {

        echo json_encode(['status' => 'success', 'message' => 'MOU Details submitted successfully!']);

    } else {

        echo json_encode(['status' => 'error', 'message' => 'Error submitting MOU: ' . $conn->error]);

    }

}



if (isset($_POST['mouId']) && $_POST['mouId'] != '') {

    $mouId = $_POST['mouId'];



      $editFetch = "SELECT

                        `mou_id`,

                        `name`,

                        `category`,

                        `date`,

                        `incharge`,

                        `moustatus`,

                        `documents`,

                        `description`

                    FROM

                        `mou_tbl`

                    WHERE

                        `mou_id` = '$mouId'";

    $fetchResult = mysqli_query($conn, $editFetch);

    

    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);



        $expenseDetails = array(

            'id'        => $row['mou_id'],

            'name'   => $row['name'],

            'category'   => $row['category'],

            'date'      => $row['date'],

            'incharge'  => htmlspecialchars_decode($row['incharge'], ENT_QUOTES),

            'moustatus'  => htmlspecialchars_decode($row['moustatus'], ENT_QUOTES),

            'descript'   => htmlspecialchars_decode($row['description'], ENT_QUOTES)

        );

        echo json_encode($expenseDetails);

    } else {

        $response['message'] = "Error executing query: " . mysqli_error($conn);

        echo json_encode($response);

    }

    exit();

}



if (isset($_POST['collegeEdit']) && $_POST['collegeEdit'] != '') {



    $MOUId = htmlspecialchars($_POST['MOUId'], ENT_QUOTES, 'UTF-8');

    $college  = htmlspecialchars($_POST['collegeEdit'], ENT_QUOTES, 'UTF-8');

    $catname  = $_POST['categoryNameEdit'];

    $date     = htmlspecialchars($_POST['dateEdit'], ENT_QUOTES, 'UTF-8');

    $empName  = htmlspecialchars($_POST['inchargeNameEdit'], ENT_QUOTES, 'UTF-8');

    $status   = htmlspecialchars($_POST['mouStatusEdit'], ENT_QUOTES, 'UTF-8');

    $document = htmlspecialchars($_POST['documentsEdit'], ENT_QUOTES, 'UTF-8');

    $descript = htmlspecialchars($_POST['descriptionEdit'], ENT_QUOTES, 'UTF-8');

    

    // Set the timezone to Asia/Kolkata

    date_default_timezone_set('Asia/Kolkata');

    $currentTime = date('Y-m-d H:i:s'); 

    
    $imageNames = [];

    $uploadDir = '../../assets/images/MOU/';
    if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0777, true); }




    // Check if files were uploaded

    if (!empty($_FILES['documentsEdit']['name'][0])) {

        // Loop through each uploaded file

        foreach ($_FILES['documentsEdit']['tmp_name'] as $index => $tmpName) {

            $fileName = basename($_FILES['documentsEdit']['name'][$index]);

            $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $currentTimeFormatted = date('dMyHis');

            $uniqueFileName = "img_" . $currentTimeFormatted . '_' . ($index + 1) . '.' . $fileType;

            $targetPath = $uploadDir . $uniqueFileName; // Define target path

    

            // Move uploaded file to target directory

            if (move_uploaded_file($tmpName, $targetPath)) {

                $imageNames[] = $uniqueFileName; // Add the unique filename (not full path) to array

            } else {

                $response['success'] = false;

                $response['message'] = "Failed to upload image: $fileName";

                echo json_encode($response);

                exit();

            }

        }

    }

    

    $imageNamesString = implode(",", $imageNames);
    

    $editQuery = "UPDATE

                    `mou_tbl`

                SET

                    `mou_id` = '$MOUId',

                    `name` = '$college',

                    `category` = '$catname',

                    `date` = '$date',

                    `incharge` = '$empName',

                    `moustatus` = '$status',

                    `description` = '$descript',

                    `documents` = '$imageNamesString'

                WHERE

                    `mou_id` = '$MOUId'";



    if ($conn->query($editQuery) === TRUE) {

        echo json_encode(['status' => 'success', 'message' => 'MOU Details updated successfully!']);

    } else {

        echo json_encode(['status' => 'error', 'message' => 'Error updating MOU details: ' . $conn->error]);

    }

}



if (isset($_POST['view_expId']) && $_POST['view_expId'] != '') {

    $expense_id = $_POST['view_expId'];



      $queryFetch = "SELECT

                        a.`mou_id`,

                        a.`name`,

                        a.`category`,

                        a.`date`,

                        a.`incharge`,

                        a.`moustatus`,

                        a.`documents`,

                        a.`description`,

                        b.`name` AS empName

                    FROM

                        `mou_tbl` AS a

                    LEFT JOIN 

                        `basic_details` AS b

                    ON

                    	a.`incharge` = b.`id`

                    WHERE

                        a.`mou_id` = '$expense_id'";

    $fetchResult = mysqli_query($conn, $queryFetch);

    

    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);



        $expenseDetails = array(

            'name'        => $row['name'],

            'catName'   => $row['category'],

            'date'      => (new DateTime($row['date']))->format('d M Y'),

            'incharge'  => htmlspecialchars_decode($row['empName'], ENT_QUOTES),

            'descript'  => htmlspecialchars_decode($row['description'], ENT_QUOTES),

            'status'      => htmlspecialchars_decode($row['moustatus'], ENT_QUOTES),

            'documents'   => htmlspecialchars_decode($row['documents'], ENT_QUOTES)

        );

        echo json_encode($expenseDetails);

    } else {

        $response['message'] = "Error executing query: " . mysqli_error($conn);

        echo json_encode($response);

    }

    exit();

}



if (isset($_POST['delId']) && $_POST['delId'] != '') {

    

    $expenseId = $_POST['delId'];



    $deleteQuery = "UPDATE

                        `mou_tbl`

                    SET

                        `status` = 'Inactive'

                    WHERE

                        `mou_id` = '$expenseId'";



    if ($conn->query($deleteQuery) === TRUE) {

        $response['success'] = true;

        $response['message'] = "MOU details Deleted successfully!";

    } else {

        $response['message'] = "Unexpected error in deleting MOU details! " . $conn->error;

    }

    echo json_encode($response);

    exit();

}



?>