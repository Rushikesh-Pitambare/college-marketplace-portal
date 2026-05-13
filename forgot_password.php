<?php
session_start();
require 'config.php'; // PDO connection
require 'vendor/autoload.php'; // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);

    // Check if email exists
    $stmt = $conn->prepare("SELECT * FROM students WHERE email = :email LIMIT 1");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Generate OTP & save in session
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        // Send OTP email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'vpkbietcollagemarketplace@gmail.com';       // YOUR Gmail
            $mail->Password   = 'vwis lhmp zmmw rsrh';          // YOUR Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('vpkbietcollagemarketplace@gmail.com', 'CollegeMarketplace Portal');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your Password Reset OTP - College Marketplace';

$mail->Body = '
<html>
<head>
<style>
    body { font-family: Arial, sans-serif; color: #333; }
    .otp { 
        font-size: 22px; 
        color: #0072ff; 
        font-weight: bold; 
        letter-spacing: 2px;
        margin: 10px 0;
    }
    .container {
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background: #f9f9f9;
    }
</style>
</head>
<body>
    <div class="container">
        <p>Dear Student,</p>

        <p>We received a request to reset your <strong>College Marketplace Portal</strong> password.</p>

        <p>Your One-Time Password (OTP) is:</p>

        <p class="otp">'.$otp.'</p>

        <p>Please enter this code on the password reset page within the next <strong>10 minutes</strong>.</p>

        <p>If you did not request a password reset, please ignore this message — your account is safe.</p>

        <br>
        <p>Best regards,<br>
        <strong>College Marketplace Support Team</strong></p>
    </div>
</body>
</html>
';

            $mail->send();

            $_SESSION['message'] = "OTP sent to $email";
            header('Location: verify_otp.php');
            exit();

        } catch (Exception $e) {
            $error = "Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        $error = "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Forgot Password - College Marketplace</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style>
    body {
        font-family: Arial, sans-serif;
        background: url('bgimageforlogin.png') no-repeat center center fixed;
        background-size: cover;
        height: 100vh;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .container {
        background: rgba(255, 255, 255, 0.95);
        padding: 30px;
        border-radius: 12px;
        width: 360px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        text-align: center;
        backdrop-filter: blur(6px);
    }
    h2 {
        margin-bottom: 20px;
        color: #333;
    }
    input[type="email"] {
        width: 100%;
        padding: 12px;
        margin: 8px 0 20px 0;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 15px;
        outline: none;
    }
    input:focus {
        border-color: #0072ff;
        box-shadow: 0 0 6px rgba(0,114,255,0.5);
    }
    button {
        background: #0072ff;
        color: white;
        border: none;
        padding: 14px;
        border-radius: 8px;
        width: 100%;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    button:hover {
        background: #0056cc;
    }
    .message {
        margin-bottom: 15px;
        font-weight: 600;
    }
    .error {
        color: #d93025;
    }
    .success {
        color: #188038;
    }
</style>
</head>
<body>
<div class="container">
    <h2>Forgot Password</h2>
     <p style="font-size:14px; color:#555; margin-top:-10px; margin-bottom:20px;">
    Enter your registered email address so we can reset your password.
    </p>

    <?php if (!empty($error)): ?>
        <p class="message error"><?= htmlspecialchars($error) ?></p>
    <?php elseif (!empty($_SESSION['message'])): ?>
        <p class="message success"><?= htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></p>
    <?php endif; ?>

    <form method="POST" novalidate>
        <input type="email" name="email" placeholder="Enter your registered email" required autocomplete="email" />
        <button type="submit">Send OTP</button>
    </form>
</div>
</body>
</html>
