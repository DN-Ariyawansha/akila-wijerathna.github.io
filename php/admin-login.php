<?php
// Start the session
session_start();

// Database credentials
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the inputs are not empty
    if (!empty($username) && !empty($password)) {
        // Prepare and bind
        $stmt = $conn->prepare("SELECT id, username, password FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);

        // Execute the statement
        $stmt->execute();

        // Store the result
        $stmt->store_result();

        // Check if the username exists
        if ($stmt->num_rows > 0) {
            // Bind the result to variables
            $stmt->bind_result($id, $db_username, $db_password);

            // Fetch the data
            $stmt->fetch();

            // Direct password comparison
            if ($password === $db_password) {
                // Password is correct, set session variables
                $_SESSION['username'] = $db_username;
                $_SESSION['id'] = $id;

                // Redirect to the dashboard
                header("Location: ../dashbord/index.html");
                exit();
            } else {
                // Invalid password
                echo "<script>alert('Invalid password. Please try again.'); window.location.href = '../admin-login.html';</script>";
            }
        } else {
            // Username not found
            echo "<script>alert('Username not found. Please try again.'); window.location.href = '../admin-login.html';</script>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<script>alert('Please fill in all fields.'); window.location.href = '../admin-login.html';</script>";
    }
}

// Close the database connection
$conn->close();
?>
