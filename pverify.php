<?php

require 'dbconnect.php';

class Verification {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
        session_start();
    }

    // Combine the input digits into a single verification code
    private function getVerificationCode($postData) {
        return intval(trim($postData['digit1'] . $postData['digit2'] . $postData['digit3'] . $postData['digit4']));
    }

    // Validate the verification code against the session-stored code
    public function validateCode($postData) {
        if (!isset($_SESSION['VerificationCode'])) {
            throw new Exception("Verification code session is missing.");
        }

        $inputCode = $this->getVerificationCode($postData);
        return $inputCode === $_SESSION['VerificationCode'];
    }

    // Mark the user as verified in the database
    public function markAsVerified() {
        if (!isset($_SESSION['Email'])) {
            throw new Exception("Email session is missing.");
        }

        $Email = $_SESSION['Email'];
        $stmt = $this->conn->prepare("UPDATE clients SET IsVerified = 1 WHERE Email = :Email");
        $stmt->bindParam(':Email', $Email);
        $stmt->execute();

        // Clear session variables
        unset($_SESSION['VerificationCode']);
        unset($_SESSION['Email']);
    }

    // Main method to handle verification
    public function processVerification($postData) {
        try {
            if ($this->validateCode($postData)) {
                $this->markAsVerified();
                header("Location:Login.html");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Invalid verification code.</div>";
            }
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        }
    }
}
?>
