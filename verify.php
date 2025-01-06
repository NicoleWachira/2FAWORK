<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .otp-input {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .otp-digit {
            width: 50px;
            height: 50px;
            font-size: 24px;
            text-align: center;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Account Verification</h2>
        <p class="text-center">Enter the four-digit verification code sent to your email.</p>
        <form method="POST" action="pverify.php">
            <div class="otp-input">
                <input type="text" name="digit1" maxlength="1" class="otp-digit" required>
                <input type="text" name="digit2" maxlength="1" class="otp-digit" required>
                <input type="text" name="digit3" maxlength="1" class="otp-digit" required>
                <input type="text" name="digit4" maxlength="1" class="otp-digit" required>
            </div>
            <button type="submit" class="btn btn-primary mt-4 d-block mx-auto">Verify</button>
        </form>
    </div>
</body>
</html>
