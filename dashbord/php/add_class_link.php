<?php
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $class_link = $_POST['class_link'];
    $title = $_POST['title'];

    if (empty($date) || empty($time) || empty($class_link) || empty($title)) {
        echo 'All fields are required.';
        exit;
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO class_links (date, time, class_link, title) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $date, $time, $class_link, $title);

    if ($stmt->execute()) {
        echo 'Class link added successfully!';
    } else {
        echo 'Error adding class link: ' . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
