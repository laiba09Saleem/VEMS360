<?php
session_start();
require_once __DIR__ . '/../config/connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Email Verification | VEMS360</title>
  <link rel="icon" href="../assets/images/logo.png" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #0d1117;
      color: #ffffff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .verify-container {
      background: #161b22;
      border: 1px solid #30363d;
      border-radius: 12px;
      padding: 40px 50px;
      max-width: 450px;
      text-align: center;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.2);
    }
    .verify-container img {
      width: 90px;
      margin-bottom: 20px;
    }
    h2 {
      color: #58a6ff;
      margin-bottom: 10px;
    }
    p {
      color: #c9d1d9;
      margin-bottom: 15px;
    }
    .success {
      color: #3fb950;
      font-weight: 500;
    }
    .error {
      color: #f85149;
      font-weight: 500;
    }
    .redirecting {
      color: #8b949e;
      font-size: 14px;
      margin-top: 10px;
    }
    @media (max-width: 480px) {
      .verify-container {
        padding: 30px 25px;
        width: 90%;
      }
    }
  </style>
</head>
<body>
  <div class="verify-container">
    <img src="../assets/images/logo.png" alt="VEMS360 Logo">

<?php
if (isset($_GET['code']) && !empty($_GET['code'])) {
    $verification_code = trim($_GET['code']);

    $stmt = $conn->prepare("SELECT * FROM form WHERE Verification_Code = ? AND Verified = 0 LIMIT 1");
    $stmt->bind_param("s", $verification_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Update verification
        $update = $conn->prepare("UPDATE form SET Verified = 1, Verification_Code = NULL WHERE Verification_Code = ?");
        $update->bind_param("s", $verification_code);
        $update->execute();

        $_SESSION['User_ID'] = $user['ID'];
        $_SESSION['Username'] = $user['Username'];
        $_SESSION['Role'] = $user['Role'];

        echo "<h2 class='success'>✅ Email Verified Successfully!</h2>";
        echo "<p>Your account has been successfully verified.</p>";
        echo "<p class='redirecting'>Redirecting to your dashboard...</p>";

        // Redirect based on role
        echo "<script>
                setTimeout(function() {";
        switch ($user['Role']) {
            case 'Admin':
                echo "window.location.href = '../admin/dashboard.php';";
                break;
            case 'Organizer':
                echo "window.location.href = 'welcome.php';";
                break;
            default:
                echo "window.location.href = 'pages/welcome.php';";
                break;
        }
        echo "}, 3000);
              </script>";

    } else {
        echo "<h2 class='error'>⚠️ Invalid or Already Verified Link</h2>";
        echo "<p>This verification link is invalid, expired, or already used.</p>";
    }
    $stmt->close();
} else {
    echo "<h2 class='error'>❌ Verification Code Missing</h2>";
    echo "<p>No verification code was provided in the URL.</p>";
}
?>
  </div>
</body>
</html>
