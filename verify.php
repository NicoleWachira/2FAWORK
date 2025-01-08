<?php
session_start();
require 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Combine the four input fields into one verification code
    $otp = trim($_POST['digit1'] . $_POST['digit2'] . $_POST['digit3'] . $_POST['digit4']);
    $inputCode = intval($otp);

    if (isset($_SESSION['VerificationCode']) && $inputCode == $_SESSION['VerificationCode']) {
        try {
            $Email = $_SESSION['Email'];
            $stmt = $conn->prepare("UPDATE clients SET IsVerified = 1 WHERE Email = :Email");
            $stmt->bindParam(':Email', $Email);
            $stmt->execute();

            // Clear session variables
            unset($_SESSION['VerificationCode']);
            unset($_SESSION['Email']);

            // Redirect to login
            header("Location: Login.php");
            exit();
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Invalid verification code.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="verify.css" rel="stylesheet">
    
</head>
<body>
<div class="container">
    <h2>Account Verification</h2>
    <form method="POST">
        <label for="VerificationCode" class="form-label">Verification Code</label>
        <div class="otp-input">
            <input type="text" maxlength="1" class="otp-digit" name="digit1" required>
            <input type="text" maxlength="1" class="otp-digit" name="digit2" required>
            <input type="text" maxlength="1" class="otp-digit" name="digit3" required>
            <input type="text" maxlength="1" class="otp-digit" name="digit4" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Verify</button>
    </form>
</div>

<script>
        // Auto move focus to the next input after entering a digit
        function moveFocus(current, nextFieldName) {
            if (current.value.length === 1) {
                document.getElementsByName(nextFieldName)[0].focus();
            }
        }
    </script>
    <script src="verify.js"></script>
</body>
</html>
