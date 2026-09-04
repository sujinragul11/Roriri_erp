<?php
require 'qrlib.php'; // Ensure this path is correct

// URL to redirect to
$id = $_GET['userid'];
    $url = "https://roririqr.roririsoft.com/user.php?userid=Roriri$id";


// File name for the QR code image
$qr_filename = $id.'_RoririQRCode.png';

// Generate QR code
QRcode::png($url, $qr_filename);

if(isset($id)){
    echo "<img src='$qr_filename'>";
}

echo "QR code generated successfully!";
?>
