<?php
session_start();
include("../../db/dbConnection.php");
header('Content-Type: application/json');


$response = ['success' => false, 'message' => ''];

if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'addFood') {
    
    // Get the form data
    $category = $_POST['category'];
    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
    $price = $_POST['price'];
    $name = $_POST['name'];
    $id = $_SESSION['id'];
    
    // Handle the image file
    $image = $_FILES['image'];

    // Define a directory to store the uploaded image
    $targetDir = "../image/food/";
    $imageName = basename($image['name']);
    $targetFilePath = $targetDir . $imageName;

    // Check for allowed file types (e.g., jpg, png, gif)
    $allowedTypes = ['jpg', 'png', 'jpeg', 'gif'];
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Initialize response array
    $response = ['success' => false];

    if (in_array($fileType, $allowedTypes)) {
        // Attempt to move the uploaded file to the target directory
        if (move_uploaded_file($image['tmp_name'], $targetFilePath)) {
            
            // Prepare the SQL query to insert form data into the database
           // Prepare the SQL query to insert form data into the database
    // Prepare the SQL query to insert form data into the database
    $insertQuery = "CALL insert_food_package('$category', '$imageName', '$name', '$description', '$price', 'Active', '$id');";


           // Log the query for debugging
            error_log("SQL Query: $insertQuery");
            
         
                  try {
                // Execute the query
                if ($result = $conn->query($insertQuery)) {
                    // Fetch the message from the result set
                    $row = $result->fetch_assoc();
                    $response['success'] = true;
                    $response['message'] = $row['message']; // Use the message from the stored procedure
                } else {
                    // If the query does not execute as expected, throw an exception
                    throw new Exception("Error adding food package: " . $conn->error);
                }
            } catch (mysqli_sql_exception $e) {
                // Log the complete error message
                error_log("SQL Error: " . $e->getMessage());
                $response['success'] = false;
                $response['message'] = "An error occurred: " . $e->getMessage();
            }
               
        } else {
            $response['message'] = "Error uploading image file!";
        }
    } else {
        $response['message'] = "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
    }

    // Return the response as JSON
    echo json_encode($response);
    exit();
}




// edit function -----------------

  if (isset($_POST['food_edit']) && $_POST['food_edit'] !== '') {
    
        $id= $_POST['food_edit'];
        
      $query = "CALL select_food_package('$id', 'Active');"; 
                
    $result = $conn->query($query);
    
    $categories = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $categories =array(
             'id' => $row['id'],
             'category' => $row['category'],
             'image' => $row['image'],
             'name' => $row['name'],
             'discretion' => $row['discretion'],
             'price' => $row['price']
             
                
                );
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($categories);
    exit();
    } 
    
    
//---edit data submit function -------------------------

if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'editFood') {
    
    // Get the form data
    $food_id = $_POST['food_id'];
    $category = $_POST['category'];
    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
    $price = $_POST['price'];
    $name = $_POST['name'];
    $id = $_SESSION['id'];

    // Handle the image file
    $image = $_FILES['image'];
    $imageName = basename($image['name']);
    $imageUploaded = !empty($imageName);  // Check if an image was uploaded
    
    // Define a directory to store the uploaded image
    $targetDir = "../image/food/";
    $targetFilePath = $targetDir . $imageName;
    
    // Check for allowed file types (e.g., jpg, png, gif)
    $allowedTypes = ['jpg', 'png', 'jpeg', 'gif'];
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Initialize response array
    $response = ['success' => false];

    // Update logic if image is uploaded
    if ($imageUploaded) {
        if (in_array($fileType, $allowedTypes)) {
            // Attempt to move the uploaded file to the target directory
            if (move_uploaded_file($image['tmp_name'], $targetFilePath)) {
                // Prepare the SQL query to update with image
                $updateQuery = "CALL UpdateStatus('$food_id', 'Active', '$category', '$imageName', '$name', '$description', '$price');";
            } else {
                $response['message'] = "Error uploading image file!";
                echo json_encode($response);
                exit();
            }
        } else {
            $response['message'] = "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
            echo json_encode($response);
            exit();
        }
    } else {
        // If no image uploaded, omit the image field from the query
        $updateQuery = "CALL UpdateStatus('$food_id', 'Active', '$category', NULL, '$name', '$description', '$price');";
    }

    // Execute the update query
    if ($conn->query($updateQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Client details updated successfully!";
    } else {
        $response['message'] = "Unexpected error in updating client details! " . $conn->error;
    }

    echo json_encode($response);
    exit();
}


//--delete function -----------
if (isset($_POST['deleteId'])) {
    $id = $_POST['deleteId'];
    $queryDel = "CALL UpdateStatus('$id', NULL, NULL, NULL, NULL, NULL, NULL);";
    $reDel = mysqli_query($conn, $queryDel);

    if ($reDel) {
        $response['success'] = true;
        $response['message'] = "Food Package details have been deleted successfully!";
    } else {
        $_SESSION['message'] = "Unexpected error in deleting Employee details!";
        $response['message'] = "Error: " . mysqli_error($conn);
    }

    echo json_encode($response);
    exit();
}
 
 
 


?>