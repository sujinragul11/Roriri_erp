<?php
session_start();
include("../db/dbConnection.php");

$razorpayPaymentId = $_POST['razorpay_payment_id'];
$razorpayOrderId = $_POST['razorpay_order_id'];
$amount = $_POST['amount'];
$id = $_POST['id'];
$food_id = $_POST['food_id'];
$date= date("Y-m-d");
$user_id = $_SESSION['id'] ;

// Assuming you have an `iv_payment_tbl` to store payments
$query = "INSERT INTO `iv_payment_tbl`(
                `visit_id`,
                `food_id`,
                `reason`,
                `amount`,
                `payment_method`,
                `razorpay_payment_id`,
                `razorpay_order_id`,
                `paid_date`,
                `pay_status`,
                `created_by`
            )
            VALUES('$id',
            '$food_id' ,
            'Food',
            '$amount',
            'RazorPay',
            '$razorpayPaymentId',
            '$razorpayOrderId',
            '$date',
            'Paid',
            '$user_id')";

if ($conn->query($query) === TRUE) {
    echo "Payment stored successfully.";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
