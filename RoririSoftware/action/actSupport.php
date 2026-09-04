<?php

session_start();

include("../../db/dbConnection.php");
include("../../url.php");

if (isset($_POST['chatInput']) && $_POST['chatInput'] != '') {
    $message = htmlspecialchars($_POST['chatInput'], ENT_QUOTES, 'UTF-8');
    $internId = $_POST['internId'];
    $replyId = $_SESSION['id'];

    date_default_timezone_set('Asia/Kolkata');
    $currentDateTime = date('Y-m-d H:i:s');

    $sqlReply = "INSERT INTO `intern_support_tbl` (
                    `intern_id`,
                    `msg`,
                    `date_time`,
                    `reply_id`
                )
                VALUES (
                    '$internId',           
                    '$message',
                    '$currentDateTime',
                    '$replyId'
                )";

    $resultReply = mysqli_query($conn, $sqlReply);

    if ($resultReply) {
        echo json_encode(['status' => 'success', 'message' => 'Message sent successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send the message.']);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Get the intern_id from the request
    if (isset($_GET['intern_id'])) {
        $id = $_GET['intern_id'];
        // Fetch messages from the database
        $sql = "SELECT
                    a.sup_id,
                    a.intern_id,
                    a.msg,
                    a.reply_id,
                    a.date_time,
                    b.image,
                    c.name AS empName
                FROM
                    intern_support_tbl AS a
                LEFT JOIN `additional_details` AS b
                ON
                    a.reply_id = b.basic_id
                LEFT JOIN `basic_details` AS c
                ON
                    a.reply_id = c.id
                WHERE
                    a.intern_id = $id
                ORDER BY
                    a.sup_id ASC";
        $result = mysqli_query($conn, $sql);

        // Fetch user image
        $sql_img = "SELECT a.*, b.intern_course_name 
                    FROM internship_tbl AS a 
                    LEFT JOIN inter_course_tbl AS b 
                    ON a.inte_cou_id = b.inte_cou_id 
                    WHERE a.intern_id = $id";
        $result_img = mysqli_query($conn, $sql_img);
        $row_1 = mysqli_fetch_assoc($result_img);

        $user_image = !empty($row_1['image']) ? "https://asset.inforiya.in/ERP/ERP_image/Intern/" . $row_1['image'] : "https://asset.inforiya.in/ERP/ERP_image/Employee/download.png";

        // Initialize an array to store messages
        $messages = array();

        // Loop through the result and append each message to the array
        while ($row = mysqli_fetch_assoc($result)) {
            $default_image = !empty($row['image']) ? "https://asset.inforiya.in/ERP/ERP_image/Employee/" . $row['image'] : "https://asset.inforiya.in/ERP/ERP_image/Employee/download.png";
            $empName = ($row['reply_id'] == $_SESSION['id']) ? "You" : $row['empName'];
            $messages[] = array(
                'sup_id' => $row['sup_id'],
                'intern_id' => $row['intern_id'],
                'msg' => htmlspecialchars_decode($row['msg'], ENT_QUOTES),
                'reply_id' => $row['reply_id'],
                'empName' => $empName,
                'date_time' => $row['date_time'],
                'user_image' => $user_image,
                'admin_image' => $default_image,
            );
        }
        $update_sql = "UPDATE intern_support_tbl 
                       SET msg_status = 'read' 
                       WHERE intern_id = $id AND reply_id = 0";
        mysqli_query($conn, $update_sql);

        // Return messages as JSON
        echo json_encode($messages);

        // Close the database connection
        mysqli_close($conn);
    }
}

?>