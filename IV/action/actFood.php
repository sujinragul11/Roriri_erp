<?php
include("../../db/dbConnection.php");

header('Content-Type: application/json'); // Set content type to JSON

if (isset($_POST['iv_id'])) {
    $ivId = intval($_POST['iv_id']);
    $price =$_POST['price'];
    
    $query = "SELECT stu_count FROM `iv_details_tbl` WHERE `iv_id` = $ivId AND `status` ='Active';";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
       $amount = $row['stu_count'] * $price;
        
        echo json_encode ($amount);
    } else {
        echo json_encode("No amount found");
    }
}
?>
