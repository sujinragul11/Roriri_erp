<?php
session_start();
include("../../db/dbConnection.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// ---------------------------------------------------------------
// Client session guard for all portal actions
// ---------------------------------------------------------------
if (!isset($_SESSION['client_id'])) {
    $response['message'] = "Session expired. Please login again.";
    echo json_encode($response);
    exit();
}
$clientId = (int)$_SESSION['client_id'];

// ---------------------------------------------------------------
// Fetch the message thread (for auto-refresh)
// ---------------------------------------------------------------
if (isset($_GET['hdnAction']) && $_GET['hdnAction'] == 'fetchThread') {
    mysqli_query($conn, "UPDATE client_message_tbl SET is_read=1 WHERE client_id=$clientId AND sender='admin' AND is_read=0");
    $thread = [];
    $tQ = mysqli_query($conn, "SELECT sender, message, attachment_type, attachment_path, created_at FROM client_message_tbl WHERE client_id=$clientId ORDER BY msg_id ASC");
    if ($tQ) { while ($t = mysqli_fetch_assoc($tQ)) { $thread[] = $t; } }
    $response['success'] = true;
    $response['thread'] = $thread;
    echo json_encode($response);
    exit();
}

// ---------------------------------------------------------------
// Send a message to admin
// ---------------------------------------------------------------
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'sendMessage') {
    require_once dirname(__DIR__, 2) . '/RoririSoftware/action/chatAttachment.php';
    $message = trim($_POST['message']);
    $attachmentType = null;
    $attachmentPath = null;

    $hasFile = (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK);
    if ($hasFile) {
        $up = handleChatAttachmentUpload();
        if (!$up['success']) {
            $response['message'] = $up['message'];
            echo json_encode($response);
            exit();
        }
        $attachmentType = $up['type'];
        $attachmentPath = $up['path'];
    }

    if ($message === '' && $attachmentType === null) {
        $response['message'] = "Message cannot be empty.";
        echo json_encode($response);
        exit();
    }
    $stmt = $conn->prepare("INSERT INTO client_message_tbl (client_id, sender, message, attachment_type, attachment_path) VALUES (?, 'client', ?, ?, ?)");
    $stmt->bind_param("isss", $clientId, $message, $attachmentType, $attachmentPath);
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Message sent to admin.";
    } else {
        $response['message'] = "Error sending message: " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

// ---------------------------------------------------------------
// Submit a project requirement
// ---------------------------------------------------------------
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addRequirement') {
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);
    $budget = (isset($_POST['budget']) && $_POST['budget'] !== '') ? (float)$_POST['budget'] : null;

    if ($title === '' || $desc === '') {
        $response['message'] = "Title and description are required.";
        echo json_encode($response);
        exit();
    }
    $stmt = $conn->prepare("INSERT INTO client_project_req_tbl (client_id, project_title, description, budget) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issd", $clientId, $title, $desc, $budget);
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Project requirement submitted successfully.";
    } else {
        $response['message'] = "Error submitting requirement: " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

// ---------------------------------------------------------------
// Submit a client referral
// ---------------------------------------------------------------
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addReferral') {
    $name = trim($_POST['refName']);
    $phone = trim($_POST['refPhone']);
    $contact = $name . ($phone !== '' ? ' | ' . $phone : '');

    if ($name === '') {
        $response['message'] = "Referred client name is required.";
        echo json_encode($response);
        exit();
    }

    // Record pending referral (referred_client_id = 0 until admin adds the person as a client)
    $stmt = $conn->prepare("INSERT INTO client_referral_tbl (referring_client_id, referred_client_id, referred_name, points, status) VALUES (?, 0, ?, 0, 'Pending')");
    $stmt->bind_param("is", $clientId, $contact);
    if ($stmt->execute()) {
        // Notify admin through the message thread
        $stmt2 = $conn->prepare("INSERT INTO client_message_tbl (client_id, sender, message) VALUES (?, 'client', ?)");
        $note = "Referral submitted: " . $name . " (".$phone."). Please add them as a client (select me as 'Referred By') to credit my points.";
        $stmt2->bind_param("is", $clientId, $note);
        $stmt2->execute();
        $response['success'] = true;
        $response['message'] = "Referral submitted successfully! You'll earn 15 points once this client is added and gets a project.";
    } else {
        $response['message'] = "Error submitting referral: " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

// ---------------------------------------------------------------
// Change password (with old password verification)
// ---------------------------------------------------------------
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'changePassword') {
    $old = $_POST['oldPassword'];
    $new = $_POST['newPassword'];
    $confirm = $_POST['confirmPassword'];

    $meRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT client_password FROM client_tbl WHERE client_id=$clientId"));
    if (!$meRow) {
        $response['message'] = "Account not found.";
        echo json_encode($response);
        exit();
    }
    if ($meRow['client_password'] !== $old) {
        $response['message'] = "Your current password is incorrect.";
        echo json_encode($response);
        exit();
    }
    if (strlen($new) < 6) {
        $response['message'] = "New password must be at least 6 characters.";
        echo json_encode($response);
        exit();
    }
    if ($new !== $confirm) {
        $response['message'] = "New password and confirmation do not match.";
        echo json_encode($response);
        exit();
    }

    $stmt = $conn->prepare("UPDATE client_tbl SET client_password=? WHERE client_id=?");
    $stmt->bind_param("si", $new, $clientId);
    if ($stmt->execute()) {
        mysqli_query($conn, "INSERT INTO client_activity_tbl (client_id, action) VALUES ($clientId, 'Changed password')");
        $response['success'] = true;
        $response['message'] = "Password changed successfully. Please use your new password next login.";
    } else {
        $response['message'] = "Error changing password: " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

// ---------------------------------------------------------------
// Update profile (name/company/email/phone/location) - not username/password
// ---------------------------------------------------------------
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'updateProfile') {
    $pname = trim($_POST['pname']);
    $pcompany = trim($_POST['pcompany']);
    $pemail = trim($_POST['pemail']);
    $pphone = trim($_POST['pphone']);
    $plocation = trim($_POST['plocation']);

    if ($pname === '' || $pemail === '' || $pphone === '') {
        $response['message'] = "Name, email and phone are required.";
        echo json_encode($response);
        exit();
    }
    if (!filter_var($pemail, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = "Please enter a valid email address.";
        echo json_encode($response);
        exit();
    }
    $stmt = $conn->prepare("UPDATE client_tbl SET client_name=?, client_company=?, client_email=?, client_phone=?, client_location=? WHERE client_id=?");
    $stmt->bind_param("sssssi", $pname, $pcompany, $pemail, $pphone, $plocation, $clientId);
    if ($stmt->execute()) {
        $_SESSION['client_name'] = $pname;
        $_SESSION['client_company'] = $pcompany;
        mysqli_query($conn, "INSERT INTO client_activity_tbl (client_id, action) VALUES ($clientId, 'Updated profile')");
        $response['success'] = true;
        $response['message'] = "Profile updated successfully.";
    } else {
        $response['message'] = "Error updating profile: " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

// ---------------------------------------------------------------
// Raise a support ticket
// ---------------------------------------------------------------
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addTicket') {
    $subject = trim($_POST['subject']);
    $desc = trim($_POST['description']);
    $priority = (isset($_POST['priority']) && in_array($_POST['priority'], ['Low','Normal','High'])) ? $_POST['priority'] : 'Normal';

    if ($subject === '' || $desc === '') {
        $response['message'] = "Subject and description are required.";
        echo json_encode($response);
        exit();
    }
    $stmt = $conn->prepare("INSERT INTO client_support_tbl (client_id, subject, description, priority) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $clientId, $subject, $desc, $priority);
    if ($stmt->execute()) {
        mysqli_query($conn, "INSERT INTO client_activity_tbl (client_id, action) VALUES ($clientId, 'Raised support ticket')");
        $response['success'] = true;
        $response['message'] = "Support ticket raised successfully.";
    } else {
        $response['message'] = "Error raising ticket: " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

// ---------------------------------------------------------------
// Submit feedback
// ---------------------------------------------------------------
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addFeedback') {
    $rating = (isset($_POST['rating']) && $_POST['rating'] !== '') ? (int)$_POST['rating'] : null;
    $comments = trim($_POST['comments']);
    $projectId = (isset($_POST['projectId']) && $_POST['projectId'] !== '') ? (int)$_POST['projectId'] : null;

    if ($rating == null && $comments === '') {
        $response['message'] = "Please provide a rating or some comments.";
        echo json_encode($response);
        exit();
    }
    if ($rating !== null && ($rating < 1 || $rating > 5)) {
        $rating = null;
    }
    $stmt = $conn->prepare("INSERT INTO client_feedback_tbl (client_id, project_id, rating, comments) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $clientId, $projectId, $rating, $comments);
    if ($stmt->execute()) {
        mysqli_query($conn, "INSERT INTO client_activity_tbl (client_id, action) VALUES ($clientId, 'Submitted feedback')");
        $response['success'] = true;
        $response['message'] = "Thank you! Your feedback has been submitted.";
    } else {
        $response['message'] = "Error submitting feedback: " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

// ---------------------------------------------------------------
// Mark all notifications as read
// ---------------------------------------------------------------
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'markNotifsRead') {
    mysqli_query($conn, "UPDATE client_notification_tbl SET is_read=1 WHERE client_id=$clientId AND is_read=0");
    $response['success'] = true;
    echo json_encode($response);
    exit();
}

$response['message'] = "Unknown action.";
echo json_encode($response);
exit();
