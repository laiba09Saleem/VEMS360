<?php
session_start();
require_once __DIR__ . '/../config/connection.php';

if (isset($_GET['code'])) {
    $verification_code = trim($_GET['code']);

    // Prepare statement to check unverified user
    $stmt = $conn->prepare("SELECT * FROM form WHERE Verification_Code = ? AND Verified = 0 LIMIT 1");
    $stmt->bind_param("s", $verification_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Update user as verified
        $update = $conn->prepare("UPDATE form SET Verified = 1 WHERE Verification_Code = ?");
        $update->bind_param("s", $verification_code);
        $update->execute();

        // Create session for the verified user
        $_SESSION['User_ID'] = $user['ID'];
        $_SESSION['Username'] = $user['Username'];
        $_SESSION['Role'] = $user['Role'];

        // Redirect according to role
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
        echo "<div style='font-family:Poppins, sans-serif; text-align:center; margin-top:50px; color:#fff; background:#0d1117; padding:20px; border-radius:10px;'>Invalid or already verified code.</div>";
    }

    $stmt->close();
} else {
    echo "<div style='font-family:Poppins, sans-serif; text-align:center; margin-top:50px; color:#fff; background:#0d1117; padding:20px; border-radius:10px;'>No verification code provided.</div>";
}
?>
