<?php
session_start(); // Start the session

// Database connection details
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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the inputs are not empty
    if (!empty($username) && !empty($password)) {
        // Prepare and bind
        $stmt = $conn->prepare("SELECT id, username, password, session_id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);

        // Execute the statement
        $stmt->execute();

        // Store the result
        $stmt->store_result();

        // Check if the username exists
        if ($stmt->num_rows > 0) {
            // Bind the result to variables
            $stmt->bind_result($id, $db_username, $db_password, $db_session_id);

            // Fetch the data
            $stmt->fetch();

                // Check if the user is already logged in on another device
                if ($db_session_id && $db_session_id !== session_id()) {
                    // Notify the user
                    echo "<script>alert('You can only log in from one device at a time. Please contact Akila sir or the developer to resolve this issue.');</script>";
                } else {
                    // Start a session
                    $_SESSION['username'] = $db_username;
                    $_SESSION['user_id'] = $id;

                    // Generate a new session ID
                    $new_session_id = session_id();

                    // Update the user's session ID in the database
                    $update_stmt = $conn->prepare("UPDATE users SET session_id = ? WHERE id = ?");
                    $update_stmt->bind_param("si", $new_session_id, $id);
                    $update_stmt->execute();
                    $update_stmt->close();

                    // Redirect to the homepage or dashboard
                    header("Location: ../user-dashbord/dashbord.php"); // Assuming you have a PHP file for the dashboard
                    exit();
                }
            } else {
                // Invalid password
                echo "<script>alert('Invalid password. Please try again.');</script>";
            }
        } else {
            // Username not found
            echo "<script>alert('Username not found. Please try again.');</script>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<script>alert('Please fill in all fields.');</script>";
    }

// Close the database connection
$conn->close();
?>
