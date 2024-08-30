<?php
// fetch_pdf_files.php

// Database connection details
$servername = "sql12.freesqldatabase.com";
$username = "sql12728588";
$password = "wbrhtUq1KD";
$dbname = "sql12728588";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Prepare SQL statement
$sql = "SELECT title, url FROM pdf_files";
$stmt = $conn->prepare($sql);

if ($stmt) {
    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    $pdfFiles = [];
    while ($row = $result->fetch_assoc()) {
        // Sanitize output
        $pdfFiles[] = [
            'title' => htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'),
            'url' => htmlspecialchars($row['url'], ENT_QUOTES, 'UTF-8')
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($pdfFiles);
    
    // Close the statement
    $stmt->close();
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Failed to prepare statement']);
}

// Close the connection
$conn->close();
?>
