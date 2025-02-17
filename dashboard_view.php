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
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul>
            <li><a href="Home.php">Home</a></li>
            <li><a href="dashboard_view.php" class="active">Profile</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="logout.php" class="logout">Logout</a></li>
        </ul>
    </div>

    <!--Content -->
<div class="content">
        <h1>Welcome, <?= $username; ?>!</h1>
        <h2><strong>Email:</strong> <?= $email; ?></h2>
</div>

</body>
</html>
