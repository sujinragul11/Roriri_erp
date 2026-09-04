<?php
//Create an employee Id 
function generateNextTraineeId() {
    global $conn;
    $sql = "SELECT MAX(reg_no) as max_id FROM basic_details";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $last_id = $row['max_id'];
    if ($last_id === null) {
        return 17001; // Starting ID
    } else {
        return $last_id + 1;
    }
}


//--create user name only get ---------------
function userName($locID) {
    global $conn; // Assuming $conn is your database connection variable

    // Query to retrieve university name based on uni_id
    $loc_name = "SELECT `id`, `name`, `username`, `password`, `role` FROM `admin_tbl` WHERE id = $locID";

    // Execute the query
    $loc_result = $conn->query($loc_name);

    // Check if query was successful and there is a result
    if ($loc_result && $loc_result->num_rows > 0) {
        // Fetch the university name
        $loc = $loc_result->fetch_assoc();
        return $loc['name'];
    } else {
        // Query execution failed or no results found
        return "No location found with the given ID.";
    }
}


//--create trainer name only get ---------------
function trainerName($trainerId) {
    global $conn; // Assuming $conn is your database connection variable

    // Sanitize the input to prevent SQL injection
    $trainerId = mysqli_real_escape_string($conn, $trainerId);

    // Query to retrieve the name and role based on trainer ID
    $loc_name = "SELECT b.name, a.role 
                 FROM `additional_details` AS a 
                 LEFT JOIN `basic_details` AS b 
                 ON a.basic_id = b.id 
                 WHERE b.id = '$trainerId';";

    // Execute the query
    $loc_result = $conn->query($loc_name);

    // Check if the query was successful and there are results
    if ($loc_result) {
        // Fetch the row with name and role
        $loc = $loc_result->fetch_assoc();
        $role = $loc['role'];

        $trainerRoles = [1, 2, 3, 4, 5, 6, 7, 8, 9, 11, 12, 13, 14, 15, 16]; // Define the array of roles

        // Check if the role is one of the trainer roles and return the location name
        if (in_array($role, $trainerRoles)) {
            return $loc['name'];
        } else {
            return "-------"; // If role is not 6
        }
        
    } else {
        // Query execution failed or no results found
        // For debugging, return a more informative message
        return "Not Verified";
    }
}




?>