<?php

require 'events_connect.php'; // Ensure you have a database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventname = trim($_POST['eventname']);
    $eventPrice = trim($_POST['eventPrice']);
    $eventDate = trim($_POST['eventDate']);
    $location = $_POST['location'];
    $quantity = $_POST['quantity'];

    // Validate required fields
    if (empty($eventname) || empty($eventPrice) || empty($eventDate)) {
        die("All fields are required.");
    }

    // Validate price
    if (!is_numeric($eventPrice) || $eventPrice <= 0) {
        die("Invalid price. Please enter a valid number.");
    }

    // Check if an image file was uploaded
    if (!isset($_FILES["eventImage"]) || $_FILES["eventImage"]["error"] != 0) {
        die("No image uploaded or upload error. Error code: " . $_FILES["eventImage"]["error"]);
    }

    $targetDir = "uploads/";

    // Ensure the uploads directory exists
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $imageName = time() . "_" . basename($_FILES["eventImage"]["name"]); // Unique name
    $targetFile = $targetDir . $imageName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // ✅ Check file size (Max 5MB)
    if ($_FILES["eventImage"]["size"] > 10 * 1024 * 1024) { 
        die("File is too large. Maximum allowed size is 10MB.");
    }

    // ✅ Allowed file types
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedTypes)) {
        die("Only JPG, JPEG, PNG & GIF files are allowed.");
    }

    // ✅ Move uploaded file
    if (!move_uploaded_file($_FILES["eventImage"]["tmp_name"], $targetFile)) {
        die("Error uploading the image.");
    }

    // ✅ Insert into database
    try {
        $stmt = $conn->prepare("INSERT INTO events (image, eventname, price, event_date, location, quantity) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$imageName, $eventname, $eventPrice, $eventDate, $location, $quantity]);
        
        header("Location: home.php?success=1");
        exit();

    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}

// Close PDO connection
$conn = null;
?>
