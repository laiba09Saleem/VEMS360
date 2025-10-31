<?php
session_start();
require_once __DIR__ . '/../config/connection.php';

// Set content type and background for quick message display
echo '<body style="font-family:Poppins, sans-serif; background:#0d1117; color:#fff; text-align:center; margin-top:100px;">';

if (isset($_GET['code']) && !empty($_GET['code'])) {
    $verification_code = trim($_GET['code']);

    // Check if verification code exists and user is not verified yet
    $stmt = $conn->prepare("SELECT * FROM form WHERE Verification_Code = ? AND Verified = 0 LIMIT 1");
    $stmt->bind_param("s", $verification_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Update user as verified and clear the verification code
        $update = $conn->prepare("UPDATE form SET Verified = 1, Verification_Code = NULL WHERE Verification_Code = ?");
        $update->bind_param("s", $verification_code);
        $update->execute();

        // Start session for verified user
        $_SESSION['User_ID'] = $user['ID'];
        $_SESSION['Username'] = $user['Username'];
        $_SESSION['Role'] = $user['Role'];

        echo "<h2>Email Verified Successfully 🎉</h2>";
        echo "<p>Your account has been verified. Redirecting to your dashboard...</p>";

        // Redirect by role
        echo "<script>
                setTimeout(function() {";

        switch ($user['Role']) {
            case 'Admin':
                echo "window.location.href = '../dashboard/admin_dashboard.php';";
                break;
            case 'Organizer':
                echo "window.location.href = '../dashboard/organizer_dashboard.php';";
                break;
            default:
                echo "window.location.href = '../dashboard/user_dashboard.php';";
                break;
        }

        echo "}, 2500);
              </script>";

    } else {
        echo "<h2>⚠️ Invalid or Already Verified Link</h2>";
        echo "<p>This verification link has expired or was already used.</p>";
    }

    $stmt->close();
} else {
    echo "<h2>❌ No Verification Code Provided</h2>";
    echo "<p>Please check your verification link or contact support.</p>";
}

echo '</body>';
?>
