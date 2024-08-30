<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "akila_sir";

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
