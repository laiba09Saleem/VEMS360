<?php
session_start();
require_once __DIR__ . '/../config/connection.php';

// Access control
//if (!isset($_SESSION['User_ID']) || $_SESSION['Role'] !== 'Admin') {
 //   header("Location: ../pages/login.php");
 //   exit();
//}

// Fetch counts
$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM form"))['count'];
$totalEvents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM events"))['count'];
$totalReports = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM event_reports"))['count'];
$totalContacts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM contact_messages"))['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | VEMS360</title>
  <link rel="icon" href="../assets/images/logo.png" />
  <link rel="stylesheet" href="assets/css/admin.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

  <aside class="sidebar">
    <div class="logo">
      <img src="../assets/images/logo.png" alt="Logo">
      <h2>VEMS360 Admin</h2>
    </div>
    <ul class="menu">
      <li><a href="dashboard.php" class="active"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
      <li><a href="manage_user.php"><i class="fa-solid fa-users"></i> Manage Users</a></li>
      <li><a href="manage_events.php"><i class="fa-solid fa-calendar"></i> Manage Events</a></li>
      <li><a href="manage_reports.php"><i class="fa-solid fa-flag"></i> Reports</a></li>
      <li><a href="contact_messages.php"><i class="fa-solid fa-envelope"></i> Messages</a></li>
      <li><a href="ratings.php"><i class="fa-solid fa-star"></i> Ratings</a></li>
      <li><a href="profile.php"><i class="fa-solid fa-user"></i> Profile</a></li>
      <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
    </ul>
  </aside>

  <main class="dashboard">
    <h1>Admin Dashboard</h1>

    <div class="stats">
      <div class="card">
        <i class="fa-solid fa-users"></i>
        <h3>Total Users</h3>
        <p><?= $totalUsers ?></p>
      </div>
      <div class="card">
        <i class="fa-solid fa-calendar"></i>
        <h3>Total Events</h3>
        <p><?= $totalEvents ?></p>
      </div>
      <div class="card">
        <i class="fa-solid fa-flag"></i>
        <h3>Total Reports</h3>
        <p><?= $totalReports ?></p>
      </div>
      <div class="card">
        <i class="fa-solid fa-envelope"></i>
        <h3>Messages</h3>
        <p><?= $totalContacts ?></p>
      </div>
    </div>
  </main>

</body>
</html>
