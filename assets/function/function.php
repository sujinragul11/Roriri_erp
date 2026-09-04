<?php
function usernameExists($username) {
        global $conn;
        $sql = "SELECT COUNT(*) as count FROM basic_details WHERE username='$username';";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['count'] > 0;
    }

    function generateUniqueUsername($username, $dob) {
        $base_username = $username;
        $year_of_birth = date('Y', strtotime($dob));
        $day_of_birth = date('d', strtotime($dob));
        
        if (usernameExists($username)) {
            $username_with_year = $base_username . $year_of_birth;
    
            if (usernameExists($username_with_year)) {
                $username_with_date = $base_username . $year_of_birth . $day_of_birth;
    
                if (usernameExists($username_with_date)) {
                    // Generate a random number and append to username
                    $random_number = rand(100, 999); // Adjust the range as needed
                    $username = $base_username . $random_number;
                } else {
                    $username = $username_with_date;
                }
            } else {
                $username = $username_with_year;
            }
        }
    
        return $username;
    }
    //Create an employee Id 
    function generateNextEmployeeId() {
        global $conn;
        $sql = "SELECT MAX(reg_no) as max_id FROM additional_details WHERE entity_id=1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $last_id = $row['max_id'];
        if ($last_id === null) {
            return 180001; // Starting ID
        } else {
            return $last_id + 1;
        }
    }


    function generateRandomNumber($username) {
        $num = mt_rand(100, 999);
        return $num;
    }
    
    // Function to fetch position from the employee table based on role
    function position($role) {
        global $conn;
        $query = "SELECT role_name FROM roles WHERE role_id = '$role'";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['role_name'];
        }
        return null;
    }
    
    
    // Function to fetch user_id from the admin table based on emp_user_id
    function getUserIdFromAdmin($empId) {
        global $conn;
        $query = "SELECT username FROM basic_details WHERE id = '$empId'";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['username'];
        }
        return null;
    }
    
    // Function to get current image filename from employee table
    function getCurrentImageFilename($empId) {
        global $conn;
        $query = "SELECT image FROM additional_details WHERE basic_id = '$empId'";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['image'];
        }
        return null;
    }   
    
    //Create an Trainee Id 
    function generateNextTraineeId() {
        global $conn;
        $sql = "SELECT MAX(reg_no) as max_id FROM additional_details WHERE entity_id=3";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $last_id = $row['max_id'];
        if ($last_id === null) {
            return 170001; // Starting ID
        } else {
            return $last_id + 1;
        }
    }
    // Function to get current image filename from trinee table
    function getCurrentImageFilenameTrainee($traineeId) {
        global $conn;
        $query = "SELECT image FROM additional_details WHERE basic_id = '$traineeId'";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['image'];
        }
        return null;
    } 

//student id
    
     function generateNextStudentId() {
        global $conn;
        $sql = "SELECT MAX(reg_no) as max_id FROM additional_details WHERE entity_id=2";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $last_id = $row['max_id'];
        if ($last_id === null) {
            return 160001; // Starting ID
        } else {
            return $last_id + 1;
        }
    }

  // image filename from student table
  function getCurrentFilename($studId) {
    global $conn;
    $query = "SELECT image FROM additional_details WHERE basic_id = '$studId'";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['image'];
    }
    return null;
}   

  // Function to fetch user_id from the admin table based on emp_user_id
  function getUserIdFromAdmintbl($studid) {
    global $conn;
    $query = "SELECT username FROM basic_details WHERE id = '$studid'";
    $result = mysqli_query($conn,$query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['username'];
    }
    return null;
}
function getCurrentQrFilename($empId) {
    global $conn; // Assuming $conn is your database connection

    $query = "SELECT qr FROM additional_details WHERE basic_id = '$empId'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['qr']; // Return the QR code filename
    }

    return false; // Return false if no QR code is found
}

?>