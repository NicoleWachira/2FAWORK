<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: Login.html");
    exit();
}

// Ensure only admins can access
if ($_SESSION['user']['Role'] !== 'admin') {
    header("Location: Home.php"); // Redirect non-admin users
    exit();
}

$adminName = htmlspecialchars($_SESSION['user']['Username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="Home2.php">Home</a></li>
            <li><a href="dashboard2.php">Profile</a></li>
            <li><a href="admin.php" class="active">Dashboard</a></li>
            <li><a href="statistics.php">Statistics</a></li>
            <li><a href="about.html">About Us</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">  
        <h1>Welcome, Admin <?php echo $adminName; ?>!</h1>
        <h2>Manage events and view analytics from here</h2>

        <div class="admin-actions">
            <div class="event" id="create">
                <img src="images/event.jpg" alt="calendar image">
                <button onclick="openCreateEvent()">Create Event</button>
            </div>
            <div class="event" id="update">
                <img src="images/update.jpg" alt="Update Event">
                <button onclick="openUpdateEvent()">Update Event</button>
            </div>
            <div class="event" id="delete">
                <img src="images/delete.jpg" alt="Delete Event">
                <button onclick="openDeleteEvent()">Delete Event</button>
            </div>
        </div>
    </div>

    <!-- Create Event Modal -->
    <div id="createEvent" class="modal">
        <form action="create_event.php" method="POST" enctype="multipart/form-data">
            <label for="eventImage">Upload Image:</label>
            <input type="file" name="eventImage" required>
            <label for="eventname">Event Name:</label>
            <input type="text" name="eventname" required>
            <label for="eventPrice">Price:</label>
            <input type="number" name="eventPrice" required>
            <label for="eventDate">Date:</label>
            <input type="date" name="eventDate" required>
            <label>Location:</label>
            <input type="text" name="location" required>
            <label>Quantity:</label>
            <input type="number" name="quantity" min="1" required>
            <button type="submit">Create Event</button>
            <button type="button" class="cancel-btn" onclick="closeCreateEvent()">Cancel</button>
        </form>
    </div>

    <!-- Update Event Modal -->
    <div id="updateEvent" class="modal">
        <form action="update_event.php" method="POST">
            <label for="eventId">Event ID:</label>
            <input type="number" name="eventId" required>
            <label for="newPrice">New Price:</label>
            <input type="number" name="newPrice" required>
            <label for="newDate">New Date:</label>
            <input type="date" name="newDate" required>
            <button type="submit">Update Event</button>
            <button type="button" class="cancel-btn" onclick="closeUpdateEvent()">Cancel</button>
        </form>
    </div>

    <!-- Delete Event Modal -->
    <div id="deleteEvent" class="modal">
        <form action="delete_event.php" method="POST">
            <label for="deleteId">Event ID:</label>
            <input type="number" name="deleteId" required>
            <button type="submit">Delete Event</button>
            <button type="button" class="cancel-btn" onclick="closeDeleteEvent()">Cancel</button>
        </form>
    </div>

    <script src="admin.js"></script>
</body>          
</html>
