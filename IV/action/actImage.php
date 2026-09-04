<?php
if ($_FILES['file']) {
    $targetDir = "../images/upload/";  // Directory to save the uploaded file
    $targetFile = $targetDir . basename($_FILES["file"]["name"]);
    
    // Move the uploaded file to the desired directory
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        echo json_encode(["message" => "File uploaded successfully", "file" => $targetFile]);
    } else {
        echo json_encode(["message" => "Error uploading file"]);
    }
} else {
    echo json_encode(["message" => "No file received"]);
}
?>
