<?php
include("../../db/dbConnection.php");

$response = ['success' => false, 'message' => ''];

header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); // Allow only POST, GET, and OPTIONS requests
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Specify allowed headers

if (isset($_POST['reason']) && $_POST['reason'] != '') {

    $reason     = htmlspecialchars($_POST['reason'], ENT_QUOTES, 'UTF-8');
    $priority   = htmlspecialchars($_POST['priority'], ENT_QUOTES, 'UTF-8');
    $amount     = htmlspecialchars($_POST['amount'], ENT_QUOTES, 'UTF-8');
    $descript   = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
    
    $query = "INSERT INTO `expense_future`(
                    `name`,
                    `amount`,
                    `priority`,
                    `description`
                )
                VALUES(
                    '$reason',
                    '$amount',
                    '$priority',
                    '$descript'
                )";

    if ($conn->query($query) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Future Expense Details submitted successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error submitting the Future Expense: ' . $conn->error]);
    }
}

if (isset($_POST['expense_id']) && $_POST['expense_id'] != '') {
    $expense_id = $_POST['expense_id'];

      $editFetch = "SELECT
                        `id`,
                        `name`,
                        `amount`,
                        `priority`,
                        `description`
                    FROM
                        `expense_future`
                    WHERE
                        `id` = '$expense_id'";
    $fetchResult = mysqli_query($conn, $editFetch);
    
    if ($fetchResult) {
        $row = mysqli_fetch_assoc($fetchResult);

        $expenseDetails = array(
            'id'        => $row['id'],
            'name'      => htmlspecialchars_decode($row['name'], ENT_QUOTES),
            'priority'  => htmlspecialchars_decode($row['priority'], ENT_QUOTES),
            'descript'  => htmlspecialchars_decode($row['description'], ENT_QUOTES),
            'amount'    => $row['amount']
        );
        echo json_encode($expenseDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}

if (isset($_POST['reasonEdit']) && $_POST['reasonEdit'] != '') {

    $expenId    = htmlspecialchars($_POST['expenseId'], ENT_QUOTES, 'UTF-8');
    $reason     = htmlspecialchars($_POST['reasonEdit'], ENT_QUOTES, 'UTF-8');
    $priority   = htmlspecialchars($_POST['priorityEdit'], ENT_QUOTES, 'UTF-8');
    $amount     = htmlspecialchars($_POST['amountEdit'], ENT_QUOTES, 'UTF-8');
    $descript   = htmlspecialchars($_POST['descriptionEdit'], ENT_QUOTES, 'UTF-8');
    
    $editQuery = "UPDATE
                    `expense_future`
                SET
                    `name` = '$reason',
                    `amount` = '$amount',
                    `priority` = '$priority',
                    `description` = '$descript'
                WHERE
                    `id` = '$expenId'";

    if ($conn->query($editQuery) === TRUE) {
        echo json_encode(['status' => 'success', 'message' => 'Future Expense Details updated successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating Future Expense details: ' . $conn->error]);
    }
}

if (isset($_POST['delId']) && $_POST['delId'] != '') {
    
    $expenseId = $_POST['delId'];

    $deleteQuery = "UPDATE
                        `expense_future`
                    SET
                        `status` = 'Inactive'
                    WHERE
                        `id` = '$expenseId'";

    if ($conn->query($deleteQuery) === TRUE) {
        $response['success'] = true;
        $response['message'] = "Future Expense details Deleted successfully!";
    } else {
        $response['message'] = "Unexpected error in deleting Future Expense details! " . $conn->error;
    }
    echo json_encode($response);
    exit();
}

?>