<?php
require 'events_connect.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = (int) ($_POST['event_id'] ?? 0);
    $quantity = (int) ($_POST['quantity'] ?? 0);

    if ($event_id <= 0 || $quantity <= 0) {
        die("Invalid event or ticket quantity.");
    }

    try {
        // Get the current ticket count and price
        $stmt = $conn->prepare("SELECT tickets_sold, price FROM events WHERE id = :event_id");
        $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->execute();
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$event) {
            die("Event not found.");
        }

        $new_tickets_sold = $event['tickets_sold'] + $quantity;
        $new_revenue = $new_tickets_sold * $event['price']; // Update revenue

        // Update tickets_sold and revenue in the database
        $update_stmt = $conn->prepare("UPDATE events SET tickets_sold = :tickets_sold, revenue = :revenue WHERE id = :event_id");
        $update_stmt->bindParam(':tickets_sold', $new_tickets_sold, PDO::PARAM_INT);
        $update_stmt->bindParam(':revenue', $new_revenue, PDO::PARAM_STR);
        $update_stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $update_stmt->execute();

        echo "Ticket statistics updated successfully.";

    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>
