<?php
require_once 'User.php'; // Include the User class
require_once 'dbconnect.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form data
    $username = trim($_POST['Username']);
    $email = trim($_POST['Email']);
    $password = $_POST['Password']; // Plain password, will be hashed in the User class

    try {
        // Create a new instance of the User class
        $db = new Database();
        $conn = $db->connect(); // Get the PDO connection

        $user = new User($username, $email, $password, $conn);

        // Register the user (will also handle email sending)
        $user->register();

        // Redirect to the verification page
        header("Location: verify.php");
        exit();

    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}
?>
