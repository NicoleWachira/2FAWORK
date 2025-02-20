<?php
require 'events_connect.php'; // Ensure database connection

// Get the event ID from the URL
$event_id = isset($_GET['event']) ? $_GET['event'] : 0;

// Fetch event details from the database
$query = "SELECT * FROM events WHERE id = :event_id"; // Assuming the column name is 'id'
$stmt = $conn->prepare($query);
$stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
$stmt->execute();
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    // If no event found, redirect to home
    header("Location: Home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buy Ticket - <?php echo htmlspecialchars($event['eventname']); ?></title>
  <link rel="stylesheet" href="ticket_form.css">
</head>
<body>
  <div class="form-container">
    <h1>Buy Ticket for <?php echo htmlspecialchars($event['eventname']); ?></h1>
    <form action="process_ticket.php" method="POST">
      <!-- Hidden field for event ID -->
      <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event['id']); ?>">
      <input type="hidden" name="event_name" value="<?php echo htmlspecialchars($event['eventname']); ?>">

      <div class="form-group">
        <label for="name">Your Name</label>
        <input type="text" name="name" required placeholder="Enter your name">
      </div>

      <div class="form-group">
        <label for="email">Your Email</label>
        <input type="email" name="email" required placeholder="Enter your email">
      </div>

      <div class="form-group">
        <label for="phone">Your Phone Number</label>
        <input type="text" name="phone" required placeholder="Enter your phone number">
      </div>

      <div class="form-group">
        <label for="quantity">Number of Tickets</label>
        <input type="number" name="quantity" min="1" max="4" value="1" required>
      </div>

      <div class="form-group">
        <label for="payment">Payment Method</label>
        <select name="payment" required>
          <option value="creditCard">Credit Card</option>
          <option value="paypal">PayPal</option>
          <option value="mpesa">M-Pesa</option>
        </select>
      </div>

      <button type="submit" class="submit-btn">Buy Ticket</button>
      <!-- Cancel Button -->
    <a href="Home.php" class="cancel-btn">Cancel</a>
    </form>
  </div>
</body>
</html>
