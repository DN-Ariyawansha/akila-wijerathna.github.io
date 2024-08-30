<?php
// Database connection
$host = 'localhost'; // Change if different
$db = 'akila_sir';
$user = 'root'; // Change if different
$pass = ''; // Change if different

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$username = $_POST['username'];
$mobile_number = $_POST['mobile_number'];
$school = $_POST['school'];
$address = $_POST['address'];
$password = $_POST['password'];

// Insert into database
$sql = "INSERT INTO users (username, mobile_number, school, address, password) 
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssss', $username, $mobile_number, $school, $address, $password);

if ($stmt->execute()) {
    echo "Student added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
