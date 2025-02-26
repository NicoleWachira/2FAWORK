<?php 
// Start session only if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if the user session does not exist
if (!isset($_SESSION['user'])) {
    header("Location: Login.html");
    exit();
}

// Retrieve user details from session
$user = $_SESSION['user'];
$username = htmlspecialchars($user['Username'] ?? 'Guest');
$email = htmlspecialchars($user['Email'] ?? 'No email available');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="dashboard2.css">
</head>
<body>
 <!-- Sidebar -->
 <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="Home2.php" class="active">Home</a></li>
            <li><a href="dashboard2.php">Profile</a></li>
            <li><a href="admin.php">Dashboard</a></li>
            <li><a href="purchases_made.php">PurchasesMade</a></li>
            <li><a href="statistics.php">Statistics</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!--Content -->
<div class="content">
        <p1>Welcome, <?= $username; ?>!</p1>
        <p2><strong>Email:</strong> <?= $email; ?></p2>
</div>

</body>
</html>
