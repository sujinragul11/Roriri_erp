<?php

session_start();
include("db/dbConnection.php");

 if (isset($_POST['password']) && $_POST['password'] !== '') {
            $id     = $_SESSION['id'];
            $pass   = $_POST['password'];
    
            $editQuery="UPDATE `basic_details` SET `password`='$pass' WHERE `id`='$id'";
            
            $editRes = mysqli_query($conn, $editQuery);
            if ($editRes) {
              $_SESSION['password'] = $pass;
              $response['success'] = true;
              $response['message'] = "Password  updated successfully!";
              $response['newPassword'] = $pass; 
          } else {
              $response['success'] = false;
              $response['message'] = "Error updating database: " . mysqli_error($conn);
          }
        
          echo json_encode($response);
          exit();
          }
?>