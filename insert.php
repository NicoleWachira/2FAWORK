<?php
require 'dbconnect.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $Password = password_hash($_POST['Password'], PASSWORD_BCRYPT); // Hash the password for security

    try {
        // Prepare SQL and bind parameters
        $stmt = $conn->prepare("INSERT INTO clients (Username, Email, Password) VALUES (:Username, :Email, :Password)");
        $stmt->bindParam(':Username', $Username);
        $stmt->bindParam(':Email', $Email);
        $stmt->bindParam(':Password', $Password);

        // Execute the query
        $stmt->execute();

        // Redirect to login page after successful registration
        header("Location: Login.php");
        exit();
    } catch (PDOException $e) {
        echo "<div class='container mt-5'><div class='alert alert-danger text-center'>Error: " . $e->getMessage() . "</div></div>";
    }
}
?>
