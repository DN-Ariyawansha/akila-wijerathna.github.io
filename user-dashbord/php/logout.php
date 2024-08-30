<?php
session_start(); // Start the session

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

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Clear the session ID for this user
    $stmt = $conn->prepare("UPDATE users SET session_id = NULL WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    // Destroy the session
    session_unset();
    session_destroy();

    // Redirect to the login page
    header("Location: ../login.html");
    exit();
} else {
    // No user is logged in
    header("Location: ../login.html");
    exit();
}

// Close the database connection
$conn->close();
?>
