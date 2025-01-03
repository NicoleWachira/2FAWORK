<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture and sanitize form inputs
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']); // Remove unnecessary whitespace
    $errors = []; // Initialize an array to hold errors

    // Validate username: only letters and white space allowed
    if (!preg_match("/^[a-zA-Z-']*$/", $username)) {
        $errors[] = "Only letters and white space are allowed in the Username field.";
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Ensure password is strong enough
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    // If there are validation errors, display them
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    } else {
        // Hash the password for secure storage
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // (Optional) Save data to the database
        // Example:
        // $db = new PDO("mysql:host=localhost;dbname=your_database", "username", "password");
        // $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        // $stmt->execute([$username, $email, $passwordHash]);

        // Success message
        echo "<h3>Thank you, $username. Your registration is complete.</h3>";
        echo "<p>Email: $email</p>";
        echo "<p>Password (hashed): $passwordHash</p>";
    }
}

// Helper function to sanitize inputs
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
