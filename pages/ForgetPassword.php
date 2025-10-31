<?php
session_start();
require_once __DIR__ . '/../config/connection.php';

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    if (!empty($email)) {
        $stmt = $conn->prepare("SELECT * FROM form WHERE Email = ? AND Verified = 1 LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // For now, we just display a success message
            // In production, you’d send a reset link via email
            $success = "A password reset link has been sent to your email (simulation).";
        } else {
            $error = "No verified account found with this email.";
        }

        $stmt->close();
    } else {
        $error = "Please enter your registered email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Forgot Password | VEMS360</title>
  <link rel="icon" href="../assets/images/logo.png" />
  <link rel="stylesheet" href="../assets/css/login.css" />
</head>
<body>
<div class="login-wrapper">
  <div class="login-card">
    <div class="logo">
      <img src="../assets/images/logo.png" alt="VEMS360 Logo" />
    </div>
    <h2>Forgot Password</h2>

    <?php if ($success): ?>
        <div class="alert success"><?= $success; ?></div>
    <?php elseif ($error): ?>
        <div class="alert error"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST" autocomplete="off" novalidate>
      <input type="email" name="email" placeholder="Enter your registered email" required />
      <button type="submit">Send Reset Link</button>
    </form>

    <p class="signup-link"><a href="login.php">Back to Login</a></p>
  </div>
</div>
</body>
</html>
