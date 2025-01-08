<?php
session_start();
require 'dbconnect.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];

    try {
        // Check if the user exists in the database
        $stmt = $conn->prepare("SELECT * FROM clients WHERE Email = :Email");
        $stmt->bindParam(':Email', $Email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password and ensure the account is verified
        if ($user && password_verify($Password, $user['Password'])) {
            // Store user data in session
            $_SESSION['Email'] = $user['Email'];
            $_SESSION['Username'] = $user['Username'];

            // Redirect to the dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<div class='container mt-5'><div class='alert alert-danger text-center'>Invalid email or password.</div></div>";
        }
    } catch (PDOException $e) {
        echo "<div class='container mt-5'><div class='alert alert-danger text-center'>Database error: " . $e->getMessage() . "</div></div>";
    }
}
?>
