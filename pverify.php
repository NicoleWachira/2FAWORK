<?php
session_start();
require 'dbconnect.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Combine the digits into the full OTP code
    $otp = $_POST['digit1'] . $_POST['digit2'] . $_POST['digit3'] . $_POST['digit4'];

    if (!isset($_SESSION['VerificationCode'])) {
        echo "<div class='container mt-5'><div class='alert alert-danger text-center'>No verification code found. Please login again.</div></div>";
        exit();
    }

    // Verify OTP
    if ($otp === $_SESSION['VerificationCode']) {
        // OTP is correct, grant access to the dashboard
        $_SESSION['verified'] = true;

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        // OTP is incorrect
        echo "<div class='container mt-5'><div class='alert alert-danger text-center'>Invalid verification code. Please try again.</div></div>";
    }
}
?>
