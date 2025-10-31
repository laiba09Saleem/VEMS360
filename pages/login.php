<?php
session_start();
require_once __DIR__ . '/../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email_or_username = trim($_POST['email_or_username']);
    $password = $_POST['password'];

    // Check if user exists
    $stmt = $conn->prepare("SELECT * FROM form WHERE (Email = ? OR Username = ?) AND Verified = 1 LIMIT 1");
    $stmt->bind_param("ss", $email_or_username, $email_or_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['Password'])) {
            // Store session variables
            $_SESSION['User_ID'] = $user['ID'];
            $_SESSION['Username'] = $user['Username'];
            $_SESSION['Role'] = $user['Role'];

            // Redirect based on role
            switch ($user['Role']) {
                case 'Admin':
                    header("Location: ../dashboard/admin_dashboard.php");
                    break;
                case 'Organizer':
                    header("Location: ../dashboard/organizer_dashboard.php");
                    break;
                default:
                    header("Location: ../dashboard/user_dashboard.php");
                    break;
            }
            exit;
        } else {
            echo "<script>alert('Incorrect password. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('Account not found or not verified.');</script>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | VEMS360</title>
  <link rel="icon" href="../assets/images/logo.png" />
  <link rel="stylesheet" href="../assets/css/login.css" />
</head>
<body>
  <div class="login-wrapper">
    <div class="login-card">
      <div class="logo">
        <img src="../assets/images/logo.png" alt="VEMS360 Logo" />
      </div>
      <h2>Login to VEMS360</h2>

      <form method="POST" autocomplete="off" novalidate>
        <input type="text" name="email_or_username" placeholder="Email or Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit" name="login">Login</button>
      </form>

      <p class="signup-link">Don't have an account? <a href="signin.php">Register here</a></p>
    </div>
  </div>
</body>
</html>
