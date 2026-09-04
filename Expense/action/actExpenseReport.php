<?php
session_start();

include("../../db/dbConnection.php");
include("../../url.php"); 
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

        if (isset($_GET['report_start_date']) || isset($_GET['end_date']) || isset($_GET['categoryFilter']) || isset($_GET['subCatFilter']) || isset($_GET['employeeFilter'])) {
            $start_date = isset($_GET['report_start_date']) ? $_GET['report_start_date'] : '';
            $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
            $categoryFilter = isset($_GET['categoryFilter']) ? $_GET['categoryFilter'] : '';
            $subCatFilter = isset($_GET['subCatFilter']) ? $_GET['subCatFilter'] : '';
            $employeeFilter = isset($_GET['employeeFilter']) ? $_GET['employeeFilter'] : '';

            $filterquery = "SELECT
                                a.`expense_id`,
                                a.`sub_id`,
                                a.`cash_handler`,
                                a.`date`,
                                a.`amount` AS received_amnt,
                                b.`name` AS subname,
                                c.`name` AS catname
                            FROM
                                `expense_details` AS a
                            LEFT JOIN 
                            	`expense_subcategory` AS b
                            ON
                                a.`sub_id` = b.`subcat_id`
                            LEFT JOIN 
                            	`expense_category` AS c
                            ON
                                b.`cat_id` = c.`cat_id`
                            WHERE
                                a.`status` = 'Active'"; 
            if (!empty($start_date)) {
                $filterquery .= " AND a.`date` >= '$start_date'";
            }
            if (!empty($end_date)) {
                $filterquery .= " AND a.`date` <= '$end_date'";
            }
            if (!empty($categoryFilter)) {
                $filterquery .= " AND b.`cat_id` = '$categoryFilter'";
            }
            if (!empty($subCatFilter)) {
                $filterquery .= " AND a.`sub_id` = '$subCatFilter'";
            }
            // if (!empty($employeeFilter)) {
            //     $filterquery .= " AND b.id = '$employeeFilter'";
            // }
            
            $filterquery .= " ORDER BY a.date DESC";
            $resFilter = mysqli_query($conn, $filterquery);
            
            $report = [];
        
            while ($row = mysqli_fetch_assoc($resFilter)) {
                $report[] = $row; 
            }
        
            header('Content-Type: application/json');
            echo json_encode($report);
            exit();
        }
        
?>
