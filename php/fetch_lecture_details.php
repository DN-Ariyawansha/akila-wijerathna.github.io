<?php
// fetch_lecture_details.php

// Database connection details
$servername = "dinuwa.lk/999.tsd";
$username = "sql12728588";
$password = "wbrhtUq1KD";
$dbname = "sql12728588";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array('error' => 'Connection failed: ' . $conn->connect_error));
    exit;
}

// Fetch all lecture details
$sql = "SELECT * FROM class_links ORDER BY date DESC, time DESC";
if ($result = $conn->query($sql)) {
    $lectures = array();
    while ($row = $result->fetch_assoc()) {
        $lectures[] = array(
            'title' => $row['title'],
            'date' => $row['date'],
            'time' => $row['time'],
            'link' => $row['class_link']
        );
    }
    header('Content-Type: application/json');
    echo json_encode($lectures);
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(array('error' => 'Query failed: ' . $conn->error));
}

$conn->close();
?>
