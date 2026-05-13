<?php
session_start();
$errors = [];

// DB Connection
$conn = new mysqli("localhost", "root", "", "collage_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enrollment = trim($_POST['enrollment_number']);
    $name = trim($_POST['name']);
    $mobile = trim($_POST['mobile']);
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $agree = isset($_POST['agree']);

    // Validation
    if (!$enrollment) $errors[] = "Enrollment number is required.";
    if (!$name) $errors[] = "Name is required.";
    if (!preg_match('/^[0-9]{10}$/', $mobile)) $errors[] = "Enter a valid 10-digit mobile number.";
    if (!$email) {
        $errors[] = "Valid email is required.";
    } elseif (!preg_match("/^[a-zA-Z0-9._%+-]+@vpkbiet\.org$/", $email)) {
        // ✅ Restrict to vpkbiet.org domain
        $errors[] = "Only @vpkbiet.org email addresses are allowed for registration.";
    }
    if (!$password) $errors[] = "Password is required.";
    if ($password !== $confirm_password) $errors[] = "Passwords do not match.";
    if (!$agree) $errors[] = "You must agree to the Portal Agreement and Privacy Policy.";

    // Check duplicates
    if (!$errors) {
        $stmt = $conn->prepare("SELECT id FROM students WHERE enrollment_number = ? OR email = ?");
        $stmt->bind_param("ss", $enrollment, $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = "Enrollment number or Email already exists.";
        }
        $stmt->close();
    }

    // Insert user
    if (!$errors) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO students (enrollment_number, name, mobaile_number, email, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $enrollment, $name, $mobile, $email, $hashed_password);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Registration successful! You can now sign in.";
            header("Location: login.php");
            exit;
        } else {
            $errors[] = "Database error: " . $stmt->error;
        }
        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Student Registration</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: 
            linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)),
            url('bgimageforlogin.png') center/cover no-repeat;
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }
    .container {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 100vh;
        padding-top: 30px;
    }
    .form-box {
        background: #fff;
        padding: 35px;
        width: 420px;
        border-radius: 8px;
        box-shadow: 0px 4px 20px rgba(0,0,0,0.15);
    }
    .logo {
        display: block;
        margin: -30px auto 15px;
        width: 70px;
        height: auto;
    }
    h1 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 26px;
        color: #333;
    }
    label {
        font-weight: bold;
        display: block;
        margin-top: 15px;
        margin-bottom: 5px;
        color: #555;
    }
    .input-group {
        position: relative;
    }
    .input-group input {
        width: 100%;
        padding: 12px 40px 12px 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        box-sizing: border-box;
    }
    .input-group .toggle-password {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 16px;
        color: #777;
        user-select: none;
    }
    input[type="text"], input[type="tel"], input[type="email"] {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 14px;
        box-sizing: border-box;
    }
    button {
        width: 100%;
        padding: 12px;
        background: #007bff;
        border: none;
        color: white;
        font-size: 16px;
        font-weight: bold;
        border-radius: 5px;
        margin-top: 20px;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    button:hover {
        background: #0056b3;
    }
    .error {
        background: #ffe5e5;
        color: #b30000;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
        font-size: 14px;
    }
    .signin-link {
        margin-top: 15px;
        text-align: center;
        font-size: 14px;
    }
    .signin-link a {
        color: #007bff;
        text-decoration: none;
    }
    .signin-link a:hover {
        text-decoration: underline;
    }
    .agreement {
        font-size: 13px;
        margin-top: 15px;
        color: #444;
    }
</style>
</head>
<body>
<div class="container">
    <div class="form-box">
        <img src="logo.jpeg" alt="College Logo" class="logo">
        <h1>Student Registration</h1>

        <?php if ($errors): ?>
            <div class="error">
                <ul style="margin:0; padding-left: 18px;">
                    <?php foreach ($errors as $err): ?>
                        <li><?php echo htmlspecialchars($err); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="enrollment_number">What's your enrollment number ?</label>
            <input type="text" id="enrollment_number" name="enrollment_number" value="<?php echo htmlspecialchars($_POST['enrollment_number'] ?? '') ?>" required>

            <label for="name">Your full name ?</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? '') ?>" required>

            <label for="mobile">Phone Number</label>
            <input type="tel" id="mobile" name="mobile" pattern="[0-9]{10}" value="<?php echo htmlspecialchars($_POST['mobile'] ?? '') ?>" required>

            <label for="email">Email address</label>
            <input type="email" id="email" name="email" placeholder="you@vpkbiet.org" value="<?php echo htmlspecialchars($_POST['email'] ?? '') ?>" required>

            <label for="password">Password</label>
            <div class="input-group">
                <input type="password" id="password" name="password" required>
                <span class="toggle-password" onclick="togglePassword('password')">👁</span>
            </div>

            <label for="confirm_password">Confirm Password</label>
            <div class="input-group">
                <input type="password" id="confirm_password" name="confirm_password" required>
                <span class="toggle-password" onclick="togglePassword('confirm_password')">👁</span>
            </div>

            <div class="agreement">
                <input type="checkbox" id="agree" name="agree" value="1" required>
                I agree to the <a href="#">Collagemarketplace Portal Agreement</a> and <a href="#">Privacy Policy</a>.
            </div>

            <button type="submit">Sign Up</button>
        </form>

        <div class="signin-link">
            Already have an account? <a href="login.php">Sign in</a>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    field.type = (field.type === "password") ? "text" : "password";
}
</script>
</body>
</html>