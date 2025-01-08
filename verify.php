<?php

require 'pverify.php';

try {
    // Initialize the database connection
    $db = new Database();
    $conn = $db->connect();

    // Create a Verification instance
    $verification = new Verification($conn);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $verification->processVerification($_POST);
    } else {
        // Include the HTML content for the verification page
        include 'verify.html';
    }
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
}
?>
