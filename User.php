<?php
require_once 'dbconnect.php'; // Include the database connection file
require_once 'PHPMailer/vendor/autoload.php'; // Autoload PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class User {
    private $username;
    private $email;
    private $password;
    private $role;  // Add role property
    private $conn;
    private $verificationCode;

    public function __construct($username, $email, $password, $role, $conn) {
        $this->username = $username;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
        $this->role = $role;  // Assign role
        $this->conn = $conn;
    }

    // Validate email format
    public function isValidEmail() {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    // Check if the email already exists in the database
    public function isEmailExists() {
        $checkStmt = $this->conn->prepare("SELECT * FROM clients WHERE Email = :Email");
        $checkStmt->bindParam(':Email', $this->email);
        $checkStmt->execute();
        return $checkStmt->rowCount() > 0;
    }

    // Insert the user into the database
    public function insert() {
        $stmt = $this->conn->prepare("INSERT INTO clients (Username, Email, Password, Role) VALUES (:Username, :Email, :Password, :Role)");
        $stmt->bindParam(':Username', $this->username);
        $stmt->bindParam(':Email', $this->email);
        $stmt->bindParam(':Password', $this->password);
        $stmt->bindParam(':Role', $this->role);
        $stmt->execute();
    }

    // Generate a random verification code
    public function generateVerificationCode() {
        return rand(1000, 9999);
    }

    // Send email with the verification code
    public function sendVerificationEmail($verificationCode) {
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
            $mail->addAddress($this->email); // Add recipient
            $mail->isHTML(true);
            $mail->Subject = 'CYCLA SYSTEMS Verification Code';
            $mail->Body = "Hi $this->username,<br>Your verification code is: <strong>$verificationCode</strong>.<br>Thank you for registering.";

            $mail->send();
        } catch (Exception $e) {
            throw new Exception("Error: {$mail->ErrorInfo}");
        }
    }

    // Register the user: validate, insert, and send email
    public function register() {
        if (!$this->isValidEmail()) {
            throw new Exception("Invalid email format.");
        }

        if ($this->isEmailExists()) {
            throw new Exception("Email already exists. Please use a different email.");
        }

        $this->insert();

        // Generate verification code and send email
        $this->verificationCode = $this->generateVerificationCode();
        session_start();
        $_SESSION['VerificationCode'] = $this->verificationCode;
        $_SESSION['Email'] = $this->email;
        $this->sendVerificationEmail($this->verificationCode);
    }
} // Ensure this closing brace is at the end of the class
?>
