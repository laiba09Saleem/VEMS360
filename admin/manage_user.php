<?php
session_start();
require_once __DIR__ . '/../config/connection.php';

// Security check (only Admin can access)
/*if (!isset($_SESSION['User_ID']) || $_SESSION['Role'] !== 'Admin') {
    header("Location: ../pages/login.php");
    exit();
} */

// Delete user if requested
if (isset($_GET['delete'])) {
    $userId = intval($_GET['delete']);
    $deleteQuery = "DELETE FROM form WHERE id = $userId";
    mysqli_query($conn, $deleteQuery);
    header("Location: manage_users.php");
    exit();
}

// Change role
if (isset($_GET['role']) && isset($_GET['id'])) {
    $userId = intval($_GET['id']);
    $newRole = mysqli_real_escape_string($conn, $_GET['role']);
    $updateQuery = "UPDATE form SET Role = '$newRole' WHERE id = $userId";
    mysqli_query($conn, $updateQuery);
    header("Location: manage_users.php");
    exit();
}

// Fetch all users
$query = "SELECT id, Username, Email, Role, Created_At FROM form ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Users | VEMS360 Admin</title>
  <link rel="icon" href="../assets/images/logo.png" />
  <link rel="stylesheet" href="assets/css/admin.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="logo">
      <img src="../assets/images/logo.png" alt="Logo">
      <h2>VEMS360 Admin</h2>
    </div>
    <ul class="menu">
      <li><a href="dashboard.php"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
      <li><a href="manage_users.php" class="active"><i class="fa-solid fa-users"></i> Manage Users</a></li>
      <li><a href="manage_events.php"><i class="fa-solid fa-calendar"></i> Manage Events</a></li>
      <li><a href="manage_reports.php"><i class="fa-solid fa-flag"></i> Reports</a></li>
      <li><a href="contact_messages.php"><i class="fa-solid fa-envelope"></i> Messages</a></li>
      <li><a href="ratings.php"><i class="fa-solid fa-star"></i> Ratings</a></li>
      <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
    </ul>
  </aside>

  <!-- Main Content -->
  <main class="dashboard">
    <h1>Manage Users</h1>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['Username']) ?></td>
              <td><?= htmlspecialchars($row['Email']) ?></td>
              <td><?= htmlspecialchars($row['Role']) ?></td>
              <td><?= htmlspecialchars($row['Created_At']) ?></td>
              <td>
                <?php if ($row['Role'] !== 'Admin'): ?>
                  <a href="manage_users.php?role=Organizer&id=<?= $row['id'] ?>" class="btn small primary">Make Organizer</a>
                  <a href="manage_users.php?role=User&id=<?= $row['id'] ?>" class="btn small outline">Make User</a>
                  <a href="manage_users.php?delete=<?= $row['id'] ?>" class="btn small danger" onclick="return confirm('Are you sure you want to delete this user?')"><i class="fa-solid fa-trash"></i></a>
                <?php else: ?>
                  <span class="badge admin">Admin</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </main>

</body>
</html>
