<?php


function userNameOnly($ids) {
    global $conn; // Ensure the connection is available

    // Split IDs into an array
    $idsArray = explode(', ', $ids);

    // Escape IDs for safe SQL usage
    $escapedIds = array_map(function($id) use ($conn) {
        return mysqli_real_escape_string($conn, $id);
    }, $idsArray);

    // Join IDs for the SQL query
    $idsString = "'" . implode("', '", $escapedIds) . "'";

    // Query to get names based on IDs
    $query = "SELECT id, name FROM basic_details WHERE id IN ($idsString)";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $names = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $names[] = $row['name'];
        }
        return implode(', ', $names); // Return names as a comma-separated list
    } else {
        return "Error fetching names";
    }
}


//--trainer name get -----------------------
function userTrainerOnly($ids) {
    global $conn; // Ensure the connection is available

    // Split IDs into an array
    $idsArray = explode(', ', $ids);

    // Escape IDs for safe SQL usage
    $escapedIds = array_map(function($id) use ($conn) {
        return mysqli_real_escape_string($conn, $id);
    }, $idsArray);

    // Join IDs for the SQL query
    $idsString = "'" . implode("', '", $escapedIds) . "'";

    // Query to get names based on IDs
    $query = "SELECT id, name FROM basic_details WHERE id IN ($idsString)";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $names = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $names[] = $row['name'];
        }
        return implode(', ', $names); // Return names as a comma-separated list
    } else {
        return "Error fetching names";
    }
}