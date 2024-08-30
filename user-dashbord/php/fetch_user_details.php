<?php
session_start(); // Ensure session is started to access session variables



$servername = "sql12.freesqldatabase.com:3306";
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

// Check if the user is logged in and has a session variable
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user details based on user_id
    $sql = "SELECT username, mobile_number, school, address FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        header('Content-Type: application/json');
        echo json_encode($row);
    } else {
        header('Content-Type: application/json');
        echo json_encode(array('error' => 'User not found.'));
    }

    $stmt->close();
} else {
    http_response_code(401); // Unauthorized
    echo json_encode(array('error' => 'User not logged in.'));
}

$conn->close();
?>
