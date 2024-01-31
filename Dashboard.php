<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap">
    <link rel="stylesheet"  href="admin.css">
</head>
<body>

<?php
// Start a session to access session variables
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if not logged in
    header("Location: login.php"); // Replace with the actual login page URL
    exit();
}

// Include your database connection code here
$host = "localhost";
$username = "root";
$password = "";
$dbname = "registration";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO to throw exceptions for errors
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get the user's ID from the session
$userId = $_SESSION['user_id'];

// Perform a database query to fetch the user's profile information based on their ID
$sql = "SELECT * FROM users WHERE id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$userProfile = $stmt->fetch(PDO::FETCH_ASSOC);

// Close the database connection
$conn = null;
?>


<header class="new-header">
        <!-- User Profile Section -->
        <section class="user-profile">
        <h2>Welcome, <?php echo $userProfile['full_name']; ?></h2>
        <img src="Images/profile.gif" alt="User Profile Image">
        <p>Email: <?php echo $userProfile['email']; ?></p>
        
        </section>

        <!-- Navigation Menu -->
        <nav class="dashboard-nav">
            <ul>
                <li><a href="#">Notifications</a></li>
                <li><a href="Home.html">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="dashboard-section">
    <h3>Welcome, <?php echo $userProfile['full_name']; ?>!</h3>
    <p>We're delighted to have you here in your user dashboard. Explore the options below to make the most of your experience:</p>
    
    <h4>support</h4>
    <p>Communicate with our support team</p>
</section>


    

    <!-- Rest of the Dashboard Content Goes Here -->

    <script src="script.js"></script>
</body>
</html>
    
</body>
</html>