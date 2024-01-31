<?php
// Establish a database connection (you should have a database already set up)
$mysqli = new mysqli("localhost", "root", "", "registration");

// Check for a successful connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}


// Retrieve form data
$username = $_POST['login-username'];
$password = $_POST['login-password'];



// Query the database to check if the user exists
$sql = "SELECT * FROM users WHERE full_name = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();



if ($result->num_rows === 1) {
    // User exists, verify the password
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        // Password is correct, create a session for the user and redirect based on their role
        session_start();
        $_SESSION['user_id'] = $row['id'];
        
        // Check the user's role and redirect accordingly
        // Check the username and redirect based on it
        $username = $row['full_name'];

        if ($username === 'Ameer') {
            header("Location: admin_dashboard.php");

        } elseif ($username === 'deku') {

            header("Location: officer_dashboard.php");

        } else {
            header("Location: Dashboard.php"); // Normal user dashboard
        }

        exit();
    } else {
        // Password is incorrect, display an error message
        echo '<script>alert("Incorrect password. Please try again.");</script>';
        echo '<script>window.location.href = "home.html";</script>';
    }
} else {
    // User does not exist, display an error message
    echo '<script>alert("User not found. Please register.");</script>';
    echo '<script>window.location.href = "home.html";</script>';
}




$stmt->close();
$mysqli->close();
?>
