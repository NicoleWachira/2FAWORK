<?php
require 'events_connect.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventId = trim($_POST['deleteId']);

    // Validate event ID
    if (empty($eventId) || !is_numeric($eventId)) {
        die("Invalid event ID.");
    }

    try {
        // Prepare delete statement
        $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
        $stmt->execute([$eventId]);

        // Check if an event was deleted
        if ($stmt->rowCount() > 0) {
            // Redirect to home page after successful deletion
            header("Location: home.php?delete_success=1");
            exit();
        } else {
            die("Event not found or already deleted.");
        }
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}

// Close connection
$conn = null;
?>
