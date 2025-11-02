<?php
session_start();
require_once __DIR__ . '/../config/connection.php';
/*
// Security check: only Admin can access
if (!isset($_SESSION['User_ID']) || $_SESSION['Role'] !== 'Admin') {
    header("Location: ../pages/login.php");
    exit();
}
*/
// Make sure User_ID exists before fetching
$user_id = $_SESSION['User_ID'] ?? null;

if ($user_id) {
    $query = "SELECT Username, Email, Role, created_at FROM form WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $stmt->close();
} else {
    $admin = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Profile | VEMS360</title>
  <link rel="icon" href="../assets/images/logo.png">
  <link rel="stylesheet" href="assets/css/admin.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="logo">
      <img src="../assets/images/logo.png" alt="VEMS360 Logo">
      <h2>VEMS360 Admin</h2>
    </div>
    <ul class="menu">
      <li><a href="dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
      <li><a href="manage_user.php"><i class="fa-solid fa-users"></i> Manage Users</a></li>
      <li><a href="manage_events.php"><i class="fa-solid fa-calendar"></i> Manage Events</a></li>
      <li><a href="manage_reports.php"><i class="fa-solid fa-flag"></i> Reports</a></li>
      <li><a href="ratings.php"><i class="fa-solid fa-star"></i> Ratings</a></li>
      <li><a href="contact_messages.php"><i class="fa-solid fa-envelope"></i> Messages</a></li>
      <li><a href="profile.php" class="active"><i class="fa-solid fa-user"></i> Profile</a></li>
      <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
    </ul>
  </aside>

  <!-- Main Content -->
  <main class="dashboard">
    <h1>Admin Profile</h1>

    <?php if ($admin): ?>
      <div class="profile-card">
        <div class="profile-info">
          <h2><?= htmlspecialchars($admin['Username'] ?? '') ?></h2>
          <p><strong>Email:</strong> <?= htmlspecialchars($admin['Email'] ?? '') ?></p>
          <p><strong>Role:</strong> <?= htmlspecialchars($admin['Role'] ?? '') ?></p>
          <p><strong>Joined:</strong> <?= htmlspecialchars($admin['created_at'] ?? '') ?></p>
        </div>
        <div class="profile-actions">
          <a href="../pages/ForgetPassword.php" class="btn small primary"><i class="fa-solid fa-key"></i> Change Password</a>
        </div>
      </div>
    <?php else: ?>
      <p style="color:#f00;">Admin data not found.</p>
    <?php endif; ?>
  </main>

</body>
</html>
