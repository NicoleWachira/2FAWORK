<?php
session_start();

// Check if the user is logged in and verified
if (!isset($_SESSION['verified']) || $_SESSION['verified'] !== true) {
    // Redirect to login page if user is not verified or not logged in
    header("Location: Login.html");
    exit();
}

class User {
    private $username;
    private $email;
    private $isVerified;

    public function __construct() {
        $this->initializeSession();
    }

    private function initializeSession() {
        // Initialize session variables securely
        $this->username = $_SESSION['Username'] ?? null;
        $this->email = $_SESSION['Email'] ?? null;
        $this->isVerified = $_SESSION['verified'] ?? false;
    }

    public function getUsername() {
        return htmlspecialchars($this->username); // Prevent XSS attacks
    }

    public function getEmail() {
        return htmlspecialchars($this->email); // Prevent XSS attacks
    }

    public function isVerified() {
        return $this->isVerified;
    }

    public function logout() {
        // Destroy the session and redirect to login
        session_unset();  // Clear session data
        session_destroy(); // Destroy the session itself
        header("Location: Login.html");
        exit();
    }
}

// Instantiate User object
$user = new User();

// Handle the logout request if clicked
if (isset($_GET['logout'])) {
    $user->logout();  // Call the logout function when the user clicks logout
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="dashboard.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="dashboard-frame">
            <h2 class="text-center mb-4">Welcome, <?php echo $user->getUsername(); ?>!</h2>
            <p class="text-center">You have successfully logged in and verified your account.</p>
            <div class="mt-4">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" class="form-control" value="<?php echo $user->getUsername(); ?>" readonly>

                <label for="email" class="form-label mt-3">Email</label>
                <input type="email" id="email" class="form-control" value="<?php echo $user->getEmail(); ?>" readonly>
            </div>

            <!-- Logout button with GET method to trigger the logout action -->
            <p class="text-center mt-4">
                <a href="?logout=true" class="btn btn-danger">Logout</a> <!-- Logout link triggers the logout logic -->
            </p>
        </div>
    </div>
</body>
</html>
