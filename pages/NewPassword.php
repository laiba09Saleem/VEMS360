<?php
session_start();
include __DIR__ . '/../config/connection.php'; // Correct path to connection.php

$showForm = false;
$message = "";

// Get token and email from URL
if (isset($_GET['token'], $_GET['email'])) {
    $token = $_GET['token'];
    $email = $_GET['email'];

    // Check if token is valid and not expired
    $query = "SELECT * FROM password_reset WHERE email = ? AND token = ? AND expiry >= NOW() LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $showForm = true; // Show password reset form
    } else {
        $message = "Invalid or expired reset link. Request a new link.";
    }
    $stmt->close();
} else {
    $message = "Invalid request.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ResetPassword'])) {
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        $message = "Passwords do not match!";
        $showForm = true;
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update password in users table
        $update = $conn->prepare("UPDATE form SET Password = ? WHERE Email = ?");
        $update->bind_param("ss", $hashedPassword, $email);

        if ($update->execute()) {
            // Delete used token
            $delete = $conn->prepare("DELETE FROM password_reset WHERE email = ?");
            $delete->bind_param("s", $email);
            $delete->execute();
            $delete->close();

            $message = "Password has been updated successfully. You can now login.";
            $showForm = false;
        } else {
            $message = "Failed to update password. Please try again.";
            $showForm = true;
        }
        $update->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reset Password | VEMS360</title>
  <link rel="icon" href="../assets/images/logo.png" />
  <link rel="stylesheet" href="../assets/css/login.css" />
</head>
<body>
  <div class="login-wrapper">
    <div class="login-card">
      <div class="logo">
        <img src="../assets/images/logo.png" alt="VEMS360 Logo" />
      </div>
      <h2>Set New Password</h2>

      <?php if ($message): ?>
        <p style="color: #ff6464; margin-bottom: 15px; text-align: center;"><?= htmlspecialchars($message); ?></p>
      <?php endif; ?>

      <?php if ($showForm): ?>
        <form method="POST" autocomplete="off" novalidate>
          <input type="password" name="password" placeholder="New Password" required />
          <input type="password" name="confirm_password" placeholder="Confirm New Password" required />
          <button type="submit" name="ResetPassword">Reset Password</button>
        </form>
      <?php else: ?>
        <p style="text-align: center; margin-top: 15px;">
          <a href="login.php" style="color: #2a9d8f;">Back to Login</a>
        </p>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
