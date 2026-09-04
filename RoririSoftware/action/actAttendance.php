<?php
session_start();
include("../../db/dbConnection.php");
include("../../url.php");

header('Content-Type: application/json');

// Initialize response
$response = ['success' => false, 'message' => ''];

if (isset($_POST['inchargeId']) && $_POST['inchargeId'] !== '') {
    $inchargeId = $_POST['inchargeId'];

    $sql = "SELECT intern_id, name FROM internship_tbl WHERE status = 'Active'";

    if ($inchargeId !== 'All') {
        $sql .= " AND incharge_id = ?";
    }

    if ($stmt = $conn->prepare($sql)) {
        if ($inchargeId !== 'All') {
            $stmt->bind_param("i", $inchargeId);
        }

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $interns = [];
                $allInternIds = [];
                while ($row = $result->fetch_assoc()) {
                    $interns[] = [
                        'id' => $row['intern_id'],
                        'name' => $row['name']
                    ];
                    $allInternIds[] = $row['intern_id'];
                }
                $response['success'] = true;
                $response['data'] = $interns; // Add the data only when there are results
                if ($inchargeId === 'All') {
                    $response['allInternIds'] = $allInternIds;
                }
            } else {
                $response['message'] = 'No interns found.';
            }
        } else {
            $response['message'] = 'Failed to execute the query: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['message'] = 'Failed to prepare the SQL statement: ' . $conn->error;
    }
    echo json_encode($response);
}

if (isset($_POST['date']) && $_POST['date'] !== '') {
    
     $date      = $_POST['date'];
     $allIds    = $_POST['allIds'];
     $present   = isset($_POST['interns']) ? $_POST['interns'] : [];
     $userId  = $_SESSION['id'];

    $idsArray = explode(',', $allIds);

    $absent = array_diff($idsArray, $present);

    $presentJson = json_encode($present);

    $absentJson = json_encode(empty($absent) ? [] : array_values($absent));

    $insQuery = "INSERT INTO `intern_attendance`
                    (`date`
                    , `present_ids`
                    , `absent_ids`
                    , `updated_by`) 
                VALUES 
                    ('$date'
                    , '$presentJson'
                    , '$absentJson'
                    , '$userId')";

    if ($conn->query($insQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Attendance details added successfully";
        
        $idsString = implode(',', $idsArray);

        // Update the total_workingdays for all intern IDs in one query
        $updateQuery = "UPDATE internship_tbl
                        SET total_workingdays = CONCAT(
                            CASE 
                                WHEN JSON_CONTAINS('$presentJson', JSON_QUOTE(CAST(intern_id AS CHAR))) THEN 
                                    CONCAT(SUBSTRING_INDEX(total_workingdays, '/', 1) + 1, '/', SUBSTRING_INDEX(total_workingdays, '/', -1) + 1)
                                ELSE 
                                    CONCAT(SUBSTRING_INDEX(total_workingdays, '/', 1), '/', SUBSTRING_INDEX(total_workingdays, '/', -1) + 1)
                            END
                        )
                        WHERE intern_id IN ($idsString)";

        if ($conn->query($updateQuery) === TRUE) {
            $response['message'] .= " with working days!";
        } else {
            // Error updating
            $response['success'] = false;
            $response['message'] = "Error updating total_workingdays: " . $conn->error;
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Error adding Attendance details: " . $conn->error;
    }

    // Send the response back as JSON
    echo json_encode($response);
    exit();
}

if (isset($_POST['dateFetch']) && !empty($_POST['dateFetch'])) {
    $date = $_POST['dateFetch'];
    
    $query = "SELECT present_ids, absent_ids FROM intern_attendance WHERE date = '$date' AND status = 'Active'";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $presentInterns = json_decode($row['present_ids'], true) ?? [];
        $absentInterns  = json_decode($row['absent_ids'], true) ?? [];
        
        // Return the data as JSON
        echo json_encode([
            'success' => true,
            'presentInterns' => $presentInterns,
            'absentInterns' => $absentInterns,
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No attendance record found for the given date.'
        ]);
    }
}

if (isset($_POST['dateEdit']) && $_POST['dateEdit'] !== '') {
    $date = $_POST['dateEdit'];
    $present = isset($_POST['internsEdit']) ? $_POST['internsEdit'] : [];
    $userId  = $_SESSION['id'];

    // Fetch existing attendance data
    $fetchQuery = "SELECT present_ids, absent_ids FROM `intern_attendance` WHERE `date` = ? AND status = 'Active'";
    $stmt = $conn->prepare($fetchQuery);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Decode present and absent IDs
        $existingPresent = json_decode($row['present_ids'], true) ?? [];
        $existingAbsent = json_decode($row['absent_ids'], true) ?? [];

        // Calculate moved IDs
        $movedToAbsent = array_diff($existingPresent, $present);
        $movedToPresent = array_intersect($present, $existingAbsent);
        $absent = array_diff(array_merge($existingPresent, $existingAbsent), $present);

        // Prepare JSON for present and absent IDs
        $presentJson = json_encode(array_values($present));
        $absentJson = json_encode(array_values($absent));

        // Update attendance table
        $updateQuery = "UPDATE `intern_attendance` 
                        SET `present_ids` = ?, `absent_ids` = ?, `updated_by` = ? 
                        WHERE `date` = ? AND status = 'Active'";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ssss", $presentJson, $absentJson, $userId, $date);

        if ($stmt->execute()) {
            // Efficiently update total_workingdays using a single query for both present and absent movements
            if (!empty($movedToAbsent) || !empty($movedToPresent)) {
                updateWorkingDaysBatch($movedToAbsent, $movedToPresent);
            }

            $response = [
                'success' => true,
                'message' => 'Attendance details updated successfully!'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'Error updating attendance details: ' . $conn->error
            ];
        }
    } else {
        $response = [
            'success' => false,
            'message' => 'No attendance record found for the given date.'
        ];
    }

    echo json_encode($response);
    exit();
}

function updateWorkingDaysBatch($movedToAbsent, $movedToPresent)
{
    global $conn;

    // Create case statements for moved interns
    $updateQuery = "UPDATE `internship_tbl` SET total_workingdays = CASE intern_id";

    if (!empty($movedToAbsent)) {
        foreach ($movedToAbsent as $internId) {
            $updateQuery .= " WHEN $internId THEN CONCAT(SUBSTRING_INDEX(total_workingdays, '/', 1) - 1, '/', SUBSTRING_INDEX(total_workingdays, '/', -1))";
        }
    }

    if (!empty($movedToPresent)) {
        foreach ($movedToPresent as $internId) {
            $updateQuery .= " WHEN $internId THEN CONCAT(SUBSTRING_INDEX(total_workingdays, '/', 1) + 1, '/', SUBSTRING_INDEX(total_workingdays, '/', -1))";
        }
    }

    // Add ELSE clause to avoid affecting other records
    $updateQuery .= " ELSE total_workingdays END WHERE intern_id IN (" . implode(",", array_merge($movedToAbsent, $movedToPresent)) . ")";

    // Execute the batch update query
    $conn->query($updateQuery);
}

?>
