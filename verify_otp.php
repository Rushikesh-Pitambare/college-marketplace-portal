<?php
session_start();
require 'config.php'; // PDO connection

$success_message = "";

if (!isset($_SESSION['otp']) || !isset($_SESSION['email'])) {
    header("Location: forgot_password.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = trim($_POST['otp']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Check OTP
    if ($entered_otp == $_SESSION['otp']) {
        if ($new_password === $confirm_password) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update password in students table
            $stmt = $conn->prepare("UPDATE students SET password = :password WHERE email = :email");
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':email', $_SESSION['email']);
            $stmt->execute();

            unset($_SESSION['otp']);
            unset($_SESSION['email']);

            $success_message = "✅ Password updated successfully. You can now login.";
        } else {
            $_SESSION['error'] = "Passwords do not match.";
        }
    } else {
        $_SESSION['error'] = "Invalid OTP.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Verify OTP - College Marketplace</title>
    <?php if (!empty($success_message)): ?>
    <meta http-equiv="refresh" content="3;url=login.php" />
    <?php endif; ?>
    <style>
        * {
            box-sizing: border-box;
        }
        body, html {
            margin: 0; padding: 0; height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('bgimageforlogin.png') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 420px;
            padding: 30px 35px;
            text-align: center;
            animation: fadeIn 0.4s ease forwards;
            backdrop-filter: blur(6px);
        }
        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(-15px);}
            to {opacity: 1; transform: translateY(0);}
        }
        h2 {
            margin-bottom: 25px;
            font-weight: 700;
            color: #000;
            font-size: 28px;
        }
        form {
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #444;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1.8px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #0078D7;
            box-shadow: 0 0 8px #0078D7aa;
        }
        button {
            width: 100%;
            padding: 14px 0;
            background-color: #0078D7;
            border: none;
            color: white;
            font-size: 18px;
            font-weight: 700;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 12px #0078D7bb;
        }
        button:hover {
            background-color: #005a9e;
            box-shadow: 0 6px 15px #005a9ebb;
        }
        .message {
            padding: 12px 15px;
            border-radius: 6px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
            font-size: 15px;
        }
        .error {
            background-color: #ffe0e0;
            color: #b00020;
            border: 1px solid #b00020;
        }
        .success {
            background-color: #e0ffe0;
            color: #007a00;
            border: 1px solid #007a00;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Verify OTP & Reset Password</h2>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="message error">
            <?php 
                echo htmlspecialchars($_SESSION['error']); 
                unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success_message)): ?>
        <div class="message success">
            <?php echo htmlspecialchars($success_message); ?>
            <br><small>Redirecting to login page...</small>
        </div>
    <?php endif; ?>

    <?php if (empty($success_message)): ?>
    <form method="POST" novalidate>
        <label for="otp">Enter OTP:</label>
        <input type="text" id="otp" name="otp" required autocomplete="off" maxlength="6" placeholder="Enter your OTP">

        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required placeholder="New password">

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirm new password">

        <button type="submit">Change Password</button>
    </form>
    <?php endif; ?>
</div>

</body>
</html>
