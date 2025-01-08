<?php
require 'dbconnect.php'; // Include the database connection file
require 'PHPMailer/vendor/autoload.php'; // Autoload PHPMailer (Ensure PHPMailer is installed via Composer)

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize form data
    $Username = trim($_POST['Username']);
    $Email = trim($_POST['Email']);
    $Password = password_hash($_POST['Password'], PASSWORD_DEFAULT); // Hash the password for security

    // Validate email format
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert alert-danger'>Invalid email format.</div>";
        exit();
    }

    try {
        // Check if the email already exists
        $checkStmt = $conn->prepare("SELECT * FROM clients WHERE Email = :Email");
        $checkStmt->bindParam(':Email', $Email);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            echo "<div class='alert alert-danger'>Email already exists. Please use a different email.</div>";
            exit();
        }

        // Insert user data into the database
        $stmt = $conn->prepare("INSERT INTO clients (Username, Email, Password) VALUES (:Username, :Email, :Password)");
        $stmt->bindParam(':Username', $Username);
        $stmt->bindParam(':Email', $Email);
        $stmt->bindParam(':Password', $Password);
        $stmt->execute();

        // Generate a random 4-digit verification code
        $VerificationCode = rand(1000, 9999);

        // Start session and store the verification code and email
        session_start();
        $_SESSION['VerificationCode'] = $VerificationCode;
        $_SESSION['Email'] = $Email;

        // Send email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Configure SMTP settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nicole.wachira2@gmail.com'; // Replace with your email
            $mail->Password = 'ybcahlwsyjoolugj';   // Replace with your app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Set email recipients and content
            $mail->setFrom('nicole.wachira2@gmail.com', 'CYCLA SYSTEMS');
            $mail->addAddress($Email); // Add recipient
            $mail->isHTML(true);
            $mail->Subject = 'CYCLA SYSTEMS Verification Code';
            $mail->Body = "Hi $Username,<br>Your verification code is: <strong>$VerificationCode</strong>.<br>Thank you for registering.";

            $mail->send();

            // Redirect to the verification page
            header("Location: verify.php");
            exit();
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>Error: {$mail->ErrorInfo}</div>";
        }
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Database error: " . $e->getMessage() . "</div>";
    }
}
?>
