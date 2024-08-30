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

$id = $_GET['id']; // Get ID from query parameter

$sql = "DELETE FROM class_links WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Link deleted successfully";
} else {
    echo "Error deleting link: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
