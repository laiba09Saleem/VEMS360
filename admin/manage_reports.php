<?php
session_start();
require_once __DIR__ . '/../config/connection.php';

/*
// Allow only admin access
if (!isset($_SESSION['User_ID']) || $_SESSION['Role'] !== 'Admin') {
    header("Location: ../pages/login.php");
    exit;
}
*/

// ✅ Fetch ratings with event name
$query = "
    SELECT 
        r.id,
        e.title AS event_name,
        r.user_name,
        r.rating,
        r.comment,
        r.created_at
    FROM event_ratings r
    LEFT JOIN events e ON r.event_id = e.id
    ORDER BY r.created_at DESC
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Ratings | VEMS360 Admin</title>
  <link rel="icon" href="../assets/images/logo.png">
  <link rel="stylesheet" href="assets/css/admin.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: "Poppins", sans-serif;
      background: #0d1117;
      color: #e6edf3;
      padding: 20px;
    }

    h1 {
      text-align: center;
      color: #2a9d8f;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #161b22;
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #30363d;
      text-align: center;
    }

    th {
      background: #2a9d8f;
      color: #fff;
    }

    tr:hover {
      background: #1f252d;
    }

    .rating-stars {
      color: #f4c430;
    }

    .no-data {
      text-align: center;
      color: #999;
      font-style: italic;
    }
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
      <li><a href="manage_events.php"><i class="fa-solid fa-calendar"></i> Manage Events</a></li>
      <li><a href="manage_reports.php" class="active"><i class="fa-solid fa-flag"></i> Reports</a></li>
      <li><a href="ratings.php"><i class="fa-solid fa-star"></i> Ratings</a></li>
      <li><a href="contact_messages.php"><i class="fa-solid fa-envelope"></i> Messages</a></li>
      <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
    </ul>
  </aside>
<main class="dashboard">
  <h1>Manage Ratings</h1>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Event Title</th>
        <th>User Name</th>
        <th>Rating</th>
        <th>Comment</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['event_name']) ?></td>
            <td><?= htmlspecialchars($row['user_name']) ?></td>
            <td>
              <?php
                $stars = intval($row['rating']);
                for ($i = 1; $i <= 5; $i++) {
                    echo $i <= $stars ? "<i class='fa-solid fa-star rating-stars'></i>" : "<i class='fa-regular fa-star rating-stars'></i>";
                }
              ?>
            </td>
            <td><?= htmlspecialchars($row['comment']) ?></td>
            <td><?= htmlspecialchars($row['created_at']) ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="6" class="no-data">No ratings found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</main>
</body>
</html>
