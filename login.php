<?php
session_start();
include("db/dbConnection.php");

if (isset($_REQUEST['logout'])) {
    session_destroy();
    header("Location: login.php");
}
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $locationName = $_POST['location_name'];
    $systemInfo = $_POST['system_info'];
    date_default_timezone_set('Asia/Kolkata');
    $loginTime = date('Y-m-d h:i:s A');
    // Get the current host
    $host = $_SERVER['HTTP_HOST'];

    // Optional local-only role switch for testing:
    // login.php?portal=erp|employee|intern on localhost
    // (portal=employee -> entity 1, portal=intern -> entity 3)
    $isLocal = ($host === 'localhost' || $host === '127.0.0.1' || str_starts_with($host, 'localhost:'));
    $portal = isset($_GET['portal']) ? strtolower(trim($_GET['portal'])) : '';

    // Define entity IDs based on host names
    $entity_id = 0; // Default to 0 or any value you prefer
    if ($host === 'trainee.roririsoft.com') { 
        $entity_id = 3; // Host A corresponds to entity ID 3
    } elseif ($host === 'workforce.roririsoft.com') {
        $entity_id = 1; // Host B corresponds to entity ID 1
    } elseif ($host === 'erp.roririsoft.com' || $isLocal) {
        // Locally, an explicit portal param overrides the default admin-only mode
        if ($isLocal && $portal === 'employee') {
            $entity_id = 1;
        } elseif ($isLocal && $portal === 'intern') {
            $entity_id = 3;
        } else {
            $entity_id = '';
        }
    } // Add more host conditions if needed

    // SQL query to fetch user details
    $sql = "SELECT basic_details.*, roles.*, additional_details.* 
            FROM basic_details 
            LEFT JOIN additional_details ON additional_details.basic_id = basic_details.id 
            LEFT JOIN roles ON roles.role_id = additional_details.role 
            WHERE basic_details.username = '$username' 
            AND basic_details.password = '$password'"; 
    
    if ($entity_id == '') {
        $sql .= " AND EXISTS (SELECT 1 FROM admin_tbl WHERE username = basic_details.username)";
    } else {
        $sql .= " AND additional_details.entity_id = '$entity_id'";
    }
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user = $row['username'];
        $pass = $row['password'];
        $role_name = $row['role_name'];
        $role = $row['role'];
        $entity_id = $row['entity_id'];
        $is_admin = $row['is_admin']; 
        $userId = $row['id'];
        $course_id_1 = $row['course_id'];
        $name = $row['name'];

        // Set session variables
        $_SESSION['role'] = $role;
        $_SESSION['username'] = $user;
        $_SESSION['password'] = $pass;
        $_SESSION['role_name'] = $role_name;
        $_SESSION['id'] = $userId;
        $_SESSION['entity_id'] = $entity_id;
        $_SESSION['is_admin'] = $is_admin;
        $_SESSION['name'] = $name;
        $_SESSION['course_id_1'] = $course_id_1;

       // Store login data in JSON format
$loginData = [
    'location' => $locationName,   // Assuming $locationName contains the location
    'system_info' => $systemInfo,  // Assuming $systemInfo contains system information
    'login_time' => $loginTime     // Assuming $loginTime contains the login time
];

// First, check if the user already has a row in the login_history table
$stmt = $conn->prepare("SELECT system_info FROM login_history WHERE basic_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Row exists, fetch the existing system_info
    $stmt->bind_result($existingSystemInfo);
    $stmt->fetch();
    
    // Decode the existing system_info JSON into an array
    $existingDataArray = json_decode($existingSystemInfo, true);

    // If there's no data or it's not an array, create a new array
    if (!is_array($existingDataArray)) {
        $existingDataArray = [];
    }

    // Append the new login data as a new JSON object in the array
    $existingDataArray[] = $loginData;

    // Encode the updated array back to JSON
    $updatedSystemInfo = json_encode($existingDataArray);

    // Update the row with the new combined data
    $updateStmt = $conn->prepare("UPDATE login_history SET system_info = ? WHERE basic_id = ?");
    $updateStmt->bind_param("si", $updatedSystemInfo, $userId);
    
    if ($updateStmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $updateStmt->error;
    }

    // Close update statement
    $updateStmt->close();

} else {
    // No row exists, insert a new record with the new login data in JSON format
    $newLoginDataArray = [];
    $newLoginDataArray[] = $loginData;  // Add the first login data entry to the array

    // Encode the array into JSON format
    $jsonData = json_encode($newLoginDataArray);

    // Insert the new data
    $insertStmt = $conn->prepare("INSERT INTO login_history (basic_id, system_info) VALUES (?, ?)");
    $insertStmt->bind_param("is", $userId, $jsonData);
    
    if ($insertStmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error inserting record: " . $insertStmt->error;
    }

    // Close insert statement
    $insertStmt->close();
}

// Close select statement
$stmt->close();
        if ($entity_id == '') {
            $sqlAdmin = "SELECT role FROM `admin_tbl` WHERE `username` = '$user'";
            $resAdmin = $conn->query($sqlAdmin);
            
                if ($resAdmin->num_rows > 0) {
                    $rowAdmin = $resAdmin->fetch_assoc();
                    $_SESSION['role_name'] = $rowAdmin['role'];
                    
                    header('Location: index.php');
                    exit();
                }
        } elseif ($entity_id == 1) { 
            $sqlEmp = "SELECT * FROM `basic_details` 
            INNER JOIN `additional_details` ON `additional_details`.`basic_id` = `basic_details`.`id` 
            WHERE `basic_details`.`id` = '$userId'";
        
            $resEmp = $conn->query($sqlEmp);
        
            if ($resEmp->num_rows > 0) {
                $rowEmp = $resEmp->fetch_assoc();
                $_SESSION['image'] = $rowEmp['image'];
                header('Location: RoririSoftware/employeeDetails.php?id=' .  $userId);
                exit; 
            }
        } elseif ($entity_id == 2) { 
            // Student
            $sqlStu = "SELECT * FROM `basic_details` 
            INNER JOIN `additional_details` ON `additional_details`.`basic_id` = `basic_details`.`id` 
            WHERE `basic_details`.`id` = '$userId'";
            $resStudent = $conn->query($sqlStu);
            if ($resStudent->num_rows > 0) {
                header('Location:NexGen_IT_College/studentDetail.php?id=' . $userId);
                exit();
            }
        } elseif ($entity_id == 3) { 
            // Trainee
            $sqlTrainee = "SELECT * FROM `basic_details` 
            INNER JOIN `additional_details` ON `additional_details`.`basic_id` = `basic_details`.`id` 
            WHERE `basic_details`.`id` = '$userId'";
            $resTrainee = $conn->query($sqlTrainee);
            if ($resTrainee->num_rows > 0) {
                $rowTrainee = $resTrainee->fetch_assoc();
                $trainee_id = $rowTrainee['id'];
                $course_id = $rowTrainee['course'];
                $_SESSION['trainee_id'] = $trainee_id;
                header('Location:NexGen_IT_Academy/index.php');
                exit();
            }
        } else {
            echo 'Invalid entity ID.';
        }
    } else {
        $_SESSION['msg'] = "Invalid username or password.";
        header("Location: login.php");
        exit();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
    <!--plugins-->
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet" />
    <script src="assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
    <link href="assets/css/icons.css" rel="stylesheet">
    <title>RORIRI Software Solutions</title>
    <style>
        #error-message {
            display: none;
            color: red;
        }
        .error {
            display: block;
        }
        .device-type {
            display: none;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="section-authentication-cover">
            <div class="">
                <div class="row g-0">
                    <div class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex">
                        <div class="card shadow-none bg-transparent shadow-none rounded-0 mb-0">
                            <div class="card-body">
                                <img src="assets/images/login-images/login-cover.svg" class="img-fluid auth-img-cover-login" width="650" alt=""/>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
                        <div class="card rounded-0 m-3 shadow-none bg-transparent mb-0">
                            <div class="card-body p-sm-5">
                                <div class="">
                                    <div class="mb-3 text-center">
                                        <img src="assets/images/login-images/logo.png" id="logo" width="170" alt="">
                                    </div>
                                    <div class="text-center mb-4">
                                        <h5 class="">Login</h5>
                                    </div>
                                    <div class="form-body">
                                        <?php if(isset($_SESSION['msg'])) { ?>
                                            <div class="alert alert-danger">
                                                <?php echo $_SESSION['msg']; session_unset(); ?>
                                            </div>
                                        <?php } ?>
                                        <form class="row g-3" action="" method="POST">
                                            <input type="hidden" id="locationName" name="location_name">
                                            <input type="hidden" id="systemInfo" name="system_info">
                                            <div class="col-12">
                                                <label for="inputEmailAddress" class="form-label">Username</label>
                                                <input type="text" class="form-control" name="username" id="inputEmailAddress" placeholder="Username" value="<?php echo isset($_REQUEST['username']) ? $_REQUEST['username'] : ''; ?>">
                                            </div>
                                            <div class="col-12">
                                                <label for="inputChoosePassword" class="form-label">Password</label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" class="form-control border-end-0" name="password" id="inputChoosePassword" placeholder="Enter Password" value="<?php echo isset($_REQUEST['password']) ? $_REQUEST['password'] : ''; ?>">
                                                    <a href="javascript:;" class="input-group-text bg-transparent"><i class="bx bx-hide"></i></a>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary">Login</button>
                                                </div>
                                            </div>
                                        </form>
                                        <div id='message'><?php echo $error ?? ''; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <!-- Password show & hide js -->
<script>
    $(document).ready(function () {
    $("#show_hide_password a").on('click', function (event) {
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") === "text") {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("bx-hide");
            $('#show_hide_password i').removeClass("bx-show");
        } else if ($('#show_hide_password input').attr("type") === "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("bx-hide");
            $('#show_hide_password i').addClass("bx-show");
        }
    });

    function getDeviceType() {
        if (/Mobi|Android/i.test(navigator.userAgent)) {
            return 'Mobile';
        } else if (/Tablet|iPad/i.test(navigator.userAgent)) {
            return 'Tablet';
        } else {
            return 'Desktop';
        }
    }

    function getSystemInfo() {
        const userAgent = navigator.userAgent;
        const language = navigator.language || navigator.userLanguage;
        const screenWidth = screen.width;
        const screenHeight = screen.height;
        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        const deviceType = getDeviceType();

        return {
            userAgent,
            language,
            screenWidth,
            screenHeight,
            timezone,
            deviceType
        };
    }

    function updateLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        } else {
            console.error('Geolocation is not supported by this browser.');
        }
    }

    function successCallback(position) {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;
        const url = `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                console.log('Geocoding API Response:', data); // Log the full response
                if (data && data.display_name) {
                    document.getElementById('locationName').value = data.display_name;
                } else {
                    document.getElementById('locationName').value = 'Unknown location';
                }
            })
            .catch(error => {
                console.error('Error fetching location:', error);
                document.getElementById('locationName').value = 'Unknown location';
            });
    }

    function errorCallback(error) {
        console.error('Error getting geolocation:', error);
        document.getElementById('locationName').value = 'Unknown location';
    }

    updateLocation();

    const systemInfo = getSystemInfo();
    document.getElementById('systemInfo').value = JSON.stringify(systemInfo);
});

$(document).ready(function() {
    // Define logo paths
    const defaultLogo = "assets/images/login-images/logo.png";
    const traineeLogo = "assets/images/login-images/nexgenlogo.png"; 

    // Check if the hostname is 'trainee.roririsoft.com'
    if (window.location.hostname === "trainee.roririsoft.com") {
        console.log("Trainee site detected, applying trainee logo."); // Debugging message
        $("#logo").attr("src", traineeLogo);
    } else {
        console.log("Default site detected, applying default logo."); // Debugging message
        $("#logo").attr("src", defaultLogo);
    }
});
</script>
</body>
</html>
