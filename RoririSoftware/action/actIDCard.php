<?php
session_start();
include("../../db/dbConnection.php");
include("../../url.php");  

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if (isset($_POST['idCardNo']) && $_POST['idCardNo'] != '') {

    $idCardNo = $_POST['idCardNo'];

    $checkQuery = "SELECT COUNT(*) AS count FROM `intern_idcard_tbl` WHERE `id_number` = '$idCardNo'";
    $result = $conn->query($checkQuery);
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        $response['success'] = false;
        $response['message'] = "The ID Card number already exists!";
    } else {
        $insQuery = "INSERT INTO `intern_idcard_tbl` (`id_number`) VALUES ('$idCardNo')";
        
        if ($conn->query($insQuery) === TRUE) {
            $response['success'] = true;
            $response['message'] = "ID Card details added successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "Error adding ID Card details: " . $conn->error;
        }
    }

    echo json_encode($response);
    exit();
}

if (isset($_POST['cardId']) && $_POST['cardId'] != '') {
    $cardId = $_POST['cardId'];

    $cardFetch = "SELECT
                    b.`track_id`,
                    a.`id_number`,
                    b.`intern_id`,
                    b.`issued_date`,
                    b.`returned_date`
                FROM
                    `intern_idcard_tbl` AS a
                LEFT JOIN
                    `idcard_track_tbl` AS b
                ON
                    a.`idcard_id` = b.`idcard_id`
                WHERE
                    a.`idcard_id` = '$cardId'
                ORDER BY
                    b.`track_id` DESC
                LIMIT 1";
                
    $fetchResult = mysqli_query($conn, $cardFetch);

    if ($fetchResult && mysqli_num_rows($fetchResult) > 0) {
        $row = mysqli_fetch_assoc($fetchResult);

        if ($row['returned_date'] === '0000-00-00') {
            $cardDetails = array(
                'id' => $row['track_id'],
                'cardNo' => $row['id_number'],
                'name' => $row['intern_id'],
                'issueDate' => $row['issued_date'],
                'returnDate' => $row['returned_date']
            );
        } else {
            $cardDetails = array(
                'cardNo' => $row['id_number']
            );
        }
    } else {
        $cardDetails = array(
            'cardNo' => $cardId 
        );
    }

    echo json_encode($cardDetails);
    exit();
}

if (isset($_POST['issueCardId']) && $_POST['issueCardId'] != '') {

    $idCardId   = $_POST['issueCardId'];
    $trackId    = $_POST['cardTrackId'];
    $internName = $_POST['internName'];
    $issueDate  = $_POST['issueDate'];
    $returnDate = $_POST['returnDate'];
    $userId     = $_SESSION['id'];

    if (empty($returnDate) || $returnDate === '0000-00-00') {
        $insertQuery = "INSERT INTO idcard_track_tbl (idcard_id, intern_id, issued_date, issued_by)
                        VALUES ('$idCardId', '$internName', '$issueDate', '$userId')";

        if (mysqli_query($conn, $insertQuery)) {
            $response['success'] = true;
            $response['message'] = "ID Card Issued successfully.";
        } else {
            $response['success'] = false;
            $response['message'] = "Error inserting data: " . mysqli_error($conn);
        }
    } else {
        $updateQuery = "UPDATE idcard_track_tbl
                        SET returned_date = '$returnDate', returned_to = '$userId'
                        WHERE track_id = '$trackId'";

        if (mysqli_query($conn, $updateQuery)) {
            $response['success'] = true;
            $response['message'] = "ID Card Returned successfully.";
        } else {
            $response['success'] = false;
            $response['message'] = "Error updating data: " . mysqli_error($conn);
        }
    }

    echo json_encode($response);
    exit();
}

if (isset($_POST['cardHistory']) && $_POST['cardHistory'] !== '') {
    $cardHistory = $_POST['cardHistory'];
    
    $pptFetch="SELECT
                    a.`track_id`,
                    b.`name`,
                    a.`issued_date`,
                    a.`returned_date`
                FROM
                    `idcard_track_tbl` AS a LEFT JOIN `internship_tbl` AS b ON a.`intern_id` = b.`intern_id`
                WHERE
                    a.`status` = 'Active' AND a.`idcard_id` = '$cardHistory'";
    $pptResult = mysqli_query($conn, $pptFetch);
    
    if ($pptResult) {
        $pptDetails = array(); 
        while ($row = mysqli_fetch_assoc($pptResult)) {
            $pptDetails[] = array(
                'id' => htmlspecialchars_decode($row['track_id'], ENT_QUOTES),
                'name' => htmlspecialchars_decode($row['name'], ENT_QUOTES),
                'issue' => !empty($row['issued_date']) && $row['issued_date'] !== '0000-00-00' ? date('d M Y', strtotime($row['issued_date'])) : null,
                'return' => !empty($row['returned_date']) && $row['returned_date'] !== '0000-00-00' ? date('d M Y', strtotime($row['returned_date'])) : "Not Returned"
            );
        }
        echo json_encode($pptDetails);
    } else {
        $response['message'] = "Error executing query: " . mysqli_error($conn);
        echo json_encode($response);
    }
    exit();
}

?>