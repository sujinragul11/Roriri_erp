<?php
session_start();

include("../../db/dbConnection.php");
include("../../url.php"); 
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

        if (isset($_GET['report_start_date']) || isset($_GET['end_date']) || isset($_GET['durationFilter']) || isset($_GET['courseFilter']) || isset($_GET['traineeFilter'])) {
            $start_date = isset($_GET['report_start_date']) ? $_GET['report_start_date'] : '';
            $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
            $durationFilter = isset($_GET['durationFilter']) ? $_GET['durationFilter'] : '';
            $courseFilter = isset($_GET['courseFilter']) ? $_GET['courseFilter'] : '';
            $traineeFilter = isset($_GET['traineeFilter']) ? $_GET['traineeFilter'] : '';

            $filterquery = "SELECT
                                a.`pay_id`,
                                a.`basic_id`,
                                b.`name` AS `basic_name`,       
                                a.`received_amnt`,
                                a.`received_date`,
                                a.`pay_method`,
                                a.`pay_status`,
                                a.`received_by`,
                                c.`name` AS `receiver_name` 
                            FROM
                                `payment` AS a
                            LEFT JOIN 
                                `basic_details` AS b
                            ON
                                a.`basic_id` = b.`id`
                            LEFT JOIN 
                                `basic_details` AS c
                            ON
                                a.`received_by` = c.`id`
                            LEFT JOIN 
                                `trainee_additional_details` AS d
                            ON
                                b.`id` = d.`basic_id`
                            WHERE
                                a.`status` = 'Active'"; 
            if (!empty($start_date)) {
                $filterquery .= " AND a.received_date >= '$start_date'";
            }
            if (!empty($end_date)) {
                $filterquery .= " AND a.received_date <= '$end_date'";
            }
            if (!empty($durationFilter)) {
                $filterquery .= " AND d.duration = '$durationFilter'";
            }
            if (!empty($courseFilter)) {
                $filterquery .= " AND d.course_id = '$courseFilter'";
            }
            if (!empty($traineeFilter)) {
                $filterquery .= " AND b.id = '$traineeFilter'";
            }
            
            $filterquery .= " ORDER BY a.received_date DESC";
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
