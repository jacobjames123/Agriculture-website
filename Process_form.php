<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check which form was submitted and perform the corresponding action
    
    // Adding a new user
    if (isset($_POST["new-full-name"]) && isset($_POST["new-email"]) && isset($_POST["new-password"])) {
        // Retrieve data from the form
        $full_name = $_POST["new-full-name"];
        $email = $_POST["new-email"];
        $password = $_POST["new-password"];
        
        // Hash the password
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        
        // Perform database insertion
        $sql = "INSERT INTO users (full_name, email, password) VALUES (:full_name, :email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password_hashed);
        $stmt->execute();
    }

    

 // Editing an existing user
elseif (isset($_POST["current-full-name"]) && isset($_POST["current-email"]) && isset($_POST["new-full-name"]) && isset($_POST["new-email"])) {
    // Retrieve user information from the form
    $current_full_name_input = $_POST["current-full-name"];
    $current_email_input = $_POST["current-email"];
    $new_full_name = $_POST["new-full-name"];
    $new_email = $_POST["new-email"];

    // Fetch the user's information based on name and email
    $sql = "SELECT id, full_name, email FROM users WHERE full_name = :current_full_name AND email = :current_email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':current_full_name', $current_full_name_input);
    $stmt->bindParam(':current_email', $current_email_input);
    $stmt->execute();

    // Check if a user with the provided name and email exists
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        // User found, perform the update
        $user_id = $user['id']; // Get the user ID
        $sql = "UPDATE users SET full_name = :new_full_name, email = :new_email WHERE id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':new_full_name', $new_full_name);
        $stmt->bindParam(':new_email', $new_email);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
    } else {
        // Handle error - User not found with the provided name and email
        // echo "Error: User not found with the provided name and email.";
        echo '<script>alert("User not found. Please register.");</script>';
    }
}
    
    // Deleting an existing user
    elseif (isset($_POST["delete-user-name"])) {
        // Retrieve the user name to delete
        $delete_user_name = $_POST["delete-user-name"];
        
        // Perform database deletion based on user name
        $sql = "DELETE FROM users WHERE full_name = :delete_user_name";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':delete_user_name', $delete_user_name);
        $stmt->execute();
    }
}

// Close the database connection
$conn = null;

// Redirect back to the admin dashboard or wherever you want
header("Location: admin_dashboard.php");
exit;

?>

