<?php
session_start();

// Check if user is verified
if (!isset($_SESSION['verified']) || $_SESSION['verified'] !== true) {
    header("Location: Login.php");
    exit();
}

$Username = $_SESSION['Username'];
$Email = $_SESSION['Email'];
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
            <h2 class="text-center mb-4">Welcome, <?php echo htmlspecialchars($Username); ?>!</h2>
            <p class="text-center">You have successfully logged in and verified your account.</p>
            <div class="mt-4">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" class="form-control" value="<?php echo htmlspecialchars($Username); ?>" readonly>

                <label for="email" class="form-label mt-3">Email</label>
                <input type="email" id="email" class="form-control" value="<?php echo htmlspecialchars($Email); ?>" readonly>
            </div>
            <p class="text-center mt-4">
                <!-- Use the btn-blue class for the blue button -->
                <a href="Login.php" class="btn btn-blue">Logout</a>
            </p>
        </div>
    </div>
</body>
</html>
