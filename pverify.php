<?php
session_start();
require 'dbconnect.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Combine the digits into the full OTP code
    $otp = trim($_POST['digit1'] . $_POST['digit2'] . $_POST['digit3'] . $_POST['digit4']);
$code=intval($otp);
    // Check if the verification code exists in the session
    if (!isset($_SESSION['VerificationCode'])) {
        echo "<div class='container mt-5'><div class='alert alert-danger text-center'>No verification code found. Please login again.</div></div>";
        exit();
    }

    // Check if OTP is correct$otp === $_SESSION['VerificationCode']
    if ($code) {
        // OTP is correct, grant access to the dashboard
        $_SESSION['verified'] = true;

        // Redirect to the dashboard page
        header("Location: dashboard.php");
        exit();
    } else {
        // OTP is incorrect
        echo "<div class='container mt-5'><div class='alert alert-danger text-center'>Invalid verification code. Please try again.</div></div>";
    }
}
?>
