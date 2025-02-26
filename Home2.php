<?php
require 'events_connect.php'; // Ensure database connection

// Fetch events from the database
$query = "SELECT * FROM events ORDER BY event_date ASC";
$stmt = $conn->prepare($query);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cycling Events</title>
  <link rel="stylesheet" href="Home2.css">
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

  <!-- Main Content -->
  <div class="main-content">
    <header>
      <h1>Cycling Events</h1>
    </header>

    <section class="events">
      <?php if ($events): ?>
        <?php foreach ($events as $event): ?>
          <div class="event">
            <img src="uploads/<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['name']); ?>">
            <h3><?php echo htmlspecialchars($event['name']); ?></h3>
            <p>Price: <?php echo number_format($event['price']); ?> Ksh</p>
            <p>Date: <?php echo htmlspecialchars($event['event_date']); ?></p>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No upcoming events available.</p>
      <?php endif; ?>
    </section>

   
        
        <!-- Download Ticket Button (Hidden Initially) -->
        <a id="download-ticket" href="#" download style="display:none;">Download Ticket</a>
      </form>
    </div>

  <script src="home.js"></script>

</body>
</html>
