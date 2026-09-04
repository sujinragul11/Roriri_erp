<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "db_roriri";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_GET['allDb'])){
// Fetch databases
$databasesResult = $conn->query("SHOW DATABASES");

$data = array();
if ($databasesResult->num_rows > 0) {
    $index = 1;
    while ($database = $databasesResult->fetch_assoc()) {
        $dbName = $database['Database'];
        $data[] = array($index, $dbName);
        $index++;
    }
}

// Close connection
$conn->close();

// Output the data in JSON format
echo json_encode(array("data" => $data));
exit();
}

if (isset($_GET['db'])) {
    $db = $_GET['db'];

    // Validate the database name to avoid SQL injection
    if (preg_match('/^[a-zA-Z0-9_]+$/', $db)) {
        // Select the specified database
        $conn->select_db($db);

        // Fetch tables from the specified database
        $databasesResult = $conn->query("SHOW TABLES");

        $data = array();
        if ($databasesResult->num_rows > 0) {
            $index = 1;
            while ($table = $databasesResult->fetch_row()) {
                $tableName = $table[0];
                $data[] = array($index, $tableName);
                $index++;
            }
        } else {
            $data = []; // No tables found
        }

        // Output the data in JSON format
        echo json_encode(array("data" => $data));
    } else {
        // Invalid database name
        echo json_encode(array("error" => "Invalid database name"));
    }

    // Close connection
    $conn->close();
    exit();
}



if (isset($_GET['tableDb']) && isset($_GET['table'])) {
    $db = $_GET['tableDb'];
    $table = $_GET['table'];

    // Validate inputs to avoid SQL injection
    if (preg_match('/^[a-zA-Z0-9_]+$/', $db) && preg_match('/^[a-zA-Z0-9_]+$/', $table)) {
        // Select the specified database
        $conn->select_db($db);

        // Fetch column names
        $columnsQuery = "SHOW COLUMNS FROM $table";
        $columnsResult = $conn->query($columnsQuery);

        $columns = [];
        if ($columnsResult->num_rows > 0) {
            while ($row = $columnsResult->fetch_assoc()) {
                $columns[] = $row['Field']; // Collect column names
            }
        }

        // Fetch data from the specified table
        $dataQuery = "SELECT * FROM $table";
        $dataResult = $conn->query($dataQuery);

        $data = [];
        if ($dataResult->num_rows > 0) {
            while ($row = $dataResult->fetch_assoc()) {
                $data[] = $row; // Collect data rows
            }
        }

        // Combine columns and data into one array
        $response = [
            'columns' => $columns,
            'data' => $data
        ];

        // Output the data in JSON format
        echo json_encode($response);
    } else {
        // Invalid inputs
        echo json_encode(array("error" => "Invalid database or table name"));
    }

    // Close connection
    $conn->close();
    exit();
}

?>
