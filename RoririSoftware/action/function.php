
<?php
function formatDate($date) {
		// Create a DateTime object from the input date
		$dateObject = new DateTime($date);
		
		// Format the date as "day month year"
		return $dateObject->format('d M Y');
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