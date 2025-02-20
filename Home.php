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
  <link rel="stylesheet" href="home.css">
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <ul>
      <li><a href="Home.php">Home</a></li>
      <li><a href="dashboard_view.php">Profile</a></li>
      <li><a href="about.html">About Us</a></li>
      <li><a href="logout.php" class="logout">Logout</a></li>
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
            <img src="uploads/<?php echo htmlspecialchars($event['image']); ?>" alt="<?php echo htmlspecialchars($event['eventname']); ?>">
            <h3><?php echo htmlspecialchars($event['eventname']); ?></h3>
            <p>Price: <?php echo number_format($event['price']); ?> Ksh</p>
            <p>Date: <?php echo htmlspecialchars($event['event_date']); ?></p>
            <p>Location: <?php echo htmlspecialchars($event['location']); ?></p>
            <!-- Link to ticket form -->
            <a href="ticket_form.php?event=<?php echo htmlspecialchars($event['id']); ?>" class="buy-btn">Buy Ticket</a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No upcoming events available.</p>
      <?php endif; ?>
    </section>
  </div>

  <script src="home.js"></script> <!-- Ensure this is linked properly -->

</body>
</html>
