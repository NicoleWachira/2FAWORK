<?php
session_start();
require 'dbconnect.php'; // Include your PDO database connection
require 'vendor/autoload.php'; // Include PHPMailer's autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];

    try {
        // Check if the user exists
        $stmt = $conn->prepare("SELECT * FROM clients WHERE Email = :Email");
        $stmt->bindParam(':Email', $Email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($Username && password_verify($Password, $Username['Password'])) {
            // Generate a 4-digit verification code
            $VerificationCode = rand(1000, 9999);

            // Save the code and email to the session
            $_SESSION['VerificationCode'] = $VerificationCode;
            $_SESSION['Email'] = $Email;

            // Send the verification code via email
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp@gmail.com'; // Replace with your SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'nicole.wachira@starthmore.edu'; // Your email
                $mail->Password = 'ykkvgsyipbhoplal';   // Your email password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('nicole.wachira@strathmore.ecu', 'CYCLA SYSTEMS');
                $mail->addAddress($Email, $Username['Username']);

                // Email content
                $mail->isHTML(true);
                $mail->Subject = 'Your Verification Code';
                $mail->Body    = "<p>Dear {$Username['Username']},</p>
                                  <p>Your verification code is: <strong>{$VerificationCode}</strong></p>
                                  <p>Enter this code on the verification page to access your account.</p>";

                $mail->AltBody = "Dear {$Username['Username']},\nYour verification code is: {$VerificationCode}";

                $mail->send();

                // Redirect to verify.php
                header('Location: verify.php');
                exit();
            } catch (Exception $e) {
                echo "Error sending email: {$mail->ErrorInfo}";
            }
        } else {
            echo "<div class='container mt-5'><div class='alert alert-danger text-center'>Invalid email or password.</div></div>";
        }
    } catch (PDOException $e) {
        echo "<div class='container mt-5'><div class='alert alert-danger text-center'>Database error: " . $e->getMessage() . "</div></div>";
    }
}
?>
