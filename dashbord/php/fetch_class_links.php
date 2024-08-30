<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "akila_sir";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM class_links";
$result = $conn->query($sql);

$class_links = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $class_links[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($class_links);

$conn->close();
?>
