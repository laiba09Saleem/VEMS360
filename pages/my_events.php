<?php
session_start();
require_once __DIR__ . '/../config/connection.php';
// Restrict access to logged-in users only
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // redirect to login if not logged in
    exit();
}

// Temporary user_id for testing if session not set
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
}

$user_id = $_SESSION['user_id'];

// Fetch all events created by this user
$query = "SELECT * FROM events WHERE created_by = ? ORDER BY id DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Events | VEMS360</title>
  <link rel="icon" href="../assets/images/logo.png">
  <link rel="stylesheet" href="../assets/css/my_event.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<!-- NAVBAR -->
<header class="navbar">
  <div class="logo">
    <img src="../assets/images/logo.png" alt="VEMS360 Logo">
    <h2>VEMS360</h2>
  </div>
  <nav class="nav-links">
    <a href="welcome.php">Home</a>
    <a href="about.php">About</a>
    <a href="event.php">Events</a>
    <a href="my_event.php" class="active">My Events</a>
    <a href="contact.php">Contact</a>
  </nav>
</header>

<!-- HERO SECTION -->
<section class="hero">
  <div class="overlay"></div>
  <div class="hero-content">
    <h1>My <span>Created Events</span></h1>
    <p>Manage all your events in one place.</p>
  </div>
</section>

<!-- EVENT MANAGEMENT SECTION -->
<section class="my-events-section">
  <div class="container">
    <h2>Events You Created</h2>

    <?php if ($result->num_rows > 0): ?>
      <div class="my-events-grid">
        <?php while ($row = $result->fetch_assoc()): ?>
          <?php
            $imagePath = "../assets/images/events/" . htmlspecialchars($row['image']);
            if (empty($row['image']) || !file_exists($imagePath)) {
              $imagePath = "../assets/images/default.jpg";
            }
          ?>
          <div class="event-card">
            <img src="<?= $imagePath; ?>" alt="<?= htmlspecialchars($row['title']); ?>">
            <div class="event-info">
              <h3><?= htmlspecialchars($row['title']); ?></h3>
              <p><i class="fa-solid fa-layer-group"></i> <?= htmlspecialchars($row['event_type']); ?></p>
              <p><i class="fa-solid fa-calendar-days"></i> <?= htmlspecialchars($row['date']); ?></p>
              <div class="actions">
                <a href="event_details.php?id=<?= $row['id']; ?>" class="btn view"><i class="fa-solid fa-eye"></i> View</a>
                <a href="edit_event.php?id=<?= $row['id']; ?>" class="btn edit"><i class="fa-solid fa-pen"></i> Edit</a>
                <a href="delete_event.php?id=<?= $row['id']; ?>" class="btn delete" onclick="return confirm('Are you sure you want to delete this event?');">
                  <i class="fa-solid fa-trash"></i> Delete
                </a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p class="no-events">You haven’t created any events yet. <a href="create_event.php">Create one now!</a></p>
    <?php endif; ?>
  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
  <div class="footer-content">
    <div class="footer-about">
      <img src="../assets/images/logo.png" alt="VEMS360 Logo">
      <p>VEMS360 — Manage your events smartly and professionally.</p>
    </div>
    <div class="footer-links">
      <h4>Quick Links</h4>
      <a href="about.php">About</a>
      <a href="contact.php">Contact</a>
      <a href="privacy.php">Privacy Policy</a>
    </div>
    <div class="footer-social">
      <h4>Follow Us</h4>
      <a href="#"><i class="fab fa-facebook"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
    </div>
  </div>
  <p class="copyright">&copy; 2025 VEMS360. All rights reserved.</p>
</footer>

</body>
</html>
