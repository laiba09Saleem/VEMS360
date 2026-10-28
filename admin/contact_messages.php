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

// Fetch all contact messages
$query = "SELECT id, name, email, subject, message, created_at FROM contact_messages ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Messages | VEMS360 Admin</title>
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
      <li><a href="contact_messages.php" class="active"><i class="fa-solid fa-envelope"></i> Messages</a></li>
      <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
    </ul>
  </aside>

  <!-- Main Content -->
  <main class="dashboard">
    <h1>Manage Messages</h1>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['subject']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                <td><?= htmlspecialchars($row['created_at']) ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="6" class="no-data">No messages found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>

</body>
</html>
