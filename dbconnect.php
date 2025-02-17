<?php

ini_set('memory_limit', '256M'); // You can increase this to 512M or higher if required

class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "1234";
    private $dbname = "2fa";
    private $conn = null;

    // Constructor to optionally override connection parameters
    public function __construct($servername = null, $username = null, $password = null, $dbname = null) {
        if ($servername) $this->servername = $servername;
        if ($username) $this->username = $username;
        if ($password) $this->password = $password;
        if ($dbname) $this->dbname = $dbname;
    }

    // Connect to the database
    public function connect() {
        try {
            $this->conn = new PDO("mysql:host={$this->servername};dbname={$this->dbname}", $this->username, $this->password);
            // Set PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    // Disconnect from the database
    public function disconnect() {
        $this->conn = null;
    }

    // New method to return the PDO connection
    public function getConnection() {
        if ($this->conn === null) {
            $this->connect(); // Establish connection if not already established
        }
        return $this->conn;
    }
}

// Optional: Example of how you could use the class
// Uncomment if you want to test the connection
/*
$db = new TwoFA();
$conn = $db->connect();
echo "Connected successfully";  // Test if connection works
$db->disconnect();
*/
?>
