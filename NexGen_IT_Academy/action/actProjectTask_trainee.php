<?php

session_start();


include("../../db/dbConnection.php");
header('Content-Type: application/json');
include("../../url.php");

if (isset($_POST['hdnAction']) && $_POST['hdnAction'] === 'addDepartment') {
    
    // Get form data
    $category = $_POST['category'] ?? '';
    $subcategory = $_POST['subcategory'] ?? '';
    $task = $_POST['task'] ?? '';
    $hours = $_POST['hours'] ?? '';
    $taskDate = $_POST['taskDate'] ?? '';
    $empName = $_POST['employee'] ?? '';
    
    $descriptionHtml = $_POST['description'] ?? '';
    $description = htmlspecialchars($descriptionHtml, ENT_QUOTES, 'UTF-8');
    $projectURL = $_POST['projectURL'] ?? '';
    $projectStatus = $_POST['projectStatus'] ?? '';
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
$insQuery = "INSERT INTO `daily_report_tbl` (
                            `date`,
                            `name`,
                            `category_id`,
                            `subcategory_id`,
                            `task_id`,
                            `task`,
                            `hours`,
                            `url`,
                            `image`,
                            `task_status`,
                            `created_by`
                        ) VALUES (
                            ?,
                            ?,
                            ?,
                            ?,
                            ?,
                            ?,
                            ?,
                            ?,
                            ?,
                            ?,
                            ?
                        )";

$stmt = $conn->prepare($insQuery);
$stmt->bind_param("siiiisdssss", $taskDate, $empName,$category ,$subcategory , $task, $description, $hours , $projectURL, $imageNamesString, $projectStatus, $createdBy);

if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = "Daily Report details added successfully!";
} else {
    $response['success'] = false;
    $response['message'] = "Error adding Daily Report details: " . $conn->error;
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
    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $task = $_POST['task'];
    $empName = $_POST['empName'];
    
    // Get the status filter value
    $status = $_POST['status'] ?? ''; // Default to 'In Process' if not provided

    // Example query with filters
    $sql = "SELECT
        a.id AS report_id,
        a.date,
        a.hours,
        a.working_date,
        a.working_hours,
        a.task as desription,
        b.name,
        c.category,
        d.subcategory,
        e.task,
        a.task_status ,
        a.image ,
        a.url ,
        a.created_by
    FROM
        `daily_report_tbl` AS a
    LEFT JOIN basic_details AS b ON a.name = b.id
    LEFT JOIN report_category_tbl AS c ON a.category_id = c.id
    LEFT JOIN report_subcategory_tbl AS d ON a.subcategory_id = d.id
    LEFT JOIN employee_task AS e ON a.task_id = e.id
    WHERE
        a.status = 'Active'";


    if (!empty($status)) {
        $sql .= " AND a.task_status = '" . mysqli_real_escape_string($conn, $status) . "'";
    }
    // Apply filters
    if (!empty($startDate)) {
        $sql .= " AND a.date >= '" . mysqli_real_escape_string($conn, $startDate) . "'";
    }
    if (!empty($endDate)) {
        $sql .= " AND a.date <= '" . mysqli_real_escape_string($conn, $endDate) . "'";
    }
    if (!empty($category)) {
        $sql .= " AND a.category_id = '" . mysqli_real_escape_string($conn, $category) . "'";
    }
    if (!empty($subcategory)) {
        $sql .= " AND a.subcategory_id = '" . mysqli_real_escape_string($conn, $subcategory) . "'";
    }
    if (!empty($task)) {
        $sql .= " AND a.task_id = '" . mysqli_real_escape_string($conn, $task) . "'";
    }
  if (!empty($empName)) {
    $sql .= " AND FIND_IN_SET(" . intval($empName) . ", a.name)";
}
    // Define sortable columns
    $columns = [
        'STR_TO_DATE(a.date, "%Y-%m-%d")', 
        'b.name',              
        'e.task',              
        'a.task_status',       
        'a.working_hours',     
        'a.hours',             
        'a.working_date',      
        'c.category',          
        'd.subcategory'        
    ];

    
         // Apply sorting by the `id` column directly, defaulting to `id` column
        $sql .= " ORDER BY a.id $orderDir";  // This ensures sorting by `id` column in the requested order (ASC or DESC)
   

    // Apply pagination
    $sql .= " LIMIT $start, $length";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    $index = 0;
    $data = [];
  $totalWorkingHours = "0.00"; // Initialize total
$totalAssignedHours = "0.00"; // Initialize total

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
    while ($row = mysqli_fetch_assoc($result)) {
        
     $totalWorkingHours = addHoursAndMinutes($totalWorkingHours, $row['working_hours']);
    $totalAssignedHours = addHoursAndMinutes($totalAssignedHours, $row['hours']);
        // Format working date
        $dateWorking = ($row['working_date'] === '0000-00-00' || $row['working_date'] === null) 
            ? "----" 
            : date('d-M-Y', strtotime($row['working_date']));
        
        $data[] = [
            'id' => $row['report_id'],
            'sid' => ++$index,
            'date' => date('d-M-Y', strtotime($row['date'])),
            'working_date' => $dateWorking,
            'name' => $row['name'],
            'category' => $row['category'],
            'subcategory' => $row['subcategory'],
            'task' => $row['task'],
            'hours' => $row['hours'],
            'working_hours' => $row['working_hours'],
            'created_by' => getName($row['created_by']),
            'image' => $row['image'] ?? 'image',
            'desription' => html_entity_decode($row['desription']),
            'url' => $row['url'] ?? 'URL',
            'task_status' => $row['task_status'],
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
            <button type='button' class='btn btn-sm btn-outline-warning' onclick='goEditEnquire({$row['report_id']});' data-bs-toggle='modal' data-bs-target='#editReportModal'>
                <i class='lni lni-pencil'></i>
            </button>" : '';
        
        // Combine buttons
        return "<td>$viewButton $editButton</td>";
        
    })(),
        ];
    }

    // Get total records count
    $countSql = "SELECT COUNT(*) AS total FROM `daily_report_tbl` WHERE status = 'Active'";
     if (!empty($empName)) {
        $countSql .= " AND name = $empName";
    }
    $countResult = mysqli_query($conn, $countSql);
    $totalRecords = mysqli_fetch_assoc($countResult)['total'];
    
    // Get total records count with filters applied
$countFilteredSql = "SELECT COUNT(*) AS filtered_total FROM `daily_report_tbl` AS a 
LEFT JOIN basic_details AS b ON a.name = b.id
LEFT JOIN report_category_tbl AS c ON a.category_id = c.id
LEFT JOIN report_subcategory_tbl AS d ON a.subcategory_id = d.id
LEFT JOIN employee_task AS e ON a.task_id = e.id
WHERE a.status = 'Active'";

// Apply filters for the filtered count query
 if (!empty($status)) {
        $sql .= " AND a.task_status = '" . mysqli_real_escape_string($conn, $status) . "'";
    }
if (!empty($startDate)) {
    $countFilteredSql .= " AND a.date >= '" . mysqli_real_escape_string($conn, $startDate) . "'";
}
if (!empty($endDate)) {
    $countFilteredSql .= " AND a.date <= '" . mysqli_real_escape_string($conn, $endDate) . "'";
}
if (!empty($category)) {
    $countFilteredSql .= " AND a.category_id = '" . mysqli_real_escape_string($conn, $category) . "'";
}
if (!empty($subcategory)) {
    $countFilteredSql .= " AND a.subcategory_id = '" . mysqli_real_escape_string($conn, $subcategory) . "'";
}
if (!empty($task)) {
    $countFilteredSql .= " AND a.task_id = '" . mysqli_real_escape_string($conn, $task) . "'";
}
if (!empty($empName)) {
    $countFilteredSql .= " AND a.name = '" . mysqli_real_escape_string($conn, $empName) . "'";
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
        "working_hours" => $totalWorkingHours,
        "assigned_hours" => $totalAssignedHours,
    ]
    ]);
    exit;
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
    
    function getProjectName($id) {
        global $conn; // Assuming $conn is your database connection variable
    
        // Query to retrieve university name based on uni_id
        $Uni_name = "SELECT 
        `project_name`
         FROM `project_tbl` 
         WHERE `project_id` = '$id'";
    
        // Execute the query
        $result = $conn->query($Uni_name);
    
        // Check if query was successful and there is a result
        if ($result && $result->num_rows > 0) {
            // Fetch the university name
            $row = $result->fetch_assoc();
            return $row['project_name'];
        } else {
            // Query execution failed or no results found
            return "No name ";
        }
    }
    
    
    //Handles Fetching the Enquire details for editing 
if (isset($_POST['editIdReport']) && $_POST['editIdReport'] != '') {
    $editId = $_POST['editIdReport'];

    $enquireFetch="SELECT
    a.id,
    a.date,
    a.working_date,
    a.completed_date,
    a.name,
    a.category_id,
    a.subcategory_id,
    a.task_id,
    a.task,
    a.hours,
    a.working_hours,
    a.url,
    a.image,
    a.task_status,
    a.create_at,
    a.created_by,
    b.task AS task_view,
    a.status
FROM
    `daily_report_tbl` AS a
LEFT JOIN employee_task AS b
ON
    a.task_id = b.id
WHERE
    a.id = '$editId';";
    $fetchResult = mysqli_query($conn, $enquireFetch);
    
    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);
        
        $enquireDetails = array(
            'id' => $row['id'],
            'date' => $row['date'],
            'working_date' => $row['working_date'],
            'completed_date' => $row['completed_date'],
            'full_name' => getName($row['name']),
            'name' => $row['name'],
            'category_id' => $row['category_id'],
            'subcategory_id' => $row['subcategory_id'],
            'task_id' => $row['task_id'],
            'hours' => $row['hours'],
            'working_hours' => $row['working_hours'],
            'task' => html_entity_decode($row['task']),
            'url' => $row['url'],
            'task_view' => $row['task_view'],
            'ImageUrl' => $dailyReportImageView,
            'image' => $row['image'],
            'created_by' => $row['created_by'],
            'task_status' => $row['task_status']
            

        );
        echo json_encode($enquireDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}


if (isset($_POST['hdnAction']) && $_POST['hdnAction'] === 'editDepartment') {
    // Extract form data
    $reportId = $_POST['editReportId'] ?? '';
    $workingDate = $_POST['workingDate'] ?? '';
    $dateEdit = $_POST['dateEdit'] ?? '';
    $nameEdit = $_POST['nameEdit'] ?? '';
    $createdBy = $_SESSION['id'];

    $categoryEdit = $_POST['categoryEdit'] ?? '';
    $subcategoryEdit = $_POST['subcategoryEdit'] ?? '';
    $taskEdit = $_POST['taskEdit'] ?? 0;
    $hoursEdit = isset($_POST['hoursEdit']) ? floatval($_POST['hoursEdit']) : 0.0;

    $descriptionHtml = $_POST['descriptionEdit'] ?? '';
    $description = htmlspecialchars($descriptionHtml, ENT_QUOTES, 'UTF-8');
    $projectURL = $_POST['projectURLEdit'] ?? '';
    $projectStatus = $_POST['projectStatusEdit'] ?? '';

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

    // Check existing record
    $checkQuery = "SELECT id, working_hours, working_date, date FROM `daily_report_tbl` WHERE `id` = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("i", $reportId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Initialize variables for comparison
    $currentWorkingDate = $row['working_date'] ?? '';
    $currentAssignDate = $row['date'] ?? '';
    $currentHours = $row['working_hours'] ?? 0.0;
    // $newHours = $currentHours + $hoursEdit;

    if ($currentAssignDate == $workingDate) {
        // Condition 1: `date == assign date` and `assign date == $workingDate`
        $updateQuery = "UPDATE `daily_report_tbl` 
                        SET `category_id` = ?, `subcategory_id` = ?, `task_id` = ?, `task` = ?, `url` = ?, `image` = ?, 
                            `task_status` = ?, `working_hours` = ?, `working_date` = ? 
                        WHERE `id` = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("iiissssdsi", $categoryEdit, $subcategoryEdit, $taskEdit, $description, $projectURL, 
                          $imageNamesString, $projectStatus, $hoursEdit, $workingDate, $reportId);
    } elseif ($currentWorkingDate == $workingDate) {
    
     
         // Condition 2: `$working_date == $workingDate`
        $updateQuery = "UPDATE `daily_report_tbl` 
                        SET `category_id` = ?, `subcategory_id` = ?, `task_id` = ?, `task` = ?, `url` = ?, `image` = ?, 
                            `task_status` = ?, `working_hours` = ?, `working_date` = ? 
                        WHERE `id` = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("iiissssdsi", $categoryEdit, $subcategoryEdit, $taskEdit, $description, $projectURL, 
                          $imageNamesString, $projectStatus, $hoursEdit, $workingDate, $reportId);
        
    
       
    } else {
        
        
              // Check existing record
    $checkQuery = "SELECT id FROM `daily_report_tbl` WHERE `task_id` = ? AND `working_date` = ? AND `name` = ? LIMIT 1";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("isi", $taskEdit,$workingDate ,$nameEdit);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $select_id = $row['id'] ?? '';
    
    if(!empty($select_id)){
        
        $statusUpdateQuery = "UPDATE `daily_report_tbl` 
                          SET `task_status` = ? 
                          WHERE `id` = ?";
    $stmt = $conn->prepare($statusUpdateQuery);
    $stmt->bind_param("si", $projectStatus ,$reportId);
    $stmt->execute();
        
        // Condition 2: `$working_date == $workingDate`
        $updateQuery = "UPDATE `daily_report_tbl` 
                        SET `category_id` = ?, `subcategory_id` = ?, `task_id` = ?, `task` = ?, `url` = ?, `image` = ?, 
                            `task_status` = ?, `working_hours` = ?, `working_date` = ? 
                        WHERE `id` = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("iiissssdsi", $categoryEdit, $subcategoryEdit, $taskEdit, $description, $projectURL, 
                          $imageNamesString, $projectStatus, $hoursEdit, $workingDate, $select_id);
        
    }else{
          // Condition 3: Update `task_status` of the existing record and insert a new one
    $statusUpdateQuery = "UPDATE `daily_report_tbl` 
                          SET `task_status` = ? 
                          WHERE `id` = ?";
    $stmt = $conn->prepare($statusUpdateQuery);
    $stmt->bind_param("si", $projectStatus ,$reportId);
    $stmt->execute();
        
        $insertQuery = "INSERT INTO `daily_report_tbl` 
                        (`date`, `working_date`, `name`, `category_id`, `subcategory_id`, `task_id`, `task`, `url`, 
                         `image`, `task_status`, `working_hours`, `created_by`) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssiiiissssdi", $dateEdit, $workingDate, $nameEdit, $categoryEdit, $subcategoryEdit, $taskEdit, 
                          $description, $projectURL, $imageNamesString, $projectStatus, $hoursEdit, $createdBy);
        
    }
        
      
    }

    // Execute and respond
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => $row 
                ? "Daily Report updated successfully!" 
                : "New Daily Report added successfully!"
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => "Error: " . $conn->error
        ]);
    }
    exit();
}



// Check if the request has 'category_id' or 'subcategory_id' and respond accordingly
if (isset($_POST['category']) && $_POST['category'] === 'getCategory') {
    // Fetch categories based on 'Active' status
    $query = "SELECT id, category FROM `report_category_tbl` WHERE status = 'Active' ORDER BY id DESC;";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->execute();
        $result = $stmt->get_result();

        // Store fetched categories in an array
        $response['categories'] = [];
        while ($row = $result->fetch_assoc()) {
            $response['categories'][] = $row;
        }

        $stmt->close();

        // Check if categories are found and set success message
        if (empty($response['categories'])) {
            $response['success'] = false;
            $response['message'] = "No categories found.";
        } else {
            $response['success'] = true;
        }
    } else {
        // Handle failure if query preparation fails
        $response['success'] = false;
        $response['message'] = "Database query failed: " . $conn->error;
    }

    // Set proper content type header for JSON response
    header('Content-Type: application/json');
    echo json_encode($response);  // Ensure the response is in JSON format
    exit();
}



// Check if the request has 'category_id' or 'subcategory_id' and respond accordingly
if (isset($_POST['get_category_id'])) {
    $category_id = intval($_POST['get_category_id']);
    
    // Fetch subcategories based on the selected category ID
    $query = "SELECT id , subcategory FROM `report_subcategory_tbl` WHERE category_id = ? AND status ='Active' ORDER BY id DESC;";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Store the fetched subcategories in an array
    $response['subcategories'] = [];
    while ($row = $result->fetch_assoc()) {
        $response['subcategories'][] = $row;
    }
    $stmt->close();
    
    // Send response back as JSON
        echo json_encode($response);
        exit();
}

if (isset($_POST['get_subcategory_id'])) {
    $subcategory_id = intval($_POST['get_subcategory_id']);
    
    // Fetch tasks based on the selected subcategory ID
    $query = "SELECT id,task FROM `employee_task` WHERE subcategory_id = ? AND status = 'Active' ORDER BY id DESC;";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $subcategory_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Store the fetched tasks in an array
    $response['tasks'] = [];
    while ($row = $result->fetch_assoc()) {
        $response['tasks'][] = $row;
    }
    $stmt->close();
          echo json_encode($response);
        exit();
}


if (isset($_POST['get_task_id'])) {
    $task_id = intval($_POST['get_task_id']);
    
    // Fetch the 'hours' based on the selected task ID
    $query = "SELECT `hours` FROM `employee_task` WHERE status = 'Active' AND id = ?;";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch the 'hours' value
    $response = [];
    if ($row = $result->fetch_assoc()) {
            $response['hours'] = $row['hours'] ?? '';
    }
    $stmt->close();
    
    // Return the 'hours' value as JSON
    echo json_encode($response);
    exit();
}




if (isset($_POST['hdnAction']) && $_POST['hdnAction'] === 'addCategory') {
    // Get the category name and createdBy from the form data and session
    $categoryName = $_POST['categoryName'] ?? '';
    $createdBy = $_SESSION['id'];

    // Check if the category already exists
    $checkQuery = "SELECT COUNT(*) FROM `report_category_tbl` WHERE `category` = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $categoryName);
    $stmt->execute();
    $stmt->bind_result($categoryCount);
    $stmt->fetch();
    $stmt->close();

    // If category already exists, return an error response
    if ($categoryCount > 0) {
        $response['success'] = false;
        $response['message'] = "Category name already exists!";
        echo json_encode($response);
        exit();
    }

    // If category does not exist, insert the new category
    $insertQuery = "INSERT INTO `report_category_tbl` (`category`, `create_by`) VALUES (?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ss", $categoryName, $createdBy);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Category added successfully!";
    } else {
        $response['success'] = false;
        $response['message'] = "Error adding category: " . $conn->error;
    }

    // Close the statement and return the response
    $stmt->close();
    echo json_encode($response);
    exit();
}


// Check if the action is to update a category
if (isset($_POST['action']) && $_POST['action'] === 'updateCategory') {
    $id = $_POST['id'];
    $category = $_POST['category'];

    // Prepare the update query
    $query = "UPDATE report_category_tbl SET category = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $category, $id); // 'si' means string and integer

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Category updated successfully!";
    } else {
        $response['success'] = false;
        $response['message'] = "Error updating category: " . $conn->error;
    }

    echo json_encode($response);
    exit();
}





if (isset($_POST['action']) && $_POST['action'] === 'getSubcategories') {
   

    // Build the query based on whether categoryId is provided
    $query = "SELECT a.id, b.category, a.subcategory 
              FROM `report_subcategory_tbl` AS a 
              LEFT JOIN `report_category_tbl` AS b ON a.category_id = b.id 
              WHERE a.status = 'Active' ORDER BY a.id DESC";

   
    // Prepare and execute the query
    $stmt = $conn->prepare($query);

 

    $stmt->execute();
    $result = $stmt->get_result();

    // Store the fetched subcategories in an array
    $response['subcategories'] = [];
    while ($row = $result->fetch_assoc()) {
        $response['subcategories'][] = $row;
    }
    $stmt->close();

    // Send response back as JSON
    echo json_encode($response);
    exit();
}


// Check if the request has 'edit_id' and respond accordingly
if (isset($_GET['edit_id'])) {
    $id = intval($_GET['edit_id']);
    
    // Fetch subcategory based on the provided `id`
    $query = "SELECT `id`, `category_id`, `subcategory` FROM `report_subcategory_tbl` WHERE id = ?;";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch the single subcategory record as an associative array
    $response = $result->fetch_assoc();
    
    $stmt->close();
    
    // Send response back as JSON
    echo json_encode($response);
    exit();
}

//add subcategory -----------
if (isset($_POST['action']) && $_POST['action'] === 'addSubcategory') {
    $categoryId = $_POST['categoryId'];
    $subcategoryName = $_POST['subcategoryName'];
    $createdBy = $_SESSION['id'];

    // Assuming a database connection is already established in $conn
    $query = "INSERT INTO report_subcategory_tbl (category_id, subcategory, created_by) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isi", $categoryId, $subcategoryName, $createdBy);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'SubCategory added successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add SubCategory.']);
    }
    $stmt->close();
    exit();
}


// edit data update subcategory---
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] === 'editSubcategory') {
    $editSubId = intval($_POST['editSubId']);
    $category_id = $_POST['subcategorySelectEdit'];
    $subcategory = $_POST['subcategoryEdit'];

    // Assuming a database connection is already established in $conn
    $query = "UPDATE report_subcategory_tbl SET category_id = ?, subcategory = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isi", $category_id, $subcategory, $editSubId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update department.']);
    }
    $stmt->close();
    exit();
}


//add task---
if (isset($_POST['action']) && $_POST['action'] === 'addTaskFrom') {
    $categoryId = intval($_POST['categoryId']);
    $subcategoryId = intval($_POST['subcategoryId']);
    $taskName = trim($_POST['taskName']);
    $hours = floatval($_POST['hours']);
    $createdBy = $_SESSION['id']; // Assuming the user ID is stored in the session

    // Prepare the SQL insert query
    $query = "INSERT INTO employee_task (subcategory_id, task, hours, created_by) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isdi", $subcategoryId, $taskName, $hours, $createdBy);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Task added successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add task.']);
    }
    $stmt->close();
    $conn->close();
    exit();
} 


 if ($_POST['action'] === 'getTasks') {
     
        $query = "SELECT
                    a.id as task_id,
                    a.task,
                    a.hours,
                    b.subcategory,
                    c.category
                FROM
                    employee_task AS a
                LEFT JOIN report_subcategory_tbl AS b
                ON
                    a.subcategory_id = b.id
                LEFT JOIN report_category_tbl AS c
                ON
                    b.category_id = c.id
                WHERE
                    a.status = 'Active' ORDER BY a.id DESC;";

        $result = $conn->query($query);
        $tasks = [];

        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }

        echo json_encode(['tasks' => $tasks]);
        exit();
    }
    
    
     if ($_POST['action'] === 'getCategorys') {
     
        $query = "SELECT `id`, `category` FROM `report_category_tbl` WHERE status='Active' ORDER BY id DESC";

        $result = $conn->query($query);
        $tasks = [];

        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }

        echo json_encode(['tasks' => $tasks]);
        exit();
    }





// Check if the request has 'edit_id' and respond accordingly
if (isset($_POST['task_id_edit'])) {
    $id = intval($_POST['task_id_edit']);
    
    // Fetch subcategory based on the provided `id`
    $query = "SELECT
    a.id,
    a.subcategory_id,
    b.category_id,
    a.task,
    a.hours
FROM
    `employee_task` AS a
LEFT JOIN report_subcategory_tbl AS b
ON
    a.subcategory_id = b.id
WHERE
    a.id = ?;";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch the single subcategory record as an associative array
    $response = $result->fetch_assoc();
    
    $stmt->close();
    
    // Send response back as JSON
    echo json_encode($response);
    exit();
}


// Fetch subcategories based on the selected category
if (isset($_POST['action']) && $_POST['action'] == 'getSubcategories_task') {
    $categoryId = intval($_POST['category_id']);

    $query = "SELECT id, subcategory FROM report_subcategory_tbl WHERE category_id = ? ORDER BY id DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    $subcategories = [];
    while ($row = $result->fetch_assoc()) {
        $subcategories[] = $row;
    }

    $stmt->close();
    
    // Send response back as JSON
    echo json_encode($subcategories);
    exit();
}

// Fetch subcategories based on the selected category
if (isset($_POST['action']) && $_POST['action'] == 'get_load_task') {
    $categoryId = intval($_POST['category_id']);

    $query = "SELECT id, task ,hours FROM employee_task WHERE subcategory_id = ? ORDER BY id DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    $subcategories = [];
    while ($row = $result->fetch_assoc()) {
        $subcategories[] = $row;
    }

    $stmt->close();
    
    // Send response back as JSON
    echo json_encode($subcategories);
    exit();
}

if (isset($_POST['action']) && $_POST['action'] === 'updateTaskFrom') {
    $categorySelectTaskEdit = intval($_POST['categorySelectTaskEdit']); // Ensure this is an integer
    $subcategorySelectTaskEdit = intval($_POST['subcategorySelectTaskEdit']); // Ensure this is an integer
    $taskNameEdit = $_POST['taskNameEdit']; // Task name is a string
    $hoursEdit = floatval($_POST['hoursEdit']); // Hours is a float (decimal)
    $editTask_id = intval($_POST['editTask_id']); // Task ID is an integer

    // Assuming a database connection is already established in $conn
    $query = "UPDATE
                    `employee_task`
                SET
                    `subcategory_id` = ?, 
                    `task` = ?, 
                    `hours` = ? 
                WHERE 
                    `id` = ?";

    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database error: Unable to prepare statement.']);
        exit();
    }

    // Bind parameters: 'i' = integer, 's' = string, 'd' = decimal (float)
    $stmt->bind_param("isdi", $subcategorySelectTaskEdit, $taskNameEdit, $hoursEdit, $editTask_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Task updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update task.']);
    }

    $stmt->close();
    exit();
}

// Check if 'category' parameter is set to 'getCategory'
if ($_POST['category_table'] === 'getCategory') {
    // Replace this with actual database fetching code
   $query = "SELECT id, category FROM `report_category_tbl` WHERE status = 'Active' ORDER BY id DESC;";
    
    if ($stmt = $conn->prepare($query)) {
        $stmt->execute();
        $result = $stmt->get_result();

        // Store fetched categories in an array
        $response['categories'] = [];
        while ($row = $result->fetch_assoc()) {
            $response['categories'][] = $row;
        }

        $stmt->close();
        
    // Return JSON response
    echo json_encode($response);
}
}



