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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $mobile_number = $_POST['mobile_number'];
    $school = $_POST['school'];
    $address = $_POST['address'];
    $password = $_POST['password']; // Note: Handle password securely (hashing)

    // Validate inputs
    if (empty($id) || empty($username) || empty($mobile_number) || empty($school) || empty($address) || empty($password)) {
        echo 'All fields are required.';
        exit;
    }

    // Prepare the update query
    $stmt = $conn->prepare("UPDATE users SET username = ?, mobile_number = ?, school = ?, address = ?, password = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $username, $mobile_number, $school, $address, $password, $id);

    if ($stmt->execute()) {
        echo 'User updated successfully!';
    } else {
        echo 'Error updating user: ' . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
