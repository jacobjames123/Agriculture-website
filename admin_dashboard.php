

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap">
    <link rel="stylesheet"  href="admin.css">
</head>
<body>
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

// Retrieve email notifications from the "queries" table
$sql = "SELECT * FROM queries";
$stmt = $conn->prepare($sql);
$stmt->execute();
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT COUNT(*) AS user_count FROM users"; // Modify table name if needed
$stmt = $conn->prepare($sql);
$stmt->execute();
$userCountData = $stmt->fetch(PDO::FETCH_ASSOC);



// Close the database connection
$conn = null;

function getMessageCount() {
    global $notifications;
    return count($notifications);
}

function formatUserCount($userCount) {
    return '<p id="user-count">' . $userCount['user_count'] . '</p>';
}

?>

    
    <header>
    <!-- Navigation Menu -->
    <nav>
        <ul>
            <li><a href="javascript:void(0);" onclick="toggleUserManagement()"><img src="images/user.png" alt="User Management"> User Management</a></li>
            <li><a href="javascript:void(0);" onclick="toggleEmailNotifications()"><img src="images/email (1).gif" alt="Email Notifications"> Email Notifications</a></li>
            <li><a href="#notifications" onclick="toggleNotifications()"><img src="images/bell.png" alt="Notifications"> Notifications</a></li>
            <li><a href="Home.html" ><img src="images/exit.png" alt="Logout"> Logout</a></li>
        </ul>
    </nav>
</header>


<section id="email-notifications">
<h1>Email Notifications</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Sender Name</th>
            <th>Sender Email</th>
            <th>Message</th>
            <th>Timestamp</th>
        </tr>
        <?php foreach ($notifications as $notification): ?>
            <tr>
                <td><?php echo $notification['id']; ?></td>
                <td><?php echo $notification['sender_name']; ?></td>
                <td><?php echo $notification['sender_email']; ?></td>
                <td><?php echo $notification['message']; ?></td>
                <td><?php echo $notification['timestamp']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    </section>

    <!-- User Management Section -->
    <section id="user-management">
        <h2>User Management</h2>
        <div class="user-form">
        <h3>Add User</h3>
        <form action="Process_form.php" method="post">
            <!-- Add input fields for adding a new user -->
            <label for="new-full-name">Full Name:</label>
            <input type="text" id="new-full-name" name="new-full-name" required>

            <label for="new-email">Email:</label>
            <input type="email" id="new-email" name="new-email" required>

            <label for="new-password">Password:</label>
            <input type="password" id="new-password" name="new-password" required>

            <button type="submit">Add User</button>
        </form>
    </div>

    
<!-- Edit User Form -->
<div class="user-form">
    <h3>Edit User</h3>
    <form action="Process_form.php" method="post">
        <!-- Current User Information (Name and Email) -->
        <label for="current-full-name">Current Full Name:</label>
        <input type="text" id="current-full-name" name="current-full-name" required>

        <label for="current-email">Current Email:</label>
        <input type="email" id="current-email" name="current-email" required>

        <!-- Updated User Information -->
        <label for="new-full-name">New Full Name:</label>
        <input type="text" id="new-full-name" name="new-full-name" required>

        <label for="new-email">New Email:</label>
        <input type="email" id="new-email" name="new-email" required>

        <button type="submit" name="action" value="edit_user">Edit User</button>
    </form>
</div>


    <!-- Delete User Form -->
    <div class="user-form">
    <h3>Delete User</h3>
    <form action="Process_form.php" method="post">
        <!-- Input field for entering the user's name to delete -->
        <label for="delete-user-name">User Name:</label>
        <input type="text" id="delete-user-name" name="delete-user-name" required>

        <button type="submit" name="action" value="delete_user">Delete User</button>
    </form>
</div>
    </section>


    <!-- Notifications Section -->
    <section id="notifications">
    <h2>Notifications</h2>
    <div class="notification">
        <div class="notification-icon">
            <img src="images/bell.png" alt="Notification Icon">
            <span class="badge">
            <?php echo getMessageCount(); ?>
            </span>
        </div>
        <div class="notification-content">
            <p><strong>Notification messages</strong></p>
            <p>Please take a look at all your new messages.</p>
        </div>
    </div>
    <!-- Add more notifications as needed -->
</section>

<section class="dashboard-content">
    <h2>welcome Admin</h2>
        <div class="user-count">
            <h2>Total Users</h2>
            <p id="user-count"><?php echo formatUserCount($userCountData); ?></p> <!-- User count will be displayed here -->
        </div>
    </section>
</section>




<script>
function toggleUserManagement() {
    var userManagementSection = document.getElementById("user-management");
    if (userManagementSection.style.display === "none" || userManagementSection.style.display === "") {
        userManagementSection.style.display = "flex";
    } else {
        userManagementSection.style.display = "none";
    }
}

function toggleNotifications() {
        var notificationsSection = document.getElementById("notifications");
        if (notificationsSection.style.display === "none" || notificationsSection.style.display === "") {
            notificationsSection.style.display = "flex";
        } else {
            notificationsSection.style.display = "none";
        }
    }

    function toggleEmailNotifications() {
    var emailNotificationsDiv = document.getElementById("email-notifications");
    if (emailNotificationsDiv.style.display === "none" || emailNotificationsDiv.style.display === "") {
        emailNotificationsDiv.style.display = "block";
    } else {
        emailNotificationsDiv.style.display = "none";
    }
}

    
    

</script>

</body>
</html>
