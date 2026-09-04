<?php

session_start();


include("../../db/dbConnection.php");
header('Content-Type: application/json');
include("../../url.php");


if (isset($_POST['hdnAction']) && $_POST['hdnAction'] === 'addDepartment') {
    $category = $_POST['category'] ?? '';
    $subcategory = $_POST['subcategory'] ?? '';
    $task = $_POST['task'] ?? '';
    $hours = floatval($_POST['hours'] ?? 0);
    $taskDate = $_POST['taskDate'] ?? '';
    $empName = $_POST['employee'] ?? [];
    $employees_id = implode(",", $empName);

    $descriptionHtml = $_POST['description'] ?? '';
    $description = htmlspecialchars($descriptionHtml, ENT_QUOTES, 'UTF-8');
    $projectURL = $_POST['projectURL'] ?? '';
    $projectStatus = $_POST['projectStatus'] ?? '';
    $createdBy = $_SESSION['id'];

    $imageNames = [];
    if (!empty($_FILES['projectImage']['name'][0])) {
        foreach ($_FILES['projectImage']['tmp_name'] as $index => $tmpName) {
            $fileName = basename($_FILES['projectImage']['name'][$index]);
            $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $uniqueFileName = uniqid("img_", true) . '.' . $fileType;
            $targetPath = $dailyReportImage . $uniqueFileName;

            if (move_uploaded_file($tmpName, $targetPath)) {
                $imageNames[] = $uniqueFileName;
            } else {
                echo json_encode(['success' => false, 'message' => "Failed to upload image: $fileName"]);
                exit();
            }
        }
    }
    $imageNamesString = implode(",", $imageNames);

    // Check existing task
    if (!empty($task)) {
        $checkQuery = "SELECT `id`, `hours` FROM `employee_task` WHERE `id` = ?";
        $stmt = $conn->prepare($checkQuery);
        if ($stmt) {
            $stmt->bind_param("i", $task);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
        } else {
            echo json_encode(['success' => false, 'message' => "Query preparation failed: " . $conn->error]);
            exit();
        }

        $old_hours = $row['hours'] ?? 0.00;

        if ($old_hours == 0.00) {
            $taskId = $row['id'];
            $updateQuery = "UPDATE `employee_task` SET `hours` = ? WHERE `id` = ?";
            $updateStmt = $conn->prepare($updateQuery);
            if ($updateStmt) {
                $updateStmt->bind_param("di", $hours, $taskId);
                $updateStmt->execute();
            } else {
                echo json_encode(['success' => false, 'message' => "Failed to prepare update query: " . $conn->error]);
                exit();
            }
        }
    }

    // Insert new daily report
    $insQuery = "INSERT INTO `daily_report_tbl` (
                    `date`, `name`, `category_id`, `subcategory_id`, `task_id`, 
                    `task`, `hours`, `url`, `image`, `task_status`, `created_by`
                 ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insQuery);
    if ($stmt) {
        $stmt->bind_param("ssiiisdssss", $taskDate, $employees_id, $category, $subcategory, $task, $description, $hours, $projectURL, $imageNamesString, $projectStatus, $createdBy);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => "Daily Report details added successfully!"]);
        } else {
            echo json_encode(['success' => false, 'message' => "Error adding Daily Report details: " . $stmt->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => "Failed to prepare insert query: " . $conn->error]);
    }
    exit();
}
if (isset($_POST['getData']) && $_POST['getData'] === 'GetTable') {
    // Get pagination and sorting values
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $length = isset($_POST['length']) ? intval($_POST['length']) : 10;

    // Get filter and sorting values
    $startDate = mysqli_real_escape_string($conn, $_POST['startDate'] ?? '');
    $endDate = mysqli_real_escape_string($conn, $_POST['endDate'] ?? '');
    $category = mysqli_real_escape_string($conn, $_POST['category'] ?? '');
    $subcategory = mysqli_real_escape_string($conn, $_POST['subcategory'] ?? '');
    $task = mysqli_real_escape_string($conn, $_POST['task'] ?? '');
    $empName = intval($_POST['empName'] ?? 0);
    $status = $_POST['status'] ?? ''; // Default to 'In Process' if not provided
    
    // Ensure valid sorting parameters
    $orderColumn = $_POST['order'][0]['column'] ?? 0;
    $orderDir = strtolower($_POST['order'][0]['dir'] ?? 'asc') === 'desc' ? 'DESC' : 'ASC';

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

    // Validate sorting column
    $orderColumn = isset($columns[$orderColumn]) ? $columns[$orderColumn] : 'a.date';

    // Build the query
    $sql = "SELECT
                a.id AS report_id,
                a.date,
                a.hours,
                a.working_date,
                a.working_hours,
                a.task AS description,
                a.name,
                c.category,
                d.subcategory,
                e.task,
                a.task_status,
                a.image,
                a.url,
                a.created_by AS user_id
            FROM
                daily_report_tbl AS a
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
    if (!empty($empName)) {
        $sql .= " AND a.created_by = $empName";
    }
    if (!empty($startDate)) {
        $sql .= " AND a.date >= '$startDate'";
    }
    if (!empty($endDate)) {
        $sql .= " AND a.date <= '$endDate'";
    }
    if (!empty($category)) {
        $sql .= " AND a.category_id = '$category'";
    }
    if (!empty($subcategory)) {
        $sql .= " AND a.subcategory_id = '$subcategory'";
    }
    if (!empty($task)) {
        $sql .= " AND a.task_id = '$task'";
    }

    // Apply sorting by the `id` column directly, defaulting to `id` column
        $sql .= " ORDER BY a.id $orderDir";  // This ensures sorting by `id` column in the requested order (ASC or DESC)

    // Apply pagination
    $sql .= " LIMIT $start, $length";

    // Execute the query
    $result = mysqli_query($conn, $sql);




    // Fetch results
    $data = [];
    $index = $start + 1;
    while ($row = mysqli_fetch_assoc($result)) {
        // Format working date
        $dateWorking = ($row['working_date'] === '0000-00-00' || $row['working_date'] === null) 
            ? "----" 
            : date('d-M-Y', strtotime($row['working_date']));
        
        $data[] = [
            'id' => $row['report_id'],
            'sid' => $index++,
            'date' => date('d-M-Y', strtotime($row['date'])),
            'working_date' => $dateWorking,
            'name' => Employee_name($conn,$row['name']),
            'category' => $row['category'],
            'subcategory' => $row['subcategory'],
            'task' => $row['task'],
            'hours' => $row['hours'],
            'working_hours' => $row['working_hours'],
            'created_by' => getName($row['user_id']),
            'image' => $row['image'] ?? 'image',
            'description' => html_entity_decode($row['description']),
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

    // Count total records
    $countSql = "SELECT COUNT(*) AS total 
                 FROM daily_report_tbl 
                 WHERE status = 'Active'";
    if (!empty($empName)) {
        $countSql .= " AND created_by = $empName";
    }
    $countResult = mysqli_query($conn, $countSql);
    $totalRecords = mysqli_fetch_assoc($countResult)['total'] ?? 0;
    
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
    $countFilteredSql .= " AND a.created_by = '" . mysqli_real_escape_string($conn, $empName) . "'";
}

// Execute the filtered count query
$countFilteredResult = mysqli_query($conn, $countFilteredSql);
$filteredTotalRecords = mysqli_fetch_assoc($countFilteredResult)['filtered_total'];

    // Return JSON response
    echo json_encode([
        "draw" => $_POST['draw'],
        "recordsTotal" => $totalRecords,
        "recordsFiltered" => $filteredTotalRecords,
        "data" => $data
    ]);
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


    //Handles Fetching the Enquire details for editing 
if (isset($_POST['editIdReport']) && $_POST['editIdReport'] != '') {
    $editId = $_POST['editIdReport'];

    $enquireFetch="SELECT   `id`,
    `date`,
    `working_date`,
    `completed_date`,
    `name`,
    `category_id`,
    `subcategory_id`,
    `task_id`,
    `task`,
    `hours`,
    `working_hours`,
    `url`,
    `image`,
    `task_status`,
    `create_at`,
    `created_by`,
    `status` FROM `daily_report_tbl` WHERE id = '$editId';";
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

    

    
        
        $updateQuery = "UPDATE `daily_report_tbl` 
                        SET `category_id` = ?, `subcategory_id` = ?, `task_id` = ?, `task` = ?, `url` = ?, `image` = ?, 
                            `task_status` = ?, `hours` = ?, `date` = ? 
                        WHERE `id` = ?";
                        
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("iiissssdsi", $categoryEdit, $subcategoryEdit, $taskEdit, $description, $projectURL, 
                          $imageNamesString, $projectStatus, $hoursEdit, $dateEdit, $reportId);

      
  
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
