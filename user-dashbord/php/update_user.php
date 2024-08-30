<?php
session_start(); // Start the session

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "akila_sir";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html"); // Redirect to login if not logged in
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form inputs
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];

    // Validate inputs
    if (!empty($username) && !empty($mobile) && !empty($address)) {
        // Prepare and bind
        if (!empty($password)) {
            // If a new password is provided, hash it
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET username = ?, password = ?, mobile_number = ?, address = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $username, $password, $mobile, $address, $user_id);
        } else {
            // If no new password is provided, don't update the password
            $stmt = $conn->prepare("UPDATE users SET username = ?, mobile_number = ?, address = ? WHERE id = ?");
            $stmt->bind_param("sssi", $username, $mobile, $address, $user_id);
        }

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('User information updated successfully.');</script>";
        } else {
            echo "<script>alert('Failed to update user information.');</script>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<script>alert('Please fill in all required fields.');</script>";
    }
}

// Close the database connection
$conn->close();

// Redirect to the dashboard or back to the edit page
header("Location: ../dashbord.php"); // Adjust as needed
exit();
?>
