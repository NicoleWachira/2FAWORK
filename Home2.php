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
            <li><a href="about.html">About Us</a></li>
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
            <button class="buy-btn" onclick="openForm('<?php echo htmlspecialchars($event['name']); ?>', '<?php echo htmlspecialchars($event['event_date']); ?>', <?php echo htmlspecialchars($event['price']); ?>)">Buy Ticket</button>
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
        
        <!-- Download Ticket Button (Hidden Initially) -->
        <a id="download-ticket" href="#" download style="display:none;">Download Ticket</a>
      </form>
    </div>

  <script src="home.js"></script>

</body>
</html>
