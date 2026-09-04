<?php
// include("C:\\xampp\\htdocs\\RORIRI_ERP\\db\\dbConnection.php");
include("../../db/dbConnection.php");
require_once __DIR__ . '/sendMail.php';
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

/* ---------------------------------------------
 * Helpers
 * ------------------------------------------- */
function generateClientUsername($conn, $name, $company) {
    // Base from company or name: lowercase + remove special chars/spaces
    $base = trim($name);
    if ($company !== '') { $base = trim($company); }
    $base = strtolower(preg_replace('/[^A-Za-z0-9]+/', '', $base));
    if ($base === '') { $base = 'client'; }
    $username = $base;
    $i = 1;
    // Ensure uniqueness
    while (true) {
        $qr = mysqli_query($conn, "SELECT client_id FROM client_tbl WHERE client_username='".mysqli_real_escape_string($conn, $username)."'");
        if ($qr && mysqli_num_rows($qr) === 0) { break; }
        $i++;
        $username = $base . $i;
    }
    return $username;
}

function generateClientPassword($length = 8) {
    $chars = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789';
    $pass = '';
    $max = strlen($chars) - 1;
    for ($i = 0; $i < $length; $i++) {
        $pass .= $chars[random_int(0, $max)];
    }
    return $pass;
}

// Credit referral points: 15 points = 1% of project amount
function creditReferralPoints($conn, $referredClientId, $projectAmount, $projectId) {
    $referringId = null;
    $q = mysqli_query($conn, "SELECT referred_by FROM client_tbl WHERE client_id=".(int)$referredClientId);
    if ($q && $r = mysqli_fetch_assoc($q)) { $referringId = $r['referred_by']; }
    if (!$referringId) { return false; }

    // Business rule: 15 points = 1% of the project amount
    $points = 15;

    // Update referring client points balance
    mysqli_query($conn, "UPDATE client_tbl SET client_points = client_points + ".(int)$points." WHERE client_id=".(int)$referringId);

    // Mark referral record credited
    mysqli_query($conn, "UPDATE client_referral_tbl SET points=".(int)$points.", status='Credited', credited_from_project_id=".(int)$projectId." WHERE referred_client_id=".(int)$referredClientId." AND status='Pending'");

    return true;
}

// Add Employee
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addClient') {

    $name=$_POST['Cname'];
    $compName=$_POST['compName'];
    $email=$_POST['cEmail'];
    $phone=$_POST['cPhone'];
    $gst=$_POST['gst'];
    $address=$_POST['cAddress'];

    // Use the username & password provided in the Add Client form
    $clientUsername = trim($_POST['Username']);
    $clientPassword = $_POST['Password'];

    if ($clientUsername === '' || $clientPassword === '') {
        $response['message'] = "Username and Password are required.";
        echo json_encode($response);
        exit();
    }

    // Ensure username is unique
    $ckUser = mysqli_query($conn, "SELECT client_id FROM client_tbl WHERE client_username='".mysqli_real_escape_string($conn, $clientUsername)."'");
    if ($ckUser && mysqli_num_rows($ckUser) > 0) {
        $response['message'] = "That username is already taken. Please choose a different one.";
        echo json_encode($response);
        exit();
    }

    // Optional referral from the add form (agent code / referred client id)
    $referredBy = (isset($_POST['referredBy']) && $_POST['referredBy'] !== '') ? (int)$_POST['referredBy'] : null;

    $insQuery="INSERT INTO `client_tbl`(`entity_id`, `client_name`, `client_company`, `client_location`, `client_email`, `client_phone`, `client_gst`, `client_username`, `client_password`, `referred_by`) VALUES (1,'".mysqli_real_escape_string($conn,$name)."','".mysqli_real_escape_string($conn,$compName)."','".mysqli_real_escape_string($conn,$address)."','".mysqli_real_escape_string($conn,$email)."','".mysqli_real_escape_string($conn,$phone)."','".mysqli_real_escape_string($conn,$gst)."','".mysqli_real_escape_string($conn,$clientUsername)."','".mysqli_real_escape_string($conn,$clientPassword)."', ".(($referredBy)?$referredBy:"NULL").")";

   if ($conn->query($insQuery) === TRUE) {
        $newClientId = $conn->insert_id;

        // Record the referral if this client was referred by another client
        if ($referredBy) {
            $refName = $name;
            mysqli_query($conn, "INSERT INTO client_referral_tbl (referring_client_id, referred_client_id, referred_name, points, status) VALUES ($referredBy, $newClientId, '".mysqli_real_escape_string($conn,$refName)."', 0, 'Pending')");
        }

        // Welcome notification + activity log
        mysqli_query($conn, "INSERT INTO client_notification_tbl (client_id, title, message, type) VALUES ($newClientId, 'Welcome to the Client Portal', 'Your account has been created. Please login with the username and password provided.', 'welcome')");
        mysqli_query($conn, "INSERT INTO client_activity_tbl (client_id, action) VALUES ($newClientId, 'Account created')");

        // Email credentials to the client
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            sendClientMail(
                $email,
                'Your Client Portal Login Credentials',
                clientCredentialEmailBody($name, $clientUsername, $clientPassword, 'http://localhost:8080/ClientPortal/login.php')
            );
        }

        $response['success'] = true;
        $response['message'] = "Clients details added successfully!";
        $response['username'] = $clientUsername;
        $response['password'] = $clientPassword;
        $response['client_id'] = $newClientId;
    } else {
    $response['message'] = "Unexpected error in adding Clients details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

//Handles Update the clients details
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'editClient') {

    $editName=$_POST['CnameE'];
    $editCID=$_POST['editIdClient'];
    $editComp=$_POST['compNameE'];
    $editGst=$_POST['gstE'];
    $editAddress=$_POST['cAddressE'];
    $editPhone=$_POST['cPhoneE'];
    $editEmail=$_POST['cEmailE'];

    $editUsername = trim($_POST['UsernameE']);
    $editPassword = $_POST['PasswordE'];

    if ($editUsername === '' || $editPassword === '') {
        $response['message'] = "Username and Password are required.";
        echo json_encode($response);
        exit();
    }

    // Ensure username is unique (excluding this client)
    $ckUser = mysqli_query($conn, "SELECT client_id FROM client_tbl WHERE client_username='".mysqli_real_escape_string($conn, $editUsername)."' AND client_id <> ".(int)$editCID);
    if ($ckUser && mysqli_num_rows($ckUser) > 0) {
        $response['message'] = "That username is already taken. Please choose a different one.";
        echo json_encode($response);
        exit();
    }

    // Check if credentials actually changed
    $oldRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT client_email, client_username, client_password FROM client_tbl WHERE client_id='".(int)$editCID."'"));
    $credsChanged = ($oldRow && ($oldRow['client_username'] !== $editUsername || $oldRow['client_password'] !== $editPassword));

    $UpdateClient="UPDATE `client_tbl`
    SET `entity_id`='1',
    `client_name`='$editName',
    `client_company`='$editComp',
    `client_location`='$editAddress',
    `client_email`='$editEmail',
    `client_phone`='$editPhone',
    `client_gst`='$editGst',
    `client_username`='".mysqli_real_escape_string($conn,$editUsername)."',
    `client_password`='".mysqli_real_escape_string($conn,$editPassword)."'
     WHERE `client_id`='$editCID'";

         $editResClient = mysqli_query($conn, $UpdateClient);

        if ($editResClient) {
            $_SESSION['message'] = "Client details updated successfully!";
            $response['success'] = true;
            $response['message'] = "Client details updated successfully!";

            // Log credentials notification if changed
            if ($credsChanged && $oldRow && !empty($oldRow['client_email'])) {
                mysqli_query($conn, "INSERT INTO client_notification_tbl (client_id, title, message, type) VALUES (".(int)$editCID.", 'Login credentials updated', 'Your login username/password were updated by the admin. Please use the new credentials to login.', 'credentials')");
                mysqli_query($conn, "INSERT INTO client_activity_tbl (client_id, action) VALUES (".(int)$editCID.", 'Admin updated login credentials')");
                $response['username'] = $editUsername;
                $response['password'] = $editPassword;

                // Email new credentials to the client
                if (filter_var($oldRow['client_email'], FILTER_VALIDATE_EMAIL)) {
                    sendClientMail(
                        $oldRow['client_email'],
                        'Your Client Portal Login Credentials Were Updated',
                        clientCredentialEmailBody($editName, $editUsername, $editPassword, 'http://localhost:8080/ClientPortal/login.php')
                    );
                }
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Error updating database: " . mysqli_error($conn);
        }
         
        echo json_encode($response);
        exit();

}



//Handles Fetching the Clients details for editing 
if (isset($_POST['editIdClient']) && $_POST['editIdClient'] != '') {
    $editId = $_POST['editIdClient'];

    $clientFetch="SELECT * FROM client_tbl WHERE client_id='$editId'";
    $fetchResult = mysqli_query($conn, $clientFetch);
    
    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);
        
        $clientDetails = array(
            'client_id' => $row['client_id'],
            'client_name' => $row['client_name'],
            'comp_name' => $row['client_company'],
            'address' => $row['client_location'],
            'email' => $row['client_email'],
            'phone' => $row['client_phone'],
            'gst' => $row['client_gst'],
            'username' => $row['client_username'],
            'password' => $row['client_password'],

        );
        echo json_encode($clientDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}
//Handles Deleting the client

if (isset($_POST['clientdeleteId'])) {
    $id = $_POST['clientdeleteId'];
    $queryDel = "UPDATE `client_tbl` SET client_status='Inactive'
    WHERE client_id='$id'";
    $reDel = mysqli_query($conn, $queryDel);

    if ($reDel) {
        $_SESSION['message'] = "Client details have been deleted successfully!";
        $response['success'] = true;
        $response['message'] = "Client details have been deleted successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in deleting Employee details!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}
