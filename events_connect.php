<?php
$host = "localhost"; // Change if using a remote server
$dbname = "2fa"; // Replace with your actual database name
$username = "root"; // Replace if your database has a different username
$password = "1234"; // Replace if your database has a password

try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set error mode to exception to catch errors
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode to associative array
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // If connection fails, show an error
    die("Database Connection Failed: " . $e->getMessage());
}
?>
