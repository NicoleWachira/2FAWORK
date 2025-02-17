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
            <h3>eventname:<?php echo htmlspecialchars($event['eventname']); ?></h3>
            <p>Price: <?php echo number_format($event['price']); ?> Ksh</p>
            <p>Date: <?php echo htmlspecialchars($event['event_date']); ?></p>
            <button class="buy-btn" onclick="openForm('<?php echo htmlspecialchars($event['eventname']); ?>', '<?php echo htmlspecialchars($event['event_date']); ?>', <?php echo htmlspecialchars($event['price']); ?>)">Buy Ticket</button>
            <!-- Download Ticket Button (Hidden Initially) -->
            <a id="download-ticket-<?php echo htmlspecialchars($event['eventname']); ?>" href="#" download style="display:none;" class="download-btn">Download Ticket</a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No upcoming events available.</p>
      <?php endif; ?>
    </section>

    <!-- Ticket purchase form -->
    <div id="ticket-form" class="form-popup">
      <form action="process_ticket.php" method="POST">
        <h2>Buy Ticket</h2>
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" required>
    
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
    
        <label for="number">Phone Number</label>
        <input type="tel" id="number" name="number" required>
    
        <label for="price">Price</label>
        <input type="text" id="price" name="price" readonly>
    
        <label for="event-date">Event Date</label>
        <input type="text" id="event-date" name="event-date" readonly>
    
        <button type="submit" id="submit-btn">Submit</button>
        <button type="button" class="cancel-btn" onclick="closeForm()">Cancel</button>
      </form>
    </div>

  <script src="home.js"></script>

</body>
</html>
