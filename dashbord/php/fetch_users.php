<?php
header('Content-Type: application/json');

$servername = "sql12.freesqldatabase.com";
$username = "sql12728588";
$password = "wbrhtUq1KD";
$dbname = "sql12728588";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, username, mobile_number, school, address, password FROM users";
$result = $conn->query($sql);

$users = array();

if ($result->num_rows > 0) {
    // Fetch all rows
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Return the result as JSON
echo json_encode($users);

$conn->close();
?>
