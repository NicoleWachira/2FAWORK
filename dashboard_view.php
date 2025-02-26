<?php
class Dashboard {
    private $username;
    private $email;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user'])) {
            header("Location: Login.html");
            exit();
        }

        $user = $_SESSION['user'];
        $this->username = htmlspecialchars($user['Username'] ?? 'Guest');
        $this->email = htmlspecialchars($user['Email'] ?? 'No email available');
    }

    public function render() {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>User Dashboard</title>
            <link rel="stylesheet" href="dashboard.css">
        </head>
        <body>
            <!-- Sidebar -->
            <div class="sidebar">
                <ul>
                    <li><a href="Home.php">Home</a></li>
                    <li><a href="dashboard_view.php" class="active">Profile</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="logout.php" class="logout">Logout</a></li>
                </ul>
            </div>
            
            <!-- Content -->
            <div class="content">
                <div class="dashboard-card">
                    <h1>Welcome, <?= $this->username; ?>!</h1>
                    <p><strong>Email:</strong> <?= $this->email; ?></p>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
}

$page = new Dashboard();
$page->render();
?>
