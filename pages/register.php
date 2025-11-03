<?php
session_start();
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../includes/mail/send_mail.php';

if (!defined('BASE_URL')) {
    define('BASE_URL', 'https://vems360.infinityfreeapp.com/');
}


$admin_exists = $conn->query("SELECT COUNT(*) AS c FROM form WHERE Role='Admin'")->fetch_assoc()['c'] > 0;
$organizer_exists = $conn->query("SELECT COUNT(*) AS c FROM form WHERE Role='Organizer'")->fetch_assoc()['c'] > 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $fname = trim($_POST['Fname']);
    $lname = trim($_POST['Lname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm-password'];
    $role = $_POST['role'];
    $verification_code = md5(uniqid(rand(), true));

    if ($password !== $confirm) {
        echo "<script>alert('Passwords do not match!');</script>";
    } elseif ($role === 'Admin' && $admin_exists) {
        echo "<script>alert('Only one Admin can be registered.');</script>";
    } elseif ($role === 'Organizer' && $organizer_exists) {
        echo "<script>alert('Only one Organizer can be registered.');</script>";
    } else {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO form (First_Name, Last_Name, Username, Email, Password, Role, Verified, Verification_Code)
                                VALUES (?, ?, ?, ?, ?, ?, 0, ?)");
        $stmt->bind_param("sssssss", $fname, $lname, $username, $email, $hashed, $role, $verification_code);

        if ($stmt->execute()) {
            // ✅ Correct verification link (auto base URL)
                  $verification_link = BASE_URL . "pages/verify.php?code=" . urlencode($verification_code);


            if (sendVerificationEmail($email, "$fname $lname", $verification_link)) {
                echo "<script>alert('Registration successful! Please check your email for verification.');</script>";
                echo "<script>window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('Email sending failed. Try again later.');</script>";
            }
        } else {
            echo "<script>alert('Error: Could not register user.');</script>";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register | VEMS360</title>
  <link rel="icon" href="../assets/images/logo.png" />
  <link rel="stylesheet" href="../assets/css/register.css" />
</head>
<body>
  <div class="register-wrapper">
    <div class="register-card">
      <div class="logo">
        <img src="../assets/images/logo.png" alt="VEMS360 Logo" />
      </div>
      <h2>Create Account</h2>

      <form method="POST" autocomplete="off" novalidate>
        <div class="grid">
          <input type="text" name="Fname" placeholder="First Name" required />
          <input type="text" name="Lname" placeholder="Last Name" required />
        </div>
        <input type="text" name="username" placeholder="Username" required />
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="password" name="confirm-password" placeholder="Confirm Password" required />

        <select name="role" required>
          <option value="">Select Role</option>
          <option value="User">User</option>
          <?php if (!$organizer_exists): ?><option value="Organizer">Organizer</option><?php endif; ?>
          <?php if (!$admin_exists): ?><option value="Admin">Admin</option><?php endif; ?>
        </select>

        <button type="submit" name="register">Sign Up</button>
      </form>

      <p class="login-link">Already have an account? <a href="login.php">Login here</a></p>
    </div>
  </div>
</body>
</html>
