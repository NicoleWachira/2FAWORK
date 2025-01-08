<?php
session_start(); // Start the session to manage session variables

// Ensure error reporting is enabled during development
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include the Database class (make sure the 'dbconnect.php' file is correct)
require 'dbconnect.php'; // Your DB connection file

class User {
    private $conn;
    private $email;
    private $password;

    // Constructor that accepts the PDO connection, email, and password
    public function __construct($conn, $email, $password) {
        $this->conn = $conn;
        $this->email = $email;
        $this->password = $password;
    }

    // Authenticate user by checking their credentials
    public function authenticate() {
        // Prepare SQL to find the user by email
        $stmt = $this->conn->prepare("SELECT * FROM clients WHERE Email = :email");
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        // Fetch user record
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists and the password is correct
        if ($user && password_verify($this->password, $user['Password'])) {
            return $user; // Return user data if authentication is successful
        }

        return false; // Return false if authentication fails
    }
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['Email']);
    $password = $_POST['Password'];

    try {
        // Create a new instance of Database to get the PDO connection
        $database = new Database();
        $conn = $database->getConnection();

        // Create a User instance with the connection, email, and password
        $userInstance = new User($conn, $email, $password);
        $user = $userInstance->authenticate(); // Try to authenticate user

        if ($user) {
            // If authentication is successful, store user details in the session
            $_SESSION['Email'] = $user['Email'];
            $_SESSION['Username'] = $user['Username'];
            $_SESSION['verified'] = true; // You can also track verification status if needed

            // Redirect to the dashboard after successful login
            header("Location: dashboard.php");
            exit(); // Always call exit() after header redirect to stop further script execution
        } else {
            // If authentication fails, show error message
            echo "<div class='container mt-5'>
                    <div class='alert alert-danger text-center'>Invalid email or password.</div>
                  </div>";
        }
    } catch (Exception $e) {
        echo "<div class='container mt-5'>
                <div class='alert alert-danger text-center'>Error: " . $e->getMessage() . "</div>
              </div>";
    }
}
?>
