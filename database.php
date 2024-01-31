<?php
// Define your database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$database = "registration";

// Create a database connection
$mysqli = new mysqli($host, $username, $password, $database);

// Check for a successful connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Function to insert a new user into the database
function insertUser($username, $email, $password) {
    global $mysqli;
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hashedPassword);
    
    if ($stmt->execute()) {
        return true; // Registration successful
    } else {
        return false; // Registration failed
    }
}

// Function to check if a user with the given email already exists
function isEmailTaken($email) {
    global $mysqli;
    
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    return $result->num_rows > 0;
}
?>
