<?php

session_start();


include("../../db/dbConnection.php");
header('Content-Type: application/json');
include("../../url.php");

if (isset($_POST['hdnAction']) && $_POST['hdnAction'] === 'addDepartment') {
    
    // Get form data
 
    $hours = $_POST['hours'] ?? '';
    $workDate = $_POST['workDate'] ?? '';
    // $empName = $_POST['employee'] ?? '';
    
    $descriptionHtml = $_POST['description'] ?? '';
    $description = htmlspecialchars($descriptionHtml, ENT_QUOTES, 'UTF-8');
    $projectURL = $_POST['projectURL'] ?? '';
    $createdBy = $_SESSION['id'];

    // Initialize an array to store image filenames
$imageNames = [];

// Check if files were uploaded
if (!empty($_FILES['projectImage']['name'][0])) {
    // Loop through each uploaded file
    foreach ($_FILES['projectImage']['tmp_name'] as $index => $tmpName) {
        $fileName = basename($_FILES['projectImage']['name'][$index]);
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $uniqueFileName = uniqid("img_", true) . '.' . $fileType; // Generate unique filename
        $targetPath = $dailyReportImage . $uniqueFileName; // Define target path

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

// Convert image filenames array to a string (comma-separated) for storage in the database
$imageNamesString = implode(",", $imageNames);

// Insert data into the database
$insQuery = "INSERT INTO `trainee_work_update_tbl`(
                            `date`,
                            `name`,
                            `work`,
                            `hours`,
                            `url`,
                            `image`,
                            `created_by`
                        )
                        VALUES(
                            ?,
                            ?,
                            ?,
                            ?,
                            ?,
                            ?,
                            ?
                        )";

$stmt = $conn->prepare($insQuery);
$stmt->bind_param("sisdssi", $workDate, $createdBy,$description ,$hours , $projectURL, $imageNamesString, $createdBy);

if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = "Daily Work details added successfully!";
} else {
    $response['success'] = false;
    $response['message'] = "Error adding Daily Work details: " . $conn->error;
}

    echo json_encode($response);
    exit();
}

    if (isset($_POST['getData']) && $_POST['getData'] === 'GetTable') {
        // Get pagination and sorting values from the request
        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $length = isset($_POST['length']) ? intval($_POST['length']) : 10;
        $search = $_POST['search']['value']; // Global search value
        
        // Get sorting values from the request
        $orderColumn = $_POST['order'][0]['column'] ?? 0;
        $orderDir = $_POST['order'][0]['dir'] ?? 'asc';
        $orderDir = strtolower($orderDir) === 'desc' ? 'DESC' : 'ASC';
    
        // Get filter values
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $employee = $_POST['empName'];
       $hours_total = "0:00"; // Initialize total in HH:MM format
    
        // Start the query with the basic selection
            $sql = "SELECT
                        a.id,
                        a.date,
                        b.name,
                        a.work,
                        a.hours,
                        a.url,
                        a.image
                    FROM
                        `trainee_work_update_tbl` AS a
                    LEFT JOIN basic_details AS b
                    ON
                        a.name = b.id
                    WHERE
                        a.status = 'Active'";  // Start with WHERE clause
            
            // Apply filters - ensure 'AND' only appears after the first condition
            if (!empty($startDate)) {
                $sql .= " AND a.date >= '" . mysqli_real_escape_string($conn, $startDate) . "'";
            }
            if (!empty($endDate)) {
                $sql .= " AND a.date <= '" . mysqli_real_escape_string($conn, $endDate) . "'";
            }
            if (!empty($employee)) {
                $sql .= " AND a.name = '" . mysqli_real_escape_string($conn, $employee) . "'";  // Corrected operator to '='
            }
            
            // Ensure `$orderDir` is either 'ASC' or 'DESC' before using it in the query
            $orderDir = isset($orderDir) && in_array(strtoupper($orderDir), ['ASC', 'DESC']) ? strtoupper($orderDir) : 'ASC';  // Default to 'ASC'
            
            // Apply sorting by the `id` column
            $sql .= " ORDER BY a.id $orderDir";  // This ensures sorting by `id` column in the requested order (ASC or DESC)
            
            // Apply pagination
            $sql .= " LIMIT $start, $length"; 
    
        // Execute the query
        $result = mysqli_query($conn, $sql);
    
        $index = 0;
        $data = [];
      
// Function to add hours and minutes in HH.MM format
function addHoursAndMinutes($time1, $time2) {
    // Split the time into hours and minutes
    list($hours1, $minutes1) = explode('.', $time1);
    list($hours2, $minutes2) = explode('.', $time2);

    // Convert to integers
    $hours1 = (int)$hours1;
    $minutes1 = (int)$minutes1;
    $hours2 = (int)$hours2;
    $minutes2 = (int)$minutes2;

    // Add hours and minutes
    $totalHours = $hours1 + $hours2;
    $totalMinutes = $minutes1 + $minutes2;

    // Handle overflow of minutes (convert to hours)
    if ($totalMinutes >= 60) {
        $totalHours += intdiv($totalMinutes, 60); // Add extra hours
        $totalMinutes %= 60; // Remainder minutes
    }

    // Return in HH.MM format (ensure two-digit minutes)
    return sprintf('%d.%02d', $totalHours, $totalMinutes);
}

$totalAssignedHours = "0.00"; // Initialize total hours

 $hours_total = "0:00"; // Initialize total in HH:MM format
        while ($row = mysqli_fetch_assoc($result)) {
            
        // Accumulate total hours using the function
    $totalAssignedHours = addHoursAndMinutes($totalAssignedHours, $row['hours']);
        
          
            
            $data[] = [
                'id' => $row['id'],
                'sid' => ++$index,
                'date' => date('d-M-Y', strtotime($row['date'])),
                'name' => $row['name'],
                'hours' => $row['hours'],
                'image' => $row['image'] ?? 'image',
                'desription' => html_entity_decode($row['work']),
                'url' => $row['url'] ?? 'URL',
                'action' => (function () use ($row) {
            // Define trainer roles and admin check
           $admin = [17]; // Define admin roles
            $superAdmin = $_SESSION['is_admin'] === 'True'; // Check if user is a super admin
            $isEmployeeRole = in_array($_SESSION['role'], $admin); // Check if user is in admin roles
            
            // Generate action buttons
            $viewButton = "
                <button type='button' class='btn btn-sm btn-outline-info view-btn' data-bs-toggle='modal' data-bs-target='#viewModal'>
                    <i class='lni lni-eye'></i>
                </button>";
            
            // Exclude edit button for admin and super admin
            $editButton = (!$superAdmin && !$isEmployeeRole) ? "
                <button type='button' class='btn btn-sm btn-outline-warning' onclick='goEditEnquire({$row['id']});' data-bs-toggle='modal' data-bs-target='#editReportModal'>
                    <i class='lni lni-pencil'></i>
                </button>" : '';
            
            // Combine buttons
            return "<td>$viewButton $editButton</td>";
            
        })(),
            ];
        }
    
        // Get total records count
        $countSql = "SELECT COUNT(*) AS total FROM `trainee_work_update_tbl` WHERE status = 'Active'";
        
        // Apply filters for the total count query
        if (!empty($empName)) {
            $countSql .= " AND name = '" . mysqli_real_escape_string($conn, $empName) . "'";  // Fixed: added quotes around $empName
        }
        
        // Execute the total count query
        $countResult = mysqli_query($conn, $countSql);
        $totalRecords = mysqli_fetch_assoc($countResult)['total'];
        
        // Get total records count with filters applied
        $countFilteredSql = "SELECT COUNT(*) AS filtered_total FROM `trainee_work_update_tbl` AS a LEFT JOIN basic_details AS b ON a.name = b.id WHERE a.status = 'Active'";
        
        // Apply filters for the filtered count query
        if (!empty($startDate)) {
            $countFilteredSql .= " AND a.date >= '" . mysqli_real_escape_string($conn, $startDate) . "'";
        }
        if (!empty($endDate)) {
            $countFilteredSql .= " AND a.date <= '" . mysqli_real_escape_string($conn, $endDate) . "'";
        }
        if (!empty($employee)) {
            $countFilteredSql .= " AND a.name = '" . mysqli_real_escape_string($conn, $employee) . "'";  // Fixed: added the correct filter for employee
        }
        
        // Execute the filtered count query
        $countFilteredResult = mysqli_query($conn, $countFilteredSql);
    $filteredTotalRecords = mysqli_fetch_assoc($countFilteredResult)['filtered_total'];
    
        // Return JSON response
        echo json_encode([
            "draw" => $_POST['draw'],
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredTotalRecords,
            "data" => $data ,
        "totals" => [
            "working_hours" => $totalAssignedHours
        ]
        ]);
    }



    
    
    //Handles Fetching the Enquire details for editing 
if (isset($_POST['editIdReport']) && $_POST['editIdReport'] != '') {
    $editId = $_POST['editIdReport'];

    $enquireFetch="SELECT
                `id`,
                `date`,
                `name`,
                `work`,
                `hours`,
                `url`,
                `image`
            FROM
                `trainee_work_update_tbl`
            WHERE
                id = '$editId';";
                
    $fetchResult = mysqli_query($conn, $enquireFetch);
    
    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);
        
        $enquireDetails = array(
            'id' => $row['id'],
            'date' => $row['date'],
            'full_name' => getName($row['name']),
            'name' => $row['name'],
            'work' => $row['work'],
            'hours' => $row['hours'],
            'url' => $row['url'],
            'image' => $row['image'],
             'ImageUrl' => $dailyReportImageView
           
            

        );
        echo json_encode($enquireDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}



function getName($id) {
        global $conn; // Assuming $conn is your database connection variable
    
        // Query to retrieve university name based on uni_id
        $Uni_name = "SELECT 
        `name`
         FROM `basic_details` 
         WHERE `id` = '$id'";
    
        // Execute the query
        $result = $conn->query($Uni_name);
    
        // Check if query was successful and there is a result
        if ($result && $result->num_rows > 0) {
            // Fetch the university name
            $row = $result->fetch_assoc();
            return $row['name'];
        } else {
            // Query execution failed or no results found
            return "No name ";
        }
    }


if (isset($_POST['hdnAction']) && $_POST['hdnAction'] === 'editDepartment') {
    // Extract form data
    $reportId = $_POST['editReportId'] ?? '';
  

    $hoursEdit = isset($_POST['hoursEdit']) ? floatval($_POST['hoursEdit']) : 0.0;

    $descriptionHtml = $_POST['descriptionEdit'] ?? '';
    $description = htmlspecialchars($descriptionHtml, ENT_QUOTES, 'UTF-8');
    $projectURL = $_POST['projectURLEdit'] ?? '';
   

    $imageNames = [];

    // Handle new image uploads
    if (isset($_FILES['newImageInput']) && !empty($_FILES['newImageInput']['name'][0])) {
        foreach ($_FILES['newImageInput']['tmp_name'] as $index => $tmpName) {
            $fileName = basename($_FILES['newImageInput']['name'][$index]);
            $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $uniqueFileName = uniqid("img_", true) . '.' . $fileType;
            $targetPath = $dailyReportImage . $uniqueFileName;

            if (move_uploaded_file($tmpName, $targetPath)) {
                $imageNames[] = $uniqueFileName;
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => "Failed to upload image: $fileName"
                ]);
                exit();
            }
        }
    }

    // Merge existing images
    $existingImages = $_POST['existingImages'] ?? '';
    if (!empty($existingImages)) {
        $imageNames = array_merge($imageNames, explode(',', $existingImages));
    }
    $imageNamesString = implode(",", $imageNames);

   



        // Condition 1: `date == assign date` and `assign date == $workingDate`
        $updateQuery = "UPDATE `trainee_work_update_tbl` SET `work`= ? ,`hours`= ? ,`url`= ? ,`image`= ? WHERE id = ?";
        
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sdssi", $description, $hoursEdit , $projectURL, 
                          $imageNamesString, $reportId);

        


    // Execute and respond
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => "Daily Report updated successfully!" 
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => "Error: " . $conn->error
        ]);
    }
    exit();
}







