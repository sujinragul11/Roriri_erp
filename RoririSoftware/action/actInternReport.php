<?php
include("../../db/dbConnection.php");
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if (isset($_GET['report_start_date']) || isset($_GET['end_date'])) {
            $start_date = isset($_GET['report_start_date']) ? $_GET['report_start_date'] : '';
            $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

            // Build the base SQL query
            $filterquery = "SELECT
                                a.`inter_paym_id`,
                                a.`intern_id`,
                                a.`inter_amount`,
                                a.`tranx_id`,
                                a.`received_date`,
                                a.`pay_mode`,
                                a.`pay_balance`,
                                a.`received_by`,
                                b.`name` AS `intern_name`,
                                c.`name` AS `receiver_name`
                            FROM
                                `intern_payment` AS a
                            LEFT JOIN 
                            	`internship_tbl` AS b
                            ON
                                a.`intern_id` = b.`intern_id`
                            LEFT JOIN 
                            	`basic_details` AS c
                            ON
                                a.`received_by` = c.`id`
                            WHERE
                                a.`status` = 'Active'"; 
        
            if (!empty($start_date)) {
                $filterquery .= " AND a.`received_date` >= '$start_date'";
            }
            if (!empty($end_date)) {
                $filterquery .= " AND a.`received_date` <= '$end_date'";
            }
            $filterquery .= " ORDER BY a.`received_date` DESC";
            $resFilter = mysqli_query($conn, $filterquery);
            
            $assets = [];
        
            while ($row = mysqli_fetch_assoc($resFilter)) {
                $assets[] = $row; // Collect the data
            }
        
            header('Content-Type: application/json');
            echo json_encode($assets);
            exit();
        }
        
        ?>
