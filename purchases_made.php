<?php
session_start();
require 'events_connect.php';

// Ensure user is logged in and is an admin
if (!isset($_SESSION['user']) || $_SESSION['user']['Role'] !== 'admin') {
    header("Location: Home.php");
    exit();
}

// Fetch all purchases with event details
$query = "SELECT p.PurchaseID, c.Username, p.ClientEmail, e.id AS EventID, e.eventname, e.price, p.Quantity, p.TotalPrice, p.PurchaseDate 
          FROM purchases p
          JOIN events e ON p.EventID = e.id
          LEFT JOIN clients c ON p.ClientEmail = c.Email"; // Joining clients to get username
$stmt = $conn->prepare($query);
$stmt->execute();
$purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchases Made</title>
    <link rel="stylesheet" href="purchases_made.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="Home2.php">Home</a></li>
            <li><a href="dashboard2.php">Profile</a></li>
            <li><a href="admin.php">Dashboard</a></li>
            <li><a href="purchases_made.php">PurchasesMade</a></li>
            <li><a href="statistics.php">Statistics</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <h1>Purchases Made</h1>
        <table border="1">
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Event ID</th>
                <th>Event Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Purchase Date</th>
            </tr>
            <?php foreach ($purchases as $purchase): ?>
            <tr>
                <td><?php echo htmlspecialchars($purchase['Username'] ?? 'Guest'); ?></td>
                <td><?php echo htmlspecialchars($purchase['ClientEmail']); ?></td>
                <td><?php echo htmlspecialchars($purchase['EventID']); ?></td>
                <td><?php echo htmlspecialchars($purchase['eventname']); ?></td>
                <td>Ksh <?php echo number_format($purchase['price'], 2); ?></td>
                <td><?php echo htmlspecialchars($purchase['Quantity']); ?></td>
                <td>Ksh <?php echo number_format($purchase['TotalPrice'], 2); ?></td>
                <td><?php echo htmlspecialchars($purchase['PurchaseDate']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
