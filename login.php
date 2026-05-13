<?php  
session_start();  
include("config.php"); // Ensure this defines $conn as a PDO connection  
  
$message = ''; // Initialize message variable  
  
if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    $email = trim($_POST["email"]);  
    $password = trim($_POST["password"]);  
  
    if (!empty($email) && !empty($password)) {  

        // ✅ Only allow @vpkbiet.org email domain
        if (!preg_match("/^[a-zA-Z0-9._%+-]+@vpkbiet\.org$/", $email)) {
            $message = "Only @vpkbiet.org email addresses are allowed.";
        } else {
            // Prepare statement securely  
            $stmt = $conn->prepare("SELECT * FROM students WHERE email = :email");  
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);  
            $stmt->execute();  
  
            $user = $stmt->fetch(PDO::FETCH_ASSOC);  
  
            if ($user && password_verify($password, $user['password'])) {  
                // ✅ Credentials valid  
                $_SESSION['user_id'] = $user['id'];  
                $_SESSION['user_email'] = $user['email'];  
  
                header("Location: homepagehtml.php");  
                exit();  
            } else {  
                $message = "Invalid email or password.";  
            }  
        }

    } else {  
        $message = "Please fill in all fields.";  
    }  
}  
?>  
<!DOCTYPE html>  
<html lang="en">  
<head>  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" crossorigin="anonymous">  
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>  
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" crossorigin="anonymous"></script>  
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" crossorigin="anonymous"></script>  
  <meta charset="UTF-8" />  
  <meta name="viewport" content="width=device-width, initial-scale=1" />  
  <title>College Marketplace - Dashboard Login</title>  
  <style>  
    *, *::before, *::after { box-sizing: border-box; }  
    body {  
      margin: 0; padding: 0; height: 100%;  
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;  
      background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),  
        url('bgimageforlogin.png') center/cover no-repeat;  
      height: 100vh;  
      display: flex;  
      justify-content: center;  
      align-items: center;  
    }  
    .login-container {  
      background: #fff;  
      border-radius: 12px;  
      box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 8px 24px rgba(0,0,0,0.08);  
      padding: 40px 35px;  
      width: 100%;  
      max-width: 400px;  
      display: flex;  
      flex-direction: column;  
      align-items: center;  
    }  
    .branding { text-align: center; margin-bottom: 8px; }  
    .brand-logo { width: 70px; height: 70px; border-radius: 8px; margin: 0 auto 6px auto; }  
    .logo-text { font-size: 30px; font-weight: 700; color: #0078D7; margin-bottom: 5px; }  
    h1 { font-weight: 600; font-size: 22px; margin: 5px 0 4px 0; text-align: center; }  
    .subtitle { font-size: 14px; color: #555; margin-bottom: 20px; text-align: center; }  
    form { width: 100%; }  
    label { display: block; font-weight: 600; font-size: 14px; margin-bottom: 6px; }  
    input[type="email"], input[type="password"] {  
      width: 100%; padding: 14px 16px; margin-bottom: 20px;  
      border: 1.5px solid #ccc; border-radius: 8px; font-size: 15px;  
      transition: border-color 0.3s ease, box-shadow 0.3s ease;  
    }  
    input:focus { outline: none; border-color: #0078D7; box-shadow: 0 0 8px #0078D7aa; }  
    .forgot-link { display: block; text-align: right; font-size: 13px; color: #0078D7; text-decoration: none; margin-top: -15px; margin-bottom: 25px; font-weight: 600; }  
    .forgot-link:hover { color: #005a9e; text-decoration: underline; }  
    button {  
      width: 100%; background-color: #0078D7; border: none; padding: 16px 0;  
      border-radius: 8px; color: white; font-size: 17px; font-weight: 700; cursor: pointer;  
    }  
    button:hover { background-color: #005a9e; }  
    .signup-text { margin-top: 25px; font-size: 14px; text-align: center; }  
    .signup-text a { color: #0078D7; font-weight: 700; text-decoration: none; margin-left: 6px; }  
    .signup-text a:hover { color: #005a9e; text-decoration: underline; }  
    #msg {  
      position: fixed; top: 20px; left: 50%; transform: translateX(-50%);  
      background: #ff3b3b; color: white; padding: 14px 28px; border-radius: 6px;  
      box-shadow: 0 2px 12px rgba(0,0,0,0.15); font-weight: 600; font-size: 16px;  
      max-width: 90%; text-align: center; z-index: 1000;  
    }  
    @media (max-width: 450px) {  
      .login-container { padding: 30px 25px; max-width: 95vw; }  
    }  
  </style>  
</head>  
<body>  
  
<?php if ($message): ?>  
  <div id="msg"><?php echo htmlspecialchars($message); ?></div>  
  <script>setTimeout(() => { document.getElementById('msg').style.display = 'none'; }, 3000);</script>  
<?php endif; ?>  
  
<div class="login-container">  
  <div class="branding">  
    <img src="logo.jpeg" alt="College Marketplace Logo" class="brand-logo">  
    <div class="logo-text">CollegeMarket</div>  
  </div>  
  
  <h1>Dashboard Sign In</h1>  
  <p class="subtitle">Access your college marketplace dashboard securely</p>  
  
  <form method="POST" action="login.php" novalidate>  
    <label for="email">What's your email?</label>  
    <input type="email" id="email" name="email" placeholder="you@vpkbiet.org" required />  
  
    <label for="password">Your password?</label>  
    <input type="password" id="password" name="password" placeholder="Enter your password" required />  
  
    <a href="forgot_password.php" class="forgot-link">Forgot password?</a>  
    <button type="submit">Sign In</button>  
  </form>  
  
  <p class="signup-text">  
    Don't have an account?  
    <a href="signup.php">Sign Up</a>  
  </p>  
</div>  
  
</body>  
</html>