<?php
session_start();
include("../../db/dbConnection.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

function logAdminAction($conn, $clientId, $action) {
    mysqli_query($conn, "INSERT INTO client_activity_tbl (client_id, action) VALUES (".(int)$clientId.", '".mysqli_real_escape_string($conn, $action)."')");
}

// Admin sends a message to a client (text and/or image/voice attachment)
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'adminSendMessage') {
    require_once __DIR__ . '/chatAttachment.php';
    $clientId = (int)$_POST['clientId'];
    $message = trim($_POST['message']);
    $attachmentType = null;
    $attachmentPath = null;

    $hasFile = (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK);
    if ($hasFile) {
        $up = handleChatAttachmentUpload();
        if (!$up['success']) {
            $response['message'] = $up['message'];
            echo json_encode($response); exit();
        }
        $attachmentType = $up['type'];
        $attachmentPath = $up['path'];
    }

    if ($message === '' && $attachmentType === null) {
        $response['message'] = "Message cannot be empty.";
        echo json_encode($response); exit();
    }

    $stmt = $conn->prepare("INSERT INTO client_message_tbl (client_id, sender, message, attachment_type, attachment_path) VALUES (?, 'admin', ?, ?, ?)");
    $stmt->bind_param("isss", $clientId, $message, $attachmentType, $attachmentPath);
    if ($stmt->execute()) {
        $typeLabel = ($attachmentType == 'image') ? 'sent an image' : (($attachmentType == 'voice') ? 'sent a voice note' : 'sent a message');
        mysqli_query($conn, "INSERT INTO client_notification_tbl (client_id, title, message, type) VALUES ($clientId, 'New message from admin', 'You have a new message from the admin.', 'message')");
        logAdminAction($conn, $clientId, 'Admin ' . $typeLabel);
        $response['success'] = true;
        $response['message'] = "Message sent to client.";
    } else {
        $response['message'] = "Error sending message: " . $conn->error;
    }
    echo json_encode($response); exit();
}

// Update requirement status
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'updateRequirement') {
    $reqId = (int)$_POST['reqId'];
    $status = in_array($_POST['status'], ['Pending','Approved','Rejected','In Progress']) ? $_POST['status'] : 'Pending';
    $reqRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT client_id, project_title FROM client_project_req_tbl WHERE req_id=$reqId"));
    if ($reqRow) {
        if (mysqli_query($conn, "UPDATE client_project_req_tbl SET status='$status' WHERE req_id=$reqId")) {
            mysqli_query($conn, "INSERT INTO client_notification_tbl (client_id, title, message, type) VALUES (".(int)$reqRow['client_id'].", 'Requirement status updated', 'Your requirement \"".mysqli_real_escape_string($conn, $reqRow['project_title'])."\" is now ".$status.".', 'requirement')");
            logAdminAction($conn, (int)$reqRow['client_id'], 'Admin updated requirement status to '.$status);
            $response['success'] = true;
            $response['message'] = "Requirement updated.";
        } else {
            $response['message'] = "Error: " . mysqli_error($conn);
        }
    } else {
        $response['message'] = "Requirement not found.";
    }
    echo json_encode($response); exit();
}

// Adjust client points (credit/debit)
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'adjustPoints') {
    $clientId = (int)$_POST['clientId'];
    $points = (int)$_POST['points'];
    $reason = trim($_POST['reason']);
    if ($points == 0) { $response['message'] = "Points cannot be zero."; echo json_encode($response); exit(); }
    $sign = ($points > 0) ? '+' : '-';
    $abs = abs($points);
    if (mysqli_query($conn, "UPDATE client_tbl SET client_points = client_points " . $sign . " $abs WHERE client_id=$clientId")) {
        mysqli_query($conn, "INSERT INTO client_notification_tbl (client_id, title, message, type) VALUES ($clientId, 'Points updated', 'Your points balance was updated by the admin (".($points>0?'+':'')."$points point".(abs($points)==1?'':'s')."). ".($reason!==''?mysqli_real_escape_string($conn,$reason):'')."', 'points')");
        logAdminAction($conn, $clientId, 'Admin adjusted points by '.$points);
        $response['success'] = true;
        $response['message'] = "Points updated.";
    } else {
        $response['message'] = "Error: " . mysqli_error($conn);
    }
    echo json_encode($response); exit();
}

// Update support ticket (reply / close)
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'updateTicket') {
    $ticketId = (int)$_POST['ticketId'];
    $reply = trim($_POST['reply']);
    $status = (isset($_POST['status']) && in_array($_POST['status'], ['Open','In Progress','Closed'])) ? $_POST['status'] : 'Open';
    $tRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT client_id, subject FROM client_support_tbl WHERE ticket_id=$ticketId"));
    if ($tRow) {
        $replyEsc = mysqli_real_escape_string($conn, $reply);
        if (mysqli_query($conn, "UPDATE client_support_tbl SET admin_reply='$replyEsc', status='$status' WHERE ticket_id=$ticketId")) {
            if ($reply !== '') {
                mysqli_query($conn, "INSERT INTO client_notification_tbl (client_id, title, message, type) VALUES (".(int)$tRow['client_id'].", 'Support ticket updated', 'Your ticket \"".mysqli_real_escape_string($conn, $tRow['subject'])."\" has a reply (status: $status).', 'support')");
                logAdminAction($conn, (int)$tRow['client_id'], 'Admin replied to ticket '.$ticketId);
            }
            $response['success'] = true;
            $response['message'] = "Ticket updated.";
        } else {
            $response['message'] = "Error: " . mysqli_error($conn);
        }
    } else {
        $response['message'] = "Ticket not found.";
    }
    echo json_encode($response); exit();
}

$response['message'] = "Unknown action.";
echo json_encode($response);
