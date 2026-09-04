<?php
include("../../db/dbConnection.php");

$response = ['success' => false, 'message' => ''];

header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow only POST, GET, and OPTIONS requests
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Specify allowed headers

if (isset($_POST['category_id']) && isset($_POST['category_id']) != '') {
    $category_id = intval($_POST['category_id']);

    $query = "SELECT `subcat_id`, `name` FROM `expense_subcategory` WHERE `cat_id` = $category_id AND `status` = 'Active'";
    $result = $conn->query($query);

    $options = '<option value="">--Select SubCategory--</option>';
    while ($row = $result->fetch_assoc()) {
        $options .= '<option value="' . $row['subcat_id'] . '">' . htmlspecialchars($row['name']) . '</option>';
    }

    echo $options;
}

if (isset($_POST['expenseDate']) && $_POST['expenseDate'] != '') {

    $expDate = htmlspecialchars($_POST['expenseDate'], ENT_QUOTES, 'UTF-8');
    $catname = htmlspecialchars($_POST['categoryName'], ENT_QUOTES, 'UTF-8');
    $subname = htmlspecialchars($_POST['subCatName'], ENT_QUOTES, 'UTF-8');
    $recname = htmlspecialchars($_POST['receiverName'], ENT_QUOTES, 'UTF-8');
    $amount  = htmlspecialchars($_POST['amount'], ENT_QUOTES, 'UTF-8');
    $mode    = htmlspecialchars($_POST['mode'], ENT_QUOTES, 'UTF-8');
    $transId = htmlspecialchars($_POST['transcationId'], ENT_QUOTES, 'UTF-8');
    $descrip = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
    
    if (isset($_FILES['bill']) && $_FILES['bill']['error'] == 0) {
        date_default_timezone_set('Asia/Kolkata');
        $timestamp = date('dMyhis'); 

        $fileTmpName = $_FILES['bill']['tmp_name'];
        $fileName = 'bill_' . $timestamp . '.' . pathinfo($_FILES['bill']['name'], PATHINFO_EXTENSION);
        $targetDir = '../../../asset/ERP/ERP_image/ExpenseBill/';
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($fileTmpName, $targetFile)) {
            $billFileName = $fileName; 
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error uploading the bill file.']);
            exit();
        }
    } else {
        $billFileName = ''; 
    }
    
    $query = "INSERT INTO `expense_details`(
                    `sub_id`,
                    `cash_handler`,
                    `date`,
                    `amount`,
                    `bill`,
                    `description`,
                    `mode`,
                    `transaction_id`
                )
                VALUES(
                    '$subname',
                    '$recname',
                    '$expDate',
                    '$amount',
                    '$billFileName',
                    '$descrip',
                    '$mode',
                    '$transId'
                )";

    if ($conn->query($query) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Expense Details submitted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error submitting Expense: ' . $conn->error]);
    }
}

if (isset($_POST['expense_id']) && $_POST['expense_id'] != '') {
    $expense_id = $_POST['expense_id'];

      $editFetch = "SELECT
                        a.`expense_id`,
                        a.`sub_id`,
                        a.`cash_handler`,
                        a.`date`,
                        a.`amount`,
                        a.`bill`,
                        a.`description`,
                        a.`mode`,
                        a.`transaction_id`,
                        b.`cat_id`
                    FROM
                        `expense_details` AS a
                    LEFT JOIN 
                        `expense_subcategory` AS b
                    ON
                    	a.`sub_id` = b.`subcat_id`
                    WHERE
                        a.`expense_id` = '$expense_id'";
    $fetchResult = mysqli_query($conn, $editFetch);
    
    if ($fetchResult) {
        $row = mysqli_fetch_assoc($fetchResult);

        $expenseDetails = array(
            'id'        => $row['expense_id'],
            'catName'   => $row['cat_id'],
            'subName'   => $row['sub_id'],
            'date'      => $row['date'],
            'receiver'  => htmlspecialchars_decode($row['cash_handler'], ENT_QUOTES),
            'descript'  => htmlspecialchars_decode($row['description'], ENT_QUOTES),
            'bill'      => htmlspecialchars_decode($row['bill'], ENT_QUOTES),
            'transId'   => htmlspecialchars_decode($row['transaction_id'], ENT_QUOTES),
            'mode'      => $row['mode'],
            'amount'    => $row['amount']
        );
        echo json_encode($expenseDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}

if (isset($_POST['expenseDateEdit']) && $_POST['expenseDateEdit'] != '') {

    $expenId = htmlspecialchars($_POST['expenseId'], ENT_QUOTES, 'UTF-8');
    $expDate = htmlspecialchars($_POST['expenseDateEdit'], ENT_QUOTES, 'UTF-8');
    $catname = htmlspecialchars($_POST['categoryNameEdit'], ENT_QUOTES, 'UTF-8');
    $subname = htmlspecialchars($_POST['subCatNameEdit'], ENT_QUOTES, 'UTF-8');
    $recname = htmlspecialchars($_POST['receiverNameEdit'], ENT_QUOTES, 'UTF-8');
    $amount  = htmlspecialchars($_POST['amountEdit'], ENT_QUOTES, 'UTF-8');
    $mode    = htmlspecialchars($_POST['modeEdit'], ENT_QUOTES, 'UTF-8');
    $transId = htmlspecialchars($_POST['transcationIdEdit'], ENT_QUOTES, 'UTF-8');
    $descrip = htmlspecialchars($_POST['descriptionEdit'], ENT_QUOTES, 'UTF-8');
    
    if (isset($_FILES['billEdit']) && $_FILES['billEdit']['error'] == 0) {
        date_default_timezone_set('Asia/Kolkata');
        $timestamp = date('dMyhis'); 

        $fileTmpName = $_FILES['billEdit']['tmp_name'];
        $fileName = 'bill_' . $timestamp . '.' . pathinfo($_FILES['billEdit']['name'], PATHINFO_EXTENSION);
        $targetDir = '../../../asset/ERP/ERP_image/ExpenseBill/';
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($fileTmpName, $targetFile)) {
            $billFileName = $fileName; 
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error uploading the bill file.']);
            exit();
        }
    } else {
        $billFileName = ''; 
    }
    
    $editQuery = "UPDATE
                    `expense_details`
                SET
                    `sub_id` = '$subname',
                    `cash_handler` = '$recname',
                    `date` = '$expDate',
                    `amount` = '$amount',
                    `bill` = '$billFileName',
                    `description` = '$descrip',
                    `mode` = '$mode',
                    `transaction_id` = '$transId'
                WHERE
                    `expense_id` = '$expenId'";

    if ($conn->query($editQuery) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Expense Details updated successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating Expense details: ' . $conn->error]);
    }
}

if (isset($_POST['view_expId']) && $_POST['view_expId'] != '') {
    $expense_id = $_POST['view_expId'];

      $queryFetch = "SELECT
                        a.`expense_id`,
                        a.`sub_id`,
                        a.`cash_handler`,
                        a.`date`,
                        a.`amount`,
                        a.`bill`,
                        a.`description`,
                        a.`mode`,
                        a.`transaction_id`,
                        b.`name` AS subName,
                        c.`name` AS catName
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
                        a.`expense_id` = '$expense_id'";
    $fetchResult = mysqli_query($conn, $queryFetch);
    
    if ($fetchResult) {
        $row = mysqli_fetch_assoc($fetchResult);

        $expenseDetails = array(
            'id'        => $row['expense_id'],
            'catName'   => $row['catName'],
            'subName'   => $row['subName'],
            'date'      => (new DateTime($row['date']))->format('d M Y'),
            'receiver'  => htmlspecialchars_decode($row['cash_handler'], ENT_QUOTES),
            'descript'  => htmlspecialchars_decode($row['description'], ENT_QUOTES),
            'bill'      => htmlspecialchars_decode($row['bill'], ENT_QUOTES),
            'transId'   => htmlspecialchars_decode($row['transaction_id'], ENT_QUOTES),
            'mode'      => $row['mode'],
            'amount'    => $row['amount']
        );
        echo json_encode($expenseDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}

if (isset($_POST['delId']) && $_POST['delId'] != '') {
    
    $expenseId = $_POST['delId'];

    $deleteQuery = "UPDATE
                        `expense_details`
                    SET
                        `status` = 'Inactive'
                    WHERE
                        `expense_id` = '$expenseId'";

    if ($conn->query($deleteQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Expense details Deleted successfully!";
    } else {
        $response['message'] = "Unexpected error in deleting Expense details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

if (isset($_GET['description']) && $_GET['description'] != '') {
    
    $description = isset($_GET['description']) ? htmlspecialchars($_GET['description'], ENT_QUOTES) : '';
        
            // Build the base SQL query
            $filterquery = "SELECT
                                a.`expense_id`,
                                a.`sub_id`,
                                a.`cash_handler`,
                                DATE_FORMAT(a.`date`, '%d %b %Y') AS date,
                                a.`amount`,
                                a.`description`,
                                b.`name` AS subName,
                                c.`name` AS catName
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
                                a.`description` LIKE '%$description%' 
                            AND a.`status` = 'Active'";
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