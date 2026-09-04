<?php
include("../../db/dbConnection.php");
include("../../url.php");
session_start();


header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

//Handles Add the payment details 
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'TraineePayment') {
    $pId = $_POST['TraineePay'];
    $balance = $_POST['balance'];
    $remaining = $_POST['remaining'];
    $total_balance = $remaining - $balance ;
    $date = $_POST['date'];
    $payMode = $_POST['payMode'];
    $receivedBy = $_SESSION['id'];
    $transId = $_POST['trans'];
    $entity = 3; // or assign the correct entity ID

    // Log variables
    error_log("PayTrainee: $pId, Balance: $balance, Date: $date, Pay Mode: $payMode, Received By: $receivedBy, Trans ID: $transId");

    $insertPayment = "INSERT INTO `payment`( `basic_id`, `entity_id`, `received_amnt`, `received_date`, `received_by`, `pay_method`, `tranx_id` ,`balance`) 
                      VALUES ('$pId','$entity','$balance','$date','$receivedBy','$payMode','$transId' ,'$total_balance')";

    // Log the query
    error_log($insertPayment);

    if ($conn->query($insertPayment) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Payment details added successfully!";
    } else {
        $response['success'] = false;
        $response['message'] = "Unexpected error in adding Payment details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

//Handles Fetching the payment details for viewing 
if (isset($_POST['TraineePay']) && $_POST['TraineePay'] != '') {
    $proId = $_POST['TraineePay'];

    $projectName = "SELECT b.*,
                           a.*,
                           c.*,
                           d.*,
                           IFNULL(SUM(d.received_amnt), 0) AS iniPay
                    FROM basic_details AS b
                    LEFT JOIN additional_details AS a ON a.basic_id = b.id
                    LEFT JOIN trainee_additional_details AS c ON c.basic_id = b.id
                    LEFT JOIN payment AS d ON d.basic_id = b.id
                    WHERE a.entity_id = '$entity' AND b.id = '$proId'";
                    
    $fetchRes = mysqli_query($conn, $projectName);
    
    if ($fetchRes) {
        $row = mysqli_fetch_assoc($fetchRes);

    //    var_dump($row);
    //    exit;
     
        $projectDetails = array(
            'id' => $row['id'],
            'Trainee_name' => $row['name'],
            'charge' => $row['course_fee'],
            'iniPay'=>$row['iniPay']
            
        );
        echo json_encode($projectDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}