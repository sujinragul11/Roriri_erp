<?php



session_start();



include("../../db/dbConnection.php");

include("../../url.php");



if (isset($_POST['hdnAction']) && $_POST['hdnAction'] === 'addEnquiry') {

    // Retrieve values from the form

    $name = $_POST['name'];

    $phone = $_POST['phone'];

    $email = $_POST['email'];

    $category = $_POST['category'];

    $enquiryDate = $_POST['enquiryDate'];

    $experienceType = $_POST['experience_type'] ?? ''; // Might be empty for internships

    $description = $_POST['description'] ?? '';

    $address = $_POST['address'] ?? '';

    $followUpDate = $_POST['followUpDate'] ?? '';

    $followStatus = $_POST['followStatus'] ?? '';

    $comments = $_POST['comments'] ?? '';

    

    $collegeNameInternship = $_POST['college_name_internship'] ?? '';

    $passedOutYearInternship = $_POST['passed_out_year_internship'] ?? '';

    $degreeInternship = $_POST['degree_internship'] ?? '';

    $courseName = $_POST['course_name'] ?? '';

    $courseDuration = $_POST['course_duration'] ?? '';

    $courseMode = $_POST['course_mode'] ?? '';



    $collegeName = $_POST['college_name'] ?? ''; 

    $passedOutYear = $_POST['passed_out_year'] ?? ''; 

    $degree = $_POST['degree'] ?? ''; 

    $companyName = $_POST['company_name'] ?? ''; 

    $role = $_POST['role'] ?? ''; 

    echo $ctc = $_POST['ctc'] ?? ''; 



    $stmt = $conn->prepare("INSERT INTO allenquiry_tbl (enq_category_id, name, phone, email, enquiry_date, description, location, follow_up, comment, follow_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("isssssssss", $category, $name, $phone, $email, $enquiryDate, $description, $address, $followUpDate, $comments, $followStatus);

    

    if ($stmt->execute()) {

        // Get the last inserted event_id to use in the second table

        $eventId = $conn->insert_id;



        // Insert into enquiry_detail_tbl based on the selected category

        if ($category == 3) { // Internship category

            $stmt2 = $conn->prepare("INSERT INTO enquiry_detail_tbl (event_id, college_name, degree, passed_out) VALUES (?, ?, ?, ?)");

            $stmt2->bind_param("isss", $eventId, $collegeNameInternship, $degreeInternship, $passedOutYearInternship);

        } else if ($category == 4 || $category == 5) { // NexGen Nexemy

            $stmt2 = $conn->prepare("INSERT INTO enquiry_detail_tbl (event_id, academy_course, duration, mode) VALUES (?, ?, ?, ?)");

            $stmt2->bind_param("isss", $eventId, $courseName, $courseDuration, $courseMode);

        } else {

            // Other categories (Career Guidance/Jobathon)

            $stmt2 = $conn->prepare("INSERT INTO enquiry_detail_tbl (event_id, college_name, degree, passed_out, previous_company, role, ctc) VALUES (?, ?, ?, ?, ?, ?, ?)");

            $stmt2->bind_param("issssss", $eventId, $collegeName, $degree, $passedOutYear, $companyName, $role, $ctc);

        }

        

        if ($stmt2->execute()) {

            $response['success'] = true;

            $response['message'] = 'Enquiry details added successfully!';

        } else {

            $response['status'] = 'error';

            $response['message'] = 'Error adding to enquiry_detail_tbl: ' . $conn->error;

        }

        

        $stmt2->close();

    } 

    

    $stmt->close();

    echo json_encode($response);

    exit();

}


//Handles Fetching the Enquire details for editing 
if (isset($_POST['editIdEnquire']) && $_POST['editIdEnquire'] != '') {
    $editId = $_POST['editIdEnquire'];

    $enquireFetch="SELECT a.* ,b.* FROM `allenquiry_tbl` as a 
    LEFT JOIN `enquiry_detail_tbl` AS b ON a.event_id = b.event_id WHERE a.event_id ='$editId'";
    $fetchResult = mysqli_query($conn, $enquireFetch);
    
    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);
        
        $enquireDetails = array(
            'event_id' => $row['event_id'],
            'enq_category_id' => $row['enq_category_id'],
            'name' => $row['name'],
            'phone' => $row['phone'],
            'email' => $row['email'],
            'enquiry_date' => $row['enquiry_date'],
            'fee' => $row['fee'],
            'description' => $row['description'],
            'location' => $row['location'],
            'follow_up' => $row['follow_up'],
            'comment' => $row['comment'],
            'follow_status' => $row['follow_status'],
            'enq_student_tbl' => $row['enq_student_tbl'],
            'college_name' => $row['college_name'],
            'degree' => $row['degree'],
            'passed_out' => $row['passed_out'],
            'experience' => $row['experience'],
            'previous_company' => $row['previous_company'],
            'role' => $row['role'],
            'ctc' => $row['ctc'],
            'academy_course' => $row['academy_course'],
            'duration' => $row['duration'],
            'mode' => $row['mode'],
            'batch' => $row['batch'],


            
            

        );
        echo json_encode($enquireDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}





// edit form submit 



if (isset($_POST['hdnAction']) && $_POST['hdnAction'] === 'editEnquiry') {

    // Retrieve values from the form
    $enquiryId = $_POST['enquiryId']; // This should be provided in the form for editing
    $name = $_POST['editName'];
    $phone = $_POST['editPhone'];
    $email = $_POST['editEmail'];
    $category = $_POST['editCategory'];
    $enquiryDate = $_POST['editEnquiryDate'];
    $experienceType = $_POST['editExperienceType'] ?? ''; // Might be empty for internships
    $description = $_POST['editDescription'] ?? '';
    $address = $_POST['editAddress'] ?? '';
    $followUpDate = $_POST['editFollowUpDate'] ?? '';
    $followStatus = $_POST['editFollowStatus'] ?? '';
    $comments = $_POST['editComments'] ?? '';

    $collegeNameInternship = $_POST['editCollegeNameInternship'] ?? '';
    $passedOutYearInternship = $_POST['editPassedOutYearInternship'] ?? '';
    $degreeInternship = $_POST['editDegreeInternship'] ?? '';
    $courseName = $_POST['edit_course_name'] ?? '';
    $courseDuration = $_POST['edit_course_duration'] ?? '';
    $courseMode = $_POST['edit_course_mode'] ?? '';

    $collegeName = $_POST['editCollegeName'] ?? ''; 
    $passedOutYear = $_POST['editPassedOutYear'] ?? ''; 
    $degree = $_POST['editDegree'] ?? ''; 
    $companyName = $_POST['editCompanyName'] ?? ''; 
    $role = $_POST['editRole'] ?? ''; 
    $ctc = $_POST['editCTC'] ?? ''; 

    // Update the main enquiry table (allenquiry_tbl)
    $stmt = $conn->prepare("UPDATE allenquiry_tbl SET enq_category_id = ?, name = ?, phone = ?, email = ?, enquiry_date = ?, description = ?, location = ?, follow_up = ?, comment = ?, follow_status = ? WHERE event_id = ?");
    $stmt->bind_param("isssssssssi", $category, $name, $phone, $email, $enquiryDate, $description, $address, $followUpDate, $comments, $followStatus, $enquiryId);

    if ($stmt->execute()) {
        // Now update the associated details in enquiry_detail_tbl
        if ($category == 3) { // Internship category
            $stmt2 = $conn->prepare("UPDATE enquiry_detail_tbl SET college_name = ?, degree = ?, passed_out = ? WHERE event_id = ?");
            $stmt2->bind_param("sssi", $collegeNameInternship, $degreeInternship, $passedOutYearInternship, $enquiryId);
        } else if ($category == 4 || $category == 5) { // NexGen Nexemy
            $stmt2 = $conn->prepare("UPDATE enquiry_detail_tbl SET academy_course = ?, duration = ?, mode = ? WHERE event_id = ?");
            $stmt2->bind_param("sssi", $courseName, $courseDuration, $courseMode, $enquiryId);
        } else { // Other categories (Career Guidance/Jobathon)
            $stmt2 = $conn->prepare("UPDATE enquiry_detail_tbl SET college_name = ?, degree = ?, passed_out = ?, previous_company = ?, role = ?, ctc = ? WHERE event_id = ?");
            $stmt2->bind_param("ssssssi", $collegeName, $degree, $passedOutYear, $companyName, $role, $ctc, $enquiryId);
        }

        if ($stmt2->execute()) {
            $response['success'] = true;
            $response['message'] = 'Enquiry details updated successfully!';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error updating enquiry_detail_tbl: ' . $conn->error;
        }
        
        $stmt2->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error updating allenquiry_tbl: ' . $conn->error;
    }

    $stmt->close();

    echo json_encode($response);
    exit();
}



// view function 

//Handles Fetching the Enquire details for editing 
if (isset($_POST['event_id']) && $_POST['event_id'] != '') {
    $editId = $_POST['event_id'];

    $enquireFetch="SELECT a.* ,b.* ,c.category_name FROM `allenquiry_tbl` as a 
    LEFT JOIN `enquiry_detail_tbl` AS b ON a.event_id = b.event_id 
    LEFT JOIN `enq_category` AS c ON a.enq_category_id = c.enq_category_id WHERE a.event_id ='$editId';";
    $fetchResult = mysqli_query($conn, $enquireFetch);
    
    if ($fetchResult) {

        $row = mysqli_fetch_assoc($fetchResult);
        
        $enquireDetails = array(
            'event_id' => $row['event_id'],
            'category_name' => $row['category_name'],
            'name' => $row['name'],
            'phone' => $row['phone'],
            'email' => $row['email'],
            'enquiry_date' =>  date('d-m-Y', strtotime($row['enquiry_date'])),
            'fee' => $row['fee'],
            'description' => $row['description'],
            'location' => $row['location'],
            'follow_up' => $row['follow_up'],
            'comment' => $row['comment'],
            'follow_status' => $row['follow_status'],
            'enq_student_tbl' => $row['enq_student_tbl'],
            'college_name' => $row['college_name'],
            'degree' => $row['degree'],
            'passed_out' => $row['passed_out'],
            'experience' => $row['experience'],
            'previous_company' => $row['previous_company'],
            'role' => $row['role'],
            'ctc' => $row['ctc'],
            'academy_course' => $row['academy_course'],
            'duration' => $row['duration'],
            'mode' => $row['mode'],
            'batch' => $row['batch'],


            
            

        );
        echo json_encode($enquireDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}


//Handles Deleting the Enquiry

if (isset($_POST['deleteId'])) {
    $id = $_POST['deleteId'];
    $queryDel = "UPDATE allenquiry_tbl AS a
        LEFT JOIN enquiry_detail_tbl AS b ON a.event_id = b.event_id
        SET a.status = 'Inactive', b.status = 'Inactive'
        WHERE a.event_id = '$id';";
    $reDel = mysqli_query($conn, $queryDel);
    
    $response = []; // Initialize response array

    if ($reDel) {
        $_SESSION['message'] = "Enquiry details have been deleted successfully!";
        $response['success'] = true; // Set success to true
        $response['message'] = "Enquiry details have been deleted successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in deleting Enquiry details!";
        $response['success'] = false; // Set success to false on error
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    header('Content-Type: application/json'); // Ensure the correct content type
    echo json_encode($response);
    exit();
}



// filtter function 

//Handles Fetching the Enquire details for editing 
if ((isset($_POST['startDate']) && $_POST['startDate'] != '') || (isset($_POST['category']) && $_POST['category'] != '')) {
   // Get the POST data from AJAX
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$category = $_POST['category'];
// Initialize query with basic structure
$query = "SELECT
            a.event_id,
            b.category_name,
            a.name,
            a.phone,
            a.email,
            a.enquiry_date
          FROM
            allenquiry_tbl AS a
          LEFT JOIN enq_category AS b
            ON a.enq_category_id = b.enq_category_id
          WHERE a.status = 'Active'";

// Apply filters based on form inputs

if (!empty($_POST['startDate'])) {
    $startDate = mysqli_real_escape_string($conn, $_POST['startDate']);
    $query .= " AND a.enquiry_date >= '$startDate'";
}

if (!empty($_POST['endDate'])) {
    $endDate = mysqli_real_escape_string($conn, $_POST['endDate']);
    $query .= " AND a.enquiry_date <= '$endDate'";
}

if (!empty($_POST['category'])) {
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $query .= " AND b.category_name = '$category'";
}


// Execute query
$resQuery = mysqli_query($conn, $query);

// Check if any records exist
if (mysqli_num_rows($resQuery) > 0) {
    $i = 1;
    while($row = mysqli_fetch_array($resQuery, MYSQLI_ASSOC)) {
        $event_id = $row['event_id'];  
        $enq_category_name = $row['category_name'];   
        $name = $row['name'];  
        $email = $row['email'];  
        $phone = $row['phone'];
        $enquiry_date = date('d-m-Y', strtotime($row['enquiry_date']));
        echo "
        <tr>
            <td>{$i}</td>
            <td>" . htmlspecialchars($name) . "</td>
            <td>" . htmlspecialchars($phone) . "</td>
            <td>" . htmlspecialchars($email) . "</td>
            <td>" . htmlspecialchars($enq_category_name) . "</td>
            <td>" . htmlspecialchars($enquiry_date) . "</td>
            <td>
                <button class='btn btn-sm btn-outline-success' onclick='goViewEnquire({$event_id})'><i class='lni lni-eye'></i></button>
                <button class='btn btn-sm btn-outline-warning' onclick='goEditEnquire({$event_id})'><i class='lni lni-pencil'></i></button>
                <button class='btn btn-sm btn-outline-danger' onclick='goDeleteEnquire({$event_id})'><i class='lni lni-trash'></i></button>
            </td>
        </tr>";
        $i++;
    }
    } else {
        echo "<tr><td colspan='7'>No records found</td></tr>";
    }
}



?>