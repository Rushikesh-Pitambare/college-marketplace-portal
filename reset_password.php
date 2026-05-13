<?php
session_start();
include("db/config.php");

$message = "";

// Check if email exists in session
if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot_password.php");
    exit;
}

$email = $_SESSION['reset_email'];
$otp_verified = false; // control if OTP verified

// Step 1: Verify OTP
if (isset($_POST['verify_otp'])) {
    $otp_entered = trim($_POST['otp']);

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user) {
        $user_id = $user['id'];

        $stmt2 = $conn->prepare("SELECT id, otp_hash, expires_at FROM password_resets WHERE user_id = ? ORDER BY id DESC LIMIT 1");
        $stmt2->bind_param("i", $user_id);
        $stmt2->execute();
        $reset = $stmt2->get_result()->fetch_assoc();

        if ($reset) {
            if (new DateTime() > new DateTime($reset['expires_at'])) {
                $message = "❌ OTP expired. Request again.";
                unset($_SESSION['reset_email']);
            } elseif (password_verify($otp_entered, $reset['otp_hash'])) {
                $message = "✅ OTP verified. Enter new password below.";
                $_SESSION['otp_verified'] = true;
                $otp_verified = true;
            } else {
                $message = "❌ Invalid OTP.";
            }
        } else {
            $message = "❌ No OTP found. Request again.";
        }
    }
}

// Step 2: Update Password
if (isset($_POST['update_pass']) && isset($_SESSION['otp_verified']) && $_SESSION['otp_verified'] === true) {
    $new_pass = trim($_POST['new_password']);
    $confirm_pass = trim($_POST['confirm_password']);

    if ($new_pass !== $confirm_pass) {
        $message = "❌ Passwords do not match.";
        $otp_verified = true;
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $user_id = $user['id'];

        $stmt2 = $conn->prepare("SELECT id FROM password_resets WHERE user_id = ? ORDER BY id DESC LIMIT 1");
        $stmt2->bind_param("i", $user_id);
        $stmt2->execute();
        $reset = $stmt2->get_result()->fetch_assoc();

        $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);
        $stmt3 = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt3->bind_param("si", $new_hash, $user_id);
        $stmt3->execute();

        $stmt4 = $conn->prepare("DELETE FROM password_resets WHERE id = ?");
        $stmt4->bind_param("i", $reset['id']);
        $stmt4->execute();

        unset($_SESSION['reset_email']);
        unset($_SESSION['otp_verified']);
        $message = "✅ Password reset successful. <a href='login.php'>Login here</a>";
    }
}

// Show OTP form only if OTP is not yet verified
if (!isset($_SESSION['otp_verified'])) {
    $show_otp_form = true;
} else {
    $show_otp_form = false;
    $otp_verified = true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        body { font-family: Arial; background:#f0f8ff; display:flex; justify-content:center; align-items:center; height:100vh; }
        .box { background:#fff; padding:25px 30px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); width:350px; text-align:center; }
        input, button { width:100%; padding:10px; margin:8px 0; border-radius:6px; border:1px solid #ccc; }
        button { background:#4da6ff; color:white; border:none; font-weight:bold; cursor:pointer; }
        button:hover { background:#1a8cff; }
        .msg { margin-top:10px; font-weight:bold; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Reset Password</h2>

        <?php if ($show_otp_form): ?>
        <!-- Step 1: Enter OTP -->
        <form method="POST">
            <input type="text" name="otp" placeholder="Enter OTP" required>
            <button type="submit" name="verify_otp">Verify OTP</button>
        </form>
        <?php endif; ?>

        <?php if ($otp_verified): ?>
        <!-- Step 2: Enter New Password -->
        <form method="POST">
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit" name="update_pass">Update Password</button>
        </form>
        <?php endif; ?>

        <p class="msg"><?php echo $message; ?></p>
    </div>
</body>
</html>
