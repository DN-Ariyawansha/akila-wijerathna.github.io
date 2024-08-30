<?php
header('Content-Type: application/json');

$servername = "sql12.freesqldatabase.com:3306";
$username = "sql12728588";
$password = "wbrhtUq1KD";
$dbname = "sql12728588";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM pdf_files";
$result = $conn->query($query);

$pdfFiles = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdfFiles[] = $row;
    }
}

echo json_encode($pdfFiles);

$conn->close();
?>
