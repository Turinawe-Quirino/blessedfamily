<?php
require_once "flash.php";
// session is already started in flash.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Example credentials — replace with your secure logic
$env = parse_ini_file('.env');

$storedUsername = $env['ADMIN_USERNAME'];
$storedPasswordHash = $env['ADMIN_PASSWORD_HASH'];

$storedUsername = $env['ADMIN_USERNAME'];
$storedPasswordHash = $env['ADMIN_PASSWORD_HASH'];

    if ($username === $storedUsername && password_verify($password, $storedPasswordHash)) {
        $_SESSION['is_admin'] = true;
        setFlash('success', 'Logged in successfully.');
        header('Location: admin_approval.php');
        exit;
    } else {
        setFlash('error', 'Invalid username or password.');
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Login</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #0b0b0b, #1b1b1b);
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin:0;
    }
    .login-container {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.15);
      padding: 2.5rem;
      border-radius: 16px;
      text-align: center;
      width: 350px;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.3);
    }
    .login-container h1 {
      color: #1e90ff;
      margin-bottom: 1rem;
      font-size: 1.8rem;
      letter-spacing: 1px;
    }
    .login-container form {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    input[type="text"], input[type="password"] {
      padding: 10px;
      border: none;
      border-radius: 6px;
      background: #fff;
      font-size: 1rem;
      width: 100%;
      box-sizing: border-box;
    }
    .password-wrapper {
      position: relative;
    }
    .password-wrapper i {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      color: #555;
      cursor: pointer;
    }
    button {
      padding: 10px;
      background: #1e90ff;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s;
    }
    button:hover {
      background: #006edc;
    }
    .back-link {
      margin-top: 1rem;
      display: block;
      color: #1e90ff;
      text-decoration: none;
    }
    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h1>Admin Login</h1>
    <?php showFlash(); ?>
    <form method="post" action="admin_login.php">
      <input type="text" name="username" placeholder="Username" required>
      <div class="password-wrapper">
        <input type="password" name="password" id="password" placeholder="Password" required>
        <i class="fas fa-eye" id="togglePassword"></i>
      </div>
      <button type="submit">Login</button>
    </form>
    <a href="gallery.php" class="back-link">← Back to Site</a>
  </div>

  <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      this.classList.toggle('fa-eye-slash');
    });
  </script>
</body>
</html>
