<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "2fa";

try {
    $conn = new PDO("mysql:host=$servername;dbname=2fa", $username, $password);
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
