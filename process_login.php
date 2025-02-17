<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database connection
require 'dbconnect.php';

class User {
    private $conn;
    private $email;
    private $password;

    public function __construct($conn, $email, $password) {
        $this->conn = $conn;
        $this->email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        $this->password = $password;
    }

    public function authenticate() {
        $stmt = $this->conn->prepare("SELECT * FROM clients WHERE Email = :email LIMIT 1");
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password and return user details if valid
        if ($user && password_verify($this->password, $user['Password'])) {
            return $user;
        }
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['Email'] ?? '';
    $password = $_POST['Password'] ?? '';

    try {
        $database = new Database();
        $conn = $database->getConnection();
        $userInstance = new User($conn, $email, $password);
        $user = $userInstance->authenticate();

        if ($user) {
            // Normalize role case
            $role = strtolower($user['Role']);

            // Store user details in session
            $_SESSION['user'] = [
                'Username' => $user['Username'],
                'Email' => $user['Email'],
                'Role' => $role
            ];

            // Redirect based on role
            if ($role === 'admin') {
                header("Location: admin.php");
                exit();
            } else {
                header("Location: Home.php");
                exit();
            }
        } else {
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
