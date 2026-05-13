<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>College Marketplace Portal</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f0f4f8;
      color: #333;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    header {
      background-color: #0078D7;
      color: white;
      padding: 20px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 10;
    }
    header .logo {
      font-size: 26px;
      font-weight: bold;
    }
    nav a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s ease;
    }
    nav a:hover {
      color: #d1eaff;
    }

    .hero {
      position: relative;
      height: 100vh;
      background: url('6a0cfb12-627e-4f1b-a801-88242d4f0122.png') center center / cover no-repeat;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: white;
    }

    .hero::before {
      content: "";
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0, 0, 0, 0.5); /* dark overlay */
      z-index: 1;
    }

    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 700px;
      padding: 20px;
    }

    .hero-content h1 {
      font-size: 48px;
      margin-bottom: 20px;
    }

    .hero-content p {
      font-size: 20px;
      margin-bottom: 30px;
    }

    .hero-content a {
      background-color: #0078D7;
      color: white;
      padding: 14px 28px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }

    .hero-content a:hover {
      background-color: #005a9e;
    }

    footer {
      text-align: center;
      padding: 15px;
      background-color: #f5f5f5;
      font-size: 14px;
      color: #777;
    }
  </style>
</head>
<body>

<header>
  <div class="logo">CollegeMarketplace</div>
  <nav>
    <a href="index.php">Home</a>
    <a href="login.php">Sign In</a>
    <a href="signup.php">Register</a>
  </nav>
</header>

<section class="hero">
  <div class="hero-content">
    <h1>Welcome to the College Marketplace</h1>
    <p>Buy, sell, and connect with your campus community.<br>Sign in or register to explore student deals.</p>
    <a href="signup.php">Get Started</a>
  </div>
</section>

<footer>
  &copy; <?php echo date("Y"); ?> College Marketplace Portal. All rights reserved.
</footer>

</body>
</html>
