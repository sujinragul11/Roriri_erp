<?php
include("../../db/dbConnection.php");
include("../../url.php");
session_start();


header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

//Handles Add the payment details 
if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'StudentPayment') {

    
    $pId=$_POST['payStudent'];
    $balance=$_POST['balance'];
    $date=$_POST['date'];
    $payMode=$_POST['payMode'];
    $receivedBy=$_POST['received'];
    $transId=$_POST['trans'];
    

    $insertPayment="INSERT INTO `payment`( `basic_id`, `entity_id`, `received_amnt`, `received_date`, `received_by`, `pay_method`, `tranx_id`) VALUES ('$pId','$entity_id','$balance','$date','$receivedBy','$payMode','$transId')";
    if ($conn->query($insertPayment) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Payment details added successfully!";
       
    } else {
        $response['message'] = "Unexpected error in adding Payment details! " . $conn->error;
    }
    echo json_encode($response);
    exit();

}

//Handles Fetching the payment details for viewing 
if (isset($_POST['studentPay']) && $_POST['studentPay'] != '') {
    $proId = $_POST['studentPay'];

    $projectName="SELECT b.*,
                           a.*,
                           c.*,
                           d.*,
                           IFNULL(SUM(d.received_amnt), 0) AS iniPay
                    FROM basic_details AS b
                    LEFT JOIN additional_details AS a ON a.basic_id = b.id
                    LEFT JOIN student_additional_details AS c ON c.basic_id = b.id
                    LEFT JOIN payment AS d ON d.basic_id = b.id
                    WHERE a.entity_id = '$entity_id' AND b.id = '$proId'";
    $fetchRes = mysqli_query($conn, $projectName);
    
    if ($fetchRes) {

        $row = mysqli_fetch_assoc($fetchRes);
        
        $projectDetails = array(
            'id' => $row['id'],
            'student_name' => $row['name'],
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



//Handles Updating the payment Details

if (isset($_POST['hdnAction']) && $_POST['hdnAction'] == 'editPayment') {
    $editPayId=$_POST['editPayId'];
    $paid=$_POST['balanceE'];
    $payModeE=$_POST['payModeE'];
    $dateE=$_POST['dateE'];
    $receivedE=$_POST['receivedE'];
    $payStatus=$_POST['payStatus'];
    $transE=$_POST['transE'];

        // Update Project details in database
        $editPay = "UPDATE `payment`
                    SET `received_amnt`='$paid',
                    `received_date`='$dateE',
                    `received_by`='$receivedE',
                    `pay_method`='$payModeE',
                    `pay_status`='$payStatus',
                    `tranx_id`='$transE' 
                    WHERE `pay_id`='$editPayId'";

                
                $editRes = mysqli_query($conn, $editPay);

            if ($editRes) {
                $_SESSION['message'] = "Payment details updated successfully!";
                $response['success'] = true;
                $response['message'] = "Payment details updated successfully!";
            } else {
                $response['success'] = false;
                $response['message'] = "Error updating database: " . mysqli_error($conn);
            }

            echo json_encode($response);
            exit();
        

}




//Handles Fetching the payment Detatils for editing

if(isset($_POST['editPayId']) && $_POST['editPayId']!=''){
    
    $payE=$_POST['editPayId'];

    $paySel="SELECT b.*,
                           a.*,
                           c.*,
                           d.*,
                           IFNULL(SUM(d.received_amnt), 0) AS iniPay
                    FROM basic_details AS b
                    LEFT JOIN additional_details AS a ON a.basic_id = b.id
                    LEFT JOIN student_additional_details AS c ON c.basic_id = b.id
                    LEFT JOIN payment AS d ON d.basic_id = b.id
                    WHERE a.entity_id = 2 AND d.pay_id = '$payE'";
    $fetchpay = mysqli_query($conn, $paySel);
    if($fetchpay){

        $rowPay=mysqli_fetch_array($fetchpay);

        $payDetails=array(
            'pay_amt_id'=>$rowPay['pay_id'],
            'pro_name'=>$rowPay['name'],
            'pay_status'=>$rowPay['pay_status'],
            'total_pay'=>$rowPay['course_fee'],
            'amnt_paid'=>$rowPay['received_amnt'],
            'receivedBy'=>$rowPay['received_by'],
            'date'=>$rowPay['received_date'],
            'payModeE'=>$rowPay['pay_method'],
            'transE'=>$rowPay['tranx_id'],
        );
        echo json_encode($payDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
    }

 




?>