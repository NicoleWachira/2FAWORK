<?php
session_start();
require_once 'dbconnect.php';  // Make sure dbconnect.php is included to access Database class
require_once 'PHPMailer/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Instantiate Database class to get a PDO connection
$db = new Database();
$conn = $db->getConnection();  // Use PDO connection from the Database class

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'])) {
        // Handle sending reset email
        $email = $_POST['email'];

        // Check if email exists in the database
        $stmt = $conn->prepare("SELECT * FROM clients WHERE Email = :Email");
        $stmt->bindParam(':Email', $email);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            die("Email not found in the system.");
        }

        // Generate reset code
        $resetCode = rand(100000, 999999);
        $_SESSION['reset_code'] = $resetCode;
        $_SESSION['reset_email'] = $email;

        // Send the reset code via email
        $mail = new PHPMailer(true);

        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'nicole.wachira2@gmail.com'; // Replace with your email
            $mail->Password = 'ybcahlwsyjoolugj';   // Replace with your email app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Email settings
            $mail->setFrom('nicole.wachira2@gmail.com', 'CYCLA SYSTEMS'); // Replace with your email and name
            $mail->addAddress($email); // Recipient's email
            $mail->isHTML(true);
            $mail->Subject = 'CYCLA SYSTEMS Password Reset Code';
            $mail->Body = "Hi,<br><br>Your password reset code is: <strong>$resetCode</strong>.<br><br>Use this code to reset your password.<br><br>Thank you.";

            $mail->send();

            // Redirect to resetcode.html after sending the email
            header("Location: resetcode.html");
            exit; // Ensure no further code is executed
        } catch (Exception $e) {
            die("Failed to send email. Error: {$mail->ErrorInfo}");
        }
    } elseif (isset($_POST['code'])) {
        // Verify reset code
        $code = $_POST['code'];

        if ($code != $_SESSION['reset_code']) {
            die("Invalid reset code.");
        }

        $_SESSION['code_verified'] = true;
        header("Location: snp.html"); // Redirect to the set new password page
        exit;

    } elseif (isset($_POST['newPassword'], $_POST['confirmPassword'])) {
        // Reset password
        if (!isset($_SESSION['code_verified']) || !$_SESSION['code_verified']) {
            die("Unauthorized access. Verify code first.");
        }

        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        if ($newPassword !== $confirmPassword) {
            die("Passwords do not match.");
        }

        // Update password in the database
        $email = $_SESSION['reset_email'];
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update password in the database using PDO
        $stmt = $conn->prepare("UPDATE clients SET Password = :Password WHERE Email = :Email");
        $stmt->bindParam(':Password', $hashedPassword);
        $stmt->bindParam(':Email', $email);
        $stmt->execute();

        // Clear session
        session_destroy();

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        die("Invalid request.");
    }
} else {
    die("Invalid request method.");
}
