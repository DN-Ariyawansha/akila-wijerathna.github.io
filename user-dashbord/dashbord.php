<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: ../login.html"); // Change to your login page
    exit();
}

// Fetch user details from the database (example)
// Database connection details
$servername = "localhost";
$username = "root";
$password = "Owner.Dinuwa";
$dbname = "dinuwa";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: admin.login.php"); // Change to your login page
    exit();
}

// Validate session ID
$user_id = $_SESSION['user_id'];
$session_id = session_id();

$stmt = $conn->prepare("SELECT session_id FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($db_session_id);
$stmt->fetch();

if ($db_session_id !== $session_id) {
    // Session is not valid
    session_unset(); // Unset session variables
    session_destroy(); // Destroy the session
    header("Location: login.php"); // Redirect to login page
    exit();
}

// Fetch user details from the database (example)
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    // Handle case where user details are not found
    echo "User not found.";
    exit();
}
// Fetch user details from the database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT username, mobile_number, address, password FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $mobile, $address, $password);
$stmt->fetch();
$stmt->close();
$conn->close();

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account Page</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>

    <div class="navbar">
        <div class="logo"><span>A</span>kila <span>W</span>ijerathna</div>
        <div class="nav-links" id="nav-links">
            <a href="#home" class="nav-link">Home</a>
            <a href="#about-us" class="nav-link">About Us</a>
            <a href="#contact" class="nav-link">Contact</a>
            <a href="php/logout.php" class="nav-link logout-btn">Logout</a>
        </div>
        <div class="hamburger" onclick="toggleMenu()">
            &#9776;
        </div>
    </div>
    
    <div class="user-info" id="user-info">
        <!-- User details will be populated here -->
    </div>
    


    <div class="content">
        <div class="section" onclick="showEditInfo()">EDIT INFO</div>
        <div class="section" onclick="showLiveLectures()">LIVE LECTURES</div>
        <div class="section" onclick="showPDFFiles()">PDF FILES</div>
        <div class="section" onclick="showContactUs()">CONTACT US</div>
    </div>


    <div id="edit-info-section" style="display:none;">
    <h2>Edit User Information</h2>
    <form action="php/update_user.php" method="post">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">

        <label>Username:</label><br>
        <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br><br>
        
        <label>Password:</label><br>
        <input type="text" name="password"value="<?php echo htmlspecialchars($password); ?>" required><br><br>
        
        <label>Mobile Number:</label><br>
        <input type="text" name="mobile" value="<?php echo htmlspecialchars($mobile); ?>" required><br><br>
        
        <label>Address:</label><br>
        <input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>" required><br><br>
        
        <button type="submit">Save Changes</button>
    </form>
</div>
        <div id="live-lectures-section" style="display:none;">
            <h2>Live Lectures</h2>
            <div id="lecture-details">
                <!-- Details will be injected here by JavaScript -->
            </div>
            <iframe id="lecture-frame" style="width:100%; height:400px; border:none;"></iframe>
        </div>
        

        <div id="pdf-files-section" style="display:none;">
            <h2>PDF Files</h2>
            <div id="pdf-files-list">
                <!-- PDF files will be dynamically injected here -->
            </div>
        </div>
                

        <div id="contact-us-section" style="display:none;">
            <h2>Contact Us</h2>
            <p>If you have any issues regarding the class, please contact:</p>
            <p><strong>Akila Sir:</strong> akila@example.com | Mobile: 987-654-3210</p>
            <p>If there is an error on the website, please contact the developer:</p>
            <p><strong>Developer:</strong> 999-888-7777</p>
            <p><a href="https://facebook.com/developer" target="_blank">Facebook</a> | 
               <a href="https://github.com/developer" target="_blank">GitHub</a> | 
               <a href="https://tiktok.com/@developer" target="_blank">TikTok</a></p>
        </div>

    <script src="js/script.js"></script>
</body>
</html>
