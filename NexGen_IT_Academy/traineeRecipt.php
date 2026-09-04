<?php
session_start();
include("../db/dbConnection.php"); // Include your DB connection file
require('../pdf/fpdf.php');
header('Content-Type: text/html; charset=UTF-8'); // Ensure UTF-8 encoding

// Get payment ID from URL
$paymentId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch payment details from the database
$query = $conn->prepare("SELECT
                        a.pay_id,
                        a.received_amnt,
                        a.received_date,
                        a.pay_method,
                        a.pay_status,
                        a.tranx_id,
                        b.name,
                        a.balance,
                        d.course_name
                    FROM payment AS a
                    LEFT JOIN basic_details AS b ON a.basic_id = b.id
                    LEFT JOIN trainee_additional_details AS c ON b.id = c.basic_id 
                    LEFT JOIN academy_course_details AS d ON c.course_id = d.id   
                    WHERE a.pay_id = ?");
                    
$query->bind_param("i", $paymentId);
$query->execute();
$result = $query->get_result();
$paymentDetails = $result->fetch_assoc();

if (!$paymentDetails) {
    die("Payment not found.");
}

// Create FPDF object with custom "off" A4 size
$pdf = new FPDF('P', 'mm', [205, 292]); // Set width to 205mm and height to 292mm
$pdf->AddPage();

// Add company logo on the top left
$pdf->Image('../Internship/assets/images/logo/favicon.png', 10, 10, 40); // Adjust the path and size as needed

// Company Name (replace with actual company details)
$pdf->SetFont('Arial', 'B', 18);
$pdf->SetXY(25, 20);
$pdf->Cell(190, 10, 'RORIRI SOFTWARE SOLUTIONS PVT.LTD.', 0, 1, 'C'); // Company Name
$pdf->SetFont('Arial', '', 12);
$pdf->SetXY(25, 30);
$pdf->Cell(190, 6, 'RORIRI IT PARK, NALLANATHAPURAM, Kalakkad, Keela', 0, 1, 'C');
$pdf->SetXY(25, 37);
$pdf->Cell(190, 6, 'Karuvelankulam, Tamil Nadu 627502', 0, 1, 'C');
$pdf->Ln(10);

// Title of Receipt
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 10, 'Payment Receipt', 0, 1, 'C');
$pdf->Ln(5);

// Student Details Table Section
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(100, 10, 'Course Name :', 0, 1);
$pdf->SetXY(50, 68);
$pdf->SetFont('Arial', '', 14);
$pdf->Cell(100, 10, $paymentDetails['course_name'], 0, 0);
$pdf->SetXY(130, 68);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(30, 10, 'Student Name :', 0, 0, 'R'); 
$pdf->SetXY(160, 68);
$pdf->SetFont('Arial', '', 14);
$pdf->MultiCell(0, 10, $paymentDetails['name'], 0, 'L');
// Display the date cell
$receivedDate = date("d-M-Y", strtotime($paymentDetails['received_date']));
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(37, 10, 'Date                :', 0, 0, 'C'); // Label
$pdf->SetFont('helvetica', '', 14);
$pdf->Cell(35, 10, $receivedDate, 0, 1, 'C'); // Date value
$pdf->Ln(5);

$balance = $paymentDetails['balance']; // Replace this with your actual balance value

// Set font for the headers
$pdf->SetFont('Arial', 'B', 12); // Bold for headers
$pdf->Cell(60, 10, 'Description', 1, 0, 'C'); // Description header with border
$pdf->Cell(70, 10, 'Method', 1, 0, 'C');      // Method header with border
$pdf->Cell(60, 10, 'Amount', 1, 1, 'C');      // Amount header with border

// Display the description, method, and amount with borders to form a table row
$pdf->SetFont('Arial', '', 12); // Normal font for data
$pdf->Cell(60, 10, 'Fees', 1, 0, 'C');  // Description content with border
$pdf->Cell(70, 10, htmlspecialchars($paymentDetails['pay_method']), 1, 0, 'C');  // Method content with border
$pdf->Cell(60, 10, 'Rs. ' . number_format($paymentDetails['received_amnt'], 2), 1, 1, 'R');  // Amount content with border

// Add some space after this row


// Display total row with borders
$pdf->SetFont('Arial', 'B', 12); // Bold for total
$pdf->Cell(60, 10, '', 0, 0, 'C');  // Empty cell for alignment
$pdf->Cell(70, 10, 'Total', 0, 0, 'R'); // Total label with border
$pdf->Cell(60, 10, 'Rs. ' . number_format($paymentDetails['received_amnt'], 2), 0, 1, 'R'); // Total amount with border


// Display balance row with borders
$pdf->SetFont('Arial', '', 12); // Normal font for balance
$pdf->Cell(60, 10, '', 0, 0, 'C');  // Empty cell for alignment
$pdf->Cell(70, 10, 'Balance', 0, 0, 'R'); // Balance label with border
$pdf->Cell(60, 10, 'Rs. ' . number_format($balance, 2), 0, 1, 'R'); // Balance amount with border
$pdf->Ln(8);
// Footer Section
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, 'Thank you for your payment!', 0, 1, 'C');

// Output the PDF
$pdf->Output('I', 'Receipt_' . $paymentId . '.pdf');
?>
