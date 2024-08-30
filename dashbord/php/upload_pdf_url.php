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
    $title = $_POST['title'];
    $url = $_POST['url'];

    // Validate inputs
    if (empty($title) || empty($url)) {
        echo 'Title and URL are required.';
        exit;
    }

    // Insert the PDF title and URL into the database
    $stmt = $conn->prepare("INSERT INTO pdf_files (title, url) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $url);

    if ($stmt->execute()) {
        echo 'PDF URL uploaded successfully!';
    } else {
        echo 'Error uploading PDF URL: ' . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
