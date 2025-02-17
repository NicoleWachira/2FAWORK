<?php
session_start();

// Check if the user is logged in and verified
if (!isset($_SESSION['verified']) || $_SESSION['verified'] !== true) {
    header("Location: Login.html");
    exit();
}

// Define the User class within this file
class User {
    private $username;
    private $email;
    private $isVerified;

    public function __construct() {
        $this->initializeSession();
    }

    private function initializeSession() {
        $this->username = $_SESSION['Username'] ?? null;
        $this->email = $_SESSION['Email'] ?? null;
        $this->isVerified = $_SESSION['verified'] ?? false;
    }

    public function getUsername() {
        return htmlspecialchars($this->username);
    }

    public function getEmail() {
        return htmlspecialchars($this->email);
    }

    public function isVerified() {
        return $this->isVerified;
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: Login.html");
        exit();
    }
}

// Instantiate User object
$user = new User();

// Handle logout request
if (isset($_GET['logout'])) {
    $user->logout();
}

// Include the HTML template
include "dashboard_view.php";
?>
