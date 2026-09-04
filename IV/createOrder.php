<?php
require('vendor/razorpay/razorpay/Razorpay.php');
use Razorpay\Api\Api;

$apiKey = "rzp_test_sYDXizFjDxb4Vw";
$apiSecret = "mWbFEV0lUB2Mzp71x57wZSw2";

$api = new Api($apiKey, $apiSecret);

$amount = $_POST['amount']; // Amount in paise

$orderData = [
    'receipt' => uniqid(),
    'amount' => $amount, // amount in paise
    'currency' => 'INR',
    'payment_capture' => 1
];

$order = $api->order->create($orderData);

echo $order['id'];
?>
