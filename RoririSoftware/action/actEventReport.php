<?php

session_start();

include("../../db/dbConnection.php");
include("../../url.php");
header('Content-Type: application/json');

// ADD new event/meeting report
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] === 'addDepartment') {
    $category     = $_POST['category'] ?? '';
    $subcategory  = $_POST['subcategory'] ?? '';
    $participants = $_POST['participants'] ?? '';
    $hours        = $_POST['hours'] ?? 0;
    $guest        = $_POST['guest'] ?? '';
    $description  = $_POST['description'] ?? '';
    $projectStatus= $_POST['projectStatus'] ?? '';
    $place        = $_POST['place'] ?? '';
    $eventDate    = $_POST['eventDate'] ?? '';
    $createdBy    = $_SESSION['id'];

    $category     = htmlspecialchars($category, ENT_QUOTES, 'UTF-8');
    $subcategory  = htmlspecialchars($subcategory, ENT_QUOTES, 'UTF-8');
    $guest        = htmlspecialchars($guest, ENT_QUOTES, 'UTF-8');
    $description  = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
    $place        = htmlspecialchars($place, ENT_QUOTES, 'UTF-8');

    if (empty($eventDate)) {
        $eventDate = date('Y-m-d');
    }

    $insQuery = "INSERT INTO `event_report_tbl`
                    (`category`, `subcategory`, `participants`, `hours`, `guest`, `description`, `place`, `event_status`, `event_date`, `created_by`)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($insQuery);
    $stmt->bind_param("sssdsssssi", $category, $subcategory, $participants, $hours, $guest, $description, $place, $projectStatus, $eventDate, $createdBy);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => "Event / Meeting added successfully!"]);
    } else {
        echo json_encode(['success' => false, 'message' => "Error adding Event: " . $conn->error]);
    }
    exit();
}

// EDIT existing event/meeting report
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] === 'editDepartment') {
    $id           = $_POST['editReportId'] ?? '';
    $category     = $_POST['categoryEdit'] ?? '';
    $subcategory  = $_POST['subcategoryEdit'] ?? '';
    $participants = $_POST['participantsEdit'] ?? '';
    $hours        = $_POST['hoursEdit'] ?? 0;
    $guest        = $_POST['guestEdit'] ?? '';
    $description  = $_POST['descriptionEdit'] ?? '';
    $projectStatus= $_POST['projectStatusEdit'] ?? '';
    $place        = $_POST['placeEdit'] ?? '';
    $eventDate    = $_POST['eventDateEdit'] ?? '';

    $category     = htmlspecialchars($category, ENT_QUOTES, 'UTF-8');
    $subcategory  = htmlspecialchars($subcategory, ENT_QUOTES, 'UTF-8');
    $guest        = htmlspecialchars($guest, ENT_QUOTES, 'UTF-8');
    $description  = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');
    $place        = htmlspecialchars($place, ENT_QUOTES, 'UTF-8');

    $updateQuery = "UPDATE `event_report_tbl`
                    SET `category` = ?, `subcategory` = ?, `participants` = ?, `hours` = ?, `guest` = ?,
                        `description` = ?, `place` = ?, `event_status` = ?, `event_date` = ?
                    WHERE `id` = ?";

    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssdsssssi", $category, $subcategory, $participants, $hours, $guest, $description, $place, $projectStatus, $eventDate, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => "Event / Meeting updated successfully!"]);
    } else {
        echo json_encode(['success' => false, 'message' => "Error updating Event: " . $conn->error]);
    }
    exit();
}

// VIEW - fetch single event by id
if (isset($_POST['viewIdEvent']) && $_POST['viewIdEvent'] != '') {
    $id = intval($_POST['viewIdEvent']);

    $query = "SELECT id, category, subcategory, participants, hours, guest, description, place, event_status, event_date
              FROM `event_report_tbl` WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();
    if ($row) {
        $row['description'] = html_entity_decode($row['description']);
        $row['event_date']  = $row['event_date'] ? date('d-M-Y', strtotime($row['event_date'])) : '----';
        echo json_encode($row);
    } else {
        echo json_encode(['success' => false, 'message' => 'No record found.']);
    }
    exit();
}

// DELETE - soft delete an event by id
if (isset($_POST['deleteIdEvent']) && $_POST['deleteIdEvent'] != '') {
    $id = intval($_POST['deleteIdEvent']);

    $query = "UPDATE `event_report_tbl` SET `status` = 'Inactive' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Event deleted successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete event.']);
    }
    exit();
}
