<?php
session_start();
require_once __DIR__ . '/../config/connection.php';
/*
// Step 1: Only Admin Access
if (!isset($_SESSION['Role']) || $_SESSION['Role'] !== 'Admin') {
    header("Location: ../pages/login.php");
    exit();
}
*/
// Step 2: Handle Status Update
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action === 'approve') {
        $query = "UPDATE events SET status = 'Approved' WHERE id = $id";
    } elseif ($action === 'reject') {
        $query = "UPDATE events SET status = 'Rejected' WHERE id = $id";
    } elseif ($action === 'delete') {
        $query = "DELETE FROM events WHERE id = $id";
    }

    if (isset($query)) {
        mysqli_query($conn, $query);
        header("Location: manage_events.php");
        exit();
    }
}

// Step 3: Fetch All Events with Organizer Info
$query = "
    SELECT 
        e.id, 
        e.title, 
        e.event_type, 
        e.location, 
        e.date, 
        e.status, 
        f.Username AS organizer
    FROM events e
    LEFT JOIN form f ON e.created_by = f.ID
    ORDER BY e.id DESC
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Events | Admin Panel</title>
  <link rel="icon" href="../assets/images/logo.png">
  <link rel="stylesheet" href="assets/css/admin.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>

    table {
      width: 100%;
      border-collapse: collapse;
      background: #161b22;
      border-radius: 10px;
      overflow: hidden;
    }
    th, td {
      padding: 12px 15px;
      border-bottom: 1px solid #30363d;
      text-align: left;
    }
    th {
      background-color: #21262d;
      color: #2a9d8f;
    }
    tr:hover {
      background: #1c2128;
    }
    .btn {
      padding: 6px 12px;
      border-radius: 6px;
      text-decoration: none;
      font-size: 14px;
      color: white;
      transition: 0.3s;
      margin-right: 5px;
    }
    .approve { background-color: #2a9d8f; }
    .reject { background-color: #e63946; }
    .delete { background-color: #6c757d; }
    .btn:hover { opacity: 0.8; }
    .status {
      font-weight: 500;
      text-transform: capitalize;
    }
    .status.Pending { color: #ffb703; }
    .status.Approved { color: #2a9d8f; }
    .status.Rejected { color: #e63946; }
  </style>
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
      <li><a href="manage_events.php" class="active"><i class="fa-solid fa-calendar"></i> Manage Events</a></li>
      <li><a href="manage_reports.php"><i class="fa-solid fa-flag"></i> Reports</a></li>
      <li><a href="ratings.php"><i class="fa-solid fa-star"></i> Ratings</a></li>
      <li><a href="contact_messages.php"><i class="fa-solid fa-envelope"></i> Messages</a></li>
      <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
    </ul>
  </aside>
  <main class="dashboard">
  <h1>Manage Events</h1>

  <table>
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Organizer</th>
      <th>Date</th>
      <th>Status</th>
      <th>Action</th>
    </tr>

    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
          <td><?= htmlspecialchars($row['title']) ?></td>
          <td><?= htmlspecialchars($row['organizer'] ?? 'Unknown') ?></td>
          <td><?= htmlspecialchars($row['date']) ?></td>
          <td class="status <?= htmlspecialchars($row['status']) ?>"><?= htmlspecialchars($row['status']) ?></td>
          <td>
            <a href="?action=approve&id=<?= $row['id'] ?>" class="btn approve">Approve</a>
            <a href="?action=reject&id=<?= $row['id'] ?>" class="btn reject">Reject</a>
            <a href="?action=delete&id=<?= $row['id'] ?>" class="btn delete">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="6" style="text-align:center;">No events found.</td></tr>
    <?php endif; ?>
  </table>
    </main>
</body>
</html>
