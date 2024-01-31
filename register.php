<?php
// Establish a database connection (you should have a database already set up)
$mysqli = new mysqli("localhost", "root", "", "registration");

// Check for a successful connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if form data was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $username = isset($_POST['reg-username']) ? $_POST['reg-username'] : '';
    $email = isset($_POST['reg-email']) ? $_POST['reg-email'] : '';
    $password = isset($_POST['reg-password']) ? password_hash($_POST['reg-password'], PASSWORD_DEFAULT) : ''; // Hash the password for security

    // Perform server-side validation here (e.g., checking email uniqueness)

    // Insert user data into the database
    $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die("Error: " . $mysqli->error);
    }

    $stmt->bind_param("sss", $username, $email, $password);
    

    if ($stmt->execute()) {
        // Registration successful, redirect to the dashboard or a thank-you page
        header("Location: dashboard.php"); // Change this to your actual dashboard page
        exit();
    } else {
        // Registration failed, handle the error (e.g., display an error message)
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$mysqli->close();
?>

