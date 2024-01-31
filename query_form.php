<?php
// Include your database connection code here
$host = "localhost";
$username = "root";
$password = "";
$dbname = "registration"; // Replace with your actual database name

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO to throw exceptions for errors
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form data was submitted
    if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["message"])) {
        // Retrieve form data
        $sender_name = $_POST["name"];
        $sender_email = $_POST["email"];
        $message = $_POST["message"];
        
        // Perform database insertion
        $sql = "INSERT INTO queries (sender_name, sender_email, message) VALUES (:sender_name, :sender_email, :message)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':sender_name', $sender_name);
        $stmt->bindParam(':sender_email', $sender_email);
        $stmt->bindParam(':message', $message);
        $stmt->execute();
        
        // // Return a response to indicate success (you can customize this response)
        header("Location: contact.html?submitted=1"); // Add any query parameter you like
exit;
    }
}

// Close the database connection
$conn = null;
?>

